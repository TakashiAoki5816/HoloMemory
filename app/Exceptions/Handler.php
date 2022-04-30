<?php

namespace App\Exceptions;

use App\Exceptions\RedirectExceptions;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
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
        if ($exception instanceof RedirectExceptions) {
            return Redirect::To($exception->redirectTo)
                ->withErrors(['exception' => $exception->message, 'statusCode' => $exception->statusCode]);
        }

        return parent::render($request, $exception);
    }

    /**
     * HTTPエラーのレンダリング処理を共通化
     *
     * @param HttpExceptionInterface $exception
     * @return Response
     */
    protected function renderHttpException(HttpExceptionInterface $exception)
    {
        $image = $this->getRandImage();
        switch ($exception->getStatusCode()) {
            case 404:
                $message = "お探しのページは見つかりません。";
                $statusCode = "404 Not Found";
                break;
            case 419:
                $message = "CSRFトークンが一致していません。";
                $statusCode = "419 CSRF token mismatch";
                break;
            default:
                $message = "何らかのエラーが発生しました";
                $statusCode = $exception->getStatusCode();
        }

        return response()->view('errors/common', ['message' => $message, 'statusCode' => $statusCode, 'image' => $image]);
    }

    /**
     * エラー画像をランダムで取得
     *
     * @return string
     */
    protected function getRandImage()
    {
        $pathImages = glob('./images/*');
        $images = str_replace("./images/", "", $pathImages);
        $number = rand(0, count($images) - 1);

        return $images[$number];
    }
}
