<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePriceValuesToInt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_list', function (Blueprint $table) {
            //
            $rows = DB::table('property_list')
                ->whereNotNull('id')
                ->where('is_complete', 1)
                ->get(['id', 'monthly_rate', 'security_deposit', 'cleaning_fee']);
            foreach ($rows as $row) {
                DB::table('property_list')
                    ->where('id', $row->id)
                    ->update([
                        'monthly_rate' => (int) $row->monthly_rate,
                        'security_deposit' => (int) $row->security_deposit,
                        'cleaning_fee' => (int) $row->cleaning_fee,
                    ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_list', function (Blueprint $table) {
            //
        });
    }
}
