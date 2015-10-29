<?php

namespace Tidy\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Raven_Client;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        $dsn = env('SENTRY_DSN');
        
        if(!empty($dsn) && env('APP_ENV') !== 'testing') {
            $client = new Raven_Client($dsn);
            $client->captureException($e);
        }
        
        
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        $statusCode = null;
        if($e instanceof NotFoundHttpException) {
            $statusCode = 404;
        }
        else {
            if(method_exists($e, 'getStatusCode')){
                $statusCode = $e->getStatusCode();
            }
        }
        
        if(!$statusCode) {
            $statusCode = 500;
        }


        $message = $e->getMessage();
        $code = $e->getCode();
        
        if($e instanceof TokenMismatchException) {
            $message = 'CSRF token mismatch';
        }
        
        if(empty($message)) {
            $message = 'system error: ' . get_class($e); 
        }

        $responseDetails = ['error' => $message, 'code' => $code];
        
        if (env('APP_DEBUG')) {
            $responseDetails['stacktrace'] = $e->getTraceAsString();
        }
        
        
        $response = response()->json(
            $responseDetails, 
            $statusCode);

        if ($request->is('api/*')) {
            app('Asm89\Stack\CorsService')->addActualRequestHeaders($response, $request);
        }
        
        return $response;
    }
}
