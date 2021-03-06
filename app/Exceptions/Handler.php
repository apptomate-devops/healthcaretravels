<?php

namespace App\Exceptions;

use Mail;
use Exception;
use Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use App\Mail\ExceptionOccurred;
use App\Services\Logger;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            $this->sendEmail($exception);
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()
                ->back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', 'The form has expired due to inactivity. Please try again');
            // return redirect('/login')
            //         ->with('error', 'Your session has expired. Please log back in to continue.');
        }
        if (!defined("BASE_URL")) {
            define("BASE_URL", config('app.url') . '/');
        }
        if (!defined("APP_ENV")) {
            define("APP_ENV", env("APP_ENV", "local"));
        }
        if (!defined("GOOGLE_MAPS_API_KEY")) {
            define("GOOGLE_MAPS_API_KEY", config("services.google.maps_api_key"));
        }
        //return response()->view('errors.500');
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
    /**
     * Sends an email to the developer about the exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function sendEmail(Exception $exception)
    {
        try {
            $e = FlattenException::create($exception);
            $handler = new SymfonyExceptionHandler();
            $html = $handler->getHtml($e);
            $html = Request::url() . '<br>IP: ' . Request::ip() . '<br><br>' . $html;
            $emails = ['brijeshbhakta30@gmail.com', 'phpatel.4518@gmail.com'];
            // TODO: re-enable these emails when code is stable.
            // if (!in_array(config('app.env'), ['test', 'local'])) {
            //     $stage_emails_notify = [
            //         'info@healthcaretravels.com',
            //         'ldavis@healthcaretravels.com',
            //         'pashiofu@healthcaretravels.com',
            //         'dylan@arborvita.io',
            //         'garrethdottin1@gmail.com',
            //     ];
            //     foreach ($stage_emails_notify as $email) {
            //         array_push($emails, $email);
            //     }
            // }
            if (config('app.env') !== 'local') {
                Mail::to($emails)->send(new ExceptionOccurred($html));
                Logger::info('Error emails sent');
            }
        } catch (Exception $ex) {
            Logger::error('Error sending error emails');
            dd($ex);
        }
    }
}
