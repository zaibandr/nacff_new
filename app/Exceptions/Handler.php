<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use BadMethodCallException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;

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
        BadMethodCallException::class,
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
        return parent::report($e);
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
    //    if ($e instanceof ModelNotFoundException) {
    //        $e = new NotFoundHttpException($e->getMessage(), $e);
    //    }
    //    if ($e instanceof BadMethodCallException)
    //    {
    //        return \Redirect::to('404');
    //    }
    //    if ($e instanceof TokenMismatchException) {
    //        return \Redirect::to('main');
    //    }
      //  if ($e instanceof NotFoundHttpException) {
      //      return \Redirect::to('404');
      //  }

        return parent::render($request, $e);
    }
}
