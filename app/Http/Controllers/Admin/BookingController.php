<?php

namespace App\Http\Controllers\Admin;

use App\Models\GuestsInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\PropertyController;
use App\Models\PropertyBooking;
use App\Models\BookingPayments;
use App\Services\Logger;

use DB;
use Helper;

class BookingController extends BaseController
{
    public function index(Request $request)
    {
        $limit = 100;
        $skip = ($request->page || 0) * $limit;

        $bookings = DB::table('property_booking')
            ->select(
                'property_booking.*',
                'owner.first_name as owner_first_name',
                'traveller.first_name as traveller_first_name',
                'owner.last_name as owner_last_name',
                'traveller.last_name as traveller_last_name',
                'property.title as property_title',
            )
            ->leftJoin('users as owner', 'owner.id', '=', 'property_booking.owner_id')
            ->leftJoin('users as traveller', 'traveller.id', '=', 'property_booking.traveller_id')
            ->leftJoin('property_list as property', 'property.id', '=', 'property_booking.property_id')
            ->orderBy('property_booking.id', 'desc')
            ->paginate(100);

        // $booking_count = DB::table('property_booking')->count();

        return view('Admin.bookings', compact('bookings'));
    }

    public function extract_ids($data)
    {
        return $data
            ->map(function ($entry) {
                return $entry->id;
            })
            ->all();
    }

    public function filter_payments($payments, $status)
    {
        return $payments->filter(function ($payment) use ($status) {
            return $payment->status == $status;
        });
    }

    public function booking_details(Request $request)
    {
        $booking = PropertyBooking::find($request->id);
        $guest_info = GuestsInformation::where('booking_id', $booking->booking_id)->get();
        $booking->agency = implode(", ", array_filter([$booking->name_of_agency, $booking->other_agency])); // Booking Agency
        $owner = $booking->owner;
        $traveler = $booking->traveler;
        $property = $booking->property;
        if ($booking->cancelled_by == 'Admin') {
            $cancelled_by = 'Admin';
        } elseif ($booking->cancelled_by == $owner->id) {
            $cancelled_by = $owner->first_name . ' ' . $owner->last_name;
        } else {
            $cancelled_by = $traveler->first_name . ' ' . $traveler->last_name;
        }
        $lastPaidByTraveler = null;
        $lastPaidToOwner = null;
        $travelerPaymentInProcessing = null;
        $ownerPaymentInProcessing = null;
        $traveler_total = 0;
        $owner_total = 0;
        $payments = BookingPayments::where('booking_row_id', $request->id)->get();
        foreach ($payments as $payment) {
            if ($payment->status == PAYMENT_SUCCESS) {
                if ($payment->is_owner) {
                    $owner_total += $payment->total_amount + $payment->service_tax;
                    if (empty($lastPaidToOwner)) {
                        $lastPaidToOwner = $payment;
                    } elseif ($payment->payment_cycle > $lastPaidToOwner->payment_cycle) {
                        $lastPaidToOwner = $payment;
                    }
                } else {
                    $traveler_total += $payment->total_amount + $payment->service_tax;
                    if (empty($lastPaidByTraveler)) {
                        $lastPaidByTraveler = $payment;
                    } elseif ($payment->payment_cycle > $lastPaidByTraveler->payment_cycle) {
                        $lastPaidByTraveler = $payment;
                    }
                }
            }
            $sign = $payment->is_owner ? '+$' : '-$';
            $payment->display_cleaning_fee = $payment->payment_cycle === 1 ? $sign . $payment->cleaning_fee : '-';
            $payment->display_security_deposit =
                $payment->payment_cycle === 1 && !$payment->is_owner ? $sign . $payment->security_deposit : '-';
            $net_monthly_rate = $payment->is_partial_days
                ? round(($payment->monthly_rate * $payment->is_partial_days) / 30)
                : $payment->monthly_rate;
            $payment->display_monthly_rate = $sign . $net_monthly_rate;
            if ($payment->is_owner) {
                $payment->display_total_amount = PropertyController::format_amount(
                    $payment->total_amount - $payment->service_tax,
                );
            } else {
                $payment->display_total_amount = PropertyController::format_amount(
                    $payment->total_amount + $payment->service_tax,
                    '-',
                );
            }
        }
        $paymentInProcessing = $this->filter_payments($payments, PAYMENT_INIT);
        $paymentsInProcessing = $this->extract_ids($paymentInProcessing);
        // NOTE: Checking if the transfer is allowed to cancel: Implemented based on details from here: https://discuss.dwolla.com/t/cancelling-transaction-returning-400-status/5208
        $hasPaymentsInProcessing = count($paymentsInProcessing) > 0;
        $canPaymentsCanceled = false;
        if ($hasPaymentsInProcessing) {
            $latestInProgress = BookingPayments::where('booking_row_id', $request->id)
                ->orderBy('processed_time', 'DESC')
                ->first();
            $transferDetails = $this->dwolla->transfersApi->byId($latestInProgress->transfer_url);
            if ($transferDetails && $transferDetails->_links && $transferDetails->_links['cancel']) {
                $canPaymentsCanceled = true;
            }
        }
        return view(
            'Admin.booking_detail',
            compact(
                'booking',
                'payments',
                'owner',
                'traveler',
                'property',
                'cancelled_by',
                'lastPaidByTraveler',
                'lastPaidToOwner',
                'traveler_total',
                'owner_total',
                'paymentsInProcessing',
                'hasPaymentsInProcessing',
                'canPaymentsCanceled',
                'guest_info',
            ),
        );
    }

