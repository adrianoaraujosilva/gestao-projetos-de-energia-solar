<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if (($exception instanceof HttpException && $exception->getStatusCode() == 403) || $exception instanceof AuthorizationException) {
            return response()->json(["message" => "This action is unauthorized.", "code" => 403], 403);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json(
                [
                    "message" => Str::of("Nenhum resultado de consulta para o ? de ID: ?")
                        ->replaceArray('?', [
                            Str::afterLast($exception->getModel(), "\\"),
                            collect($exception->getIds())->implode(',')
                        ]),
                    "code" => 404
                ],
                404
            );
        }

        return parent::render($request, $exception);
    }
}
