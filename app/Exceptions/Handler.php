<?php

namespace App\Exceptions;

use App\Shared\Traits\HttpResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    use HttpResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(
            function (Throwable $exception) {
                if (method_exists($exception, 'exceptionToResponse')) {
                    return call_user_func_array([$exception, 'exceptionToResponse'], []);
                }

                return $this->errorResponse("Unexpected error. Try later", 500);
            }
        );

    }//end register()


}//end class
