<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

	/**
	 * Faz o tratamento de exceções no Laravel
	 *
	 * @param [type] $request
	 * @param Throwable $e
	 * @return Response
	 */
	public function render($request, Throwable $e) {
		if ($request->is("api/*")) {
			if ($e instanceof ValidationException) {
				return response()->json([
					"HTTP" => 400,
					"código" => "validação_erro",
					"mensagem" => "Erro de validação dos dados enviados",
				] + $e->errors(), 400);
			}
		}
		return parent::render($request, $e);
	}
}