    public function cancel_payments_processing(Request $request)
    {
        $ids = $request->query('payments');
        if (empty($ids)) {
            return back()->with([
                'success_cancel_booking' => false,
                'errorMessage' => 'No payments specified for cancellation',
            ]);
        }
        if (count($ids) < 1) {
            return back()->with([
                'success_cancel_booking' => false,
                'errorMessage' => 'No payments specified for cancellation',
            ]);
        }
        $payments = BookingPayments::findMany($ids);
        $errorCount = 0;
        foreach ($payments as $payment) {
            try {
                $this->dwolla->cancelTransfer($payment->transfer_url);
                $payment->status = PAYMENT_CANCELED;
                $payment->canceled_at = now();
                $payment->save();
            } catch (\Exception $ex) {
                Logger::error(
                    'Error in canceling payment: payment id' . $payment->id . '. EX: ' . $ex->getResponseBody(),
                );
                $errorCount++;
            }
        }
        if ($errorCount) {
            return back()->with([
                'success_cancel_booking' => false,
                'errorMessage' => 'Error in cancelling payments',
            ]);
        }
        return back()->with([
            'success_cancel_booking' => true,
            'successMessage' => 'Processing payments are been cancelled',
        ]);
    }

    public function pause_auto_deposit($id, Request $request)
    {
        $id = $request->id;
        $booking = PropertyBooking::find($id);
        if (empty($booking)) {
            return back()->with([('success')->false, 'errorMessage' => 'No such booking exists!']);
        }
        $booking->should_auto_deposit = 0;
        $booking->save();
        return back()->with([
            'success' => true,
            'successMessage' => 'Auto handling of Security deposit is turned off for this booking',
        ]);
    }

    public function settle_deposit(Request $request)
    {
        $id = $request->id;
        $booking = PropertyBooking::find($id);
        if (empty($booking)) {
            return back()->with([('success')->false, 'errorMessage' => 'No such booking exists!']);
        }
        if ($booking->is_deposit_handled) {
            Logger::error('Security deposit was already handled: ' . $id);
            return back()->with(['success' => false, 'errorMessage' => 'Security deposit was already handled']);
        }
        if ($request->traveler_cut + $request->owner_cut != $booking->security_deposit) {
            return back()->with([
                'success' => false,
                'errorMessage' => 'Sum of owner and traveler cut should be equal to Security deposit',
            ]);
        }
        $booking->should_auto_deposit = 0;
        $booking->is_deposit_handled_by_admin = 1;
        $booking->traveler_cut = $request->traveler_cut;
        $booking->owner_cut = $request->owner_cut;
        $booking->admin_remarks = $request->admin_remarks;
        $booking->traveler_remarks = $request->traveler_remarks;
        $booking->owner_remarks = $request->owner_remarks;
        $booking->save();
        $res = Helper::processSecurityDepositForBooking($booking->id);
        return back()->with($res);
    }
}
