<?php

namespace App\Exceptions;

use App\Mail\SendExceptionMail;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Throwable;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	 * Report or log an exception.
	 *
	 * @param  \Throwable  $exception
	 * @return void
	 *
	 * @throws \Exception
	 */
	// public function register()
	// {
	// 	$this->reportable(function ($e) {
	// 	});
	// }
	public function report(Throwable $exception)
	{
		if ($this->shouldReport($exception) && env('APP_ENV') != 'local') {
			$this->sendEmail($exception);
		}
		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Throwable  $exception
	 * @return \Symfony\Component\HttpFoundation\Response
	 *
	 * @throws \Throwable
	 */
	public function render($request, Throwable $exception)
	{
		return parent::render($request, $exception);
	}
	public function sendEmail(Throwable $exception)

	{

		try {

			$e = FlattenException::create($exception);
			$handler = new HtmlErrorRenderer(true); // boolean, true raises debug flag...
			// $css = $handler->getStylesheet();
			$content = $handler->getBody($e);

			// $content['message'] = $exception->getMessage();

			// $content['file'] = $exception->getFile();

			// $content['line'] = $exception->getLine();

			// $content['trace'] = $exception->getTrace();

			// $content['url'] = request()->url();

			// $content['body'] = request()->all();

			// $content['ip'] = request()->ip();
			foreach (getAccountsToSentExceptionsFor() as $mail) {
				Mail::to($mail)->send(new SendExceptionMail($content));
			}
		} catch (Throwable $exception) {
			Log::error($exception);
		}
	}
}
