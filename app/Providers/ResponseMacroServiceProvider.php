<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function (mixed $data, string $message="ok",int $statusCode=200) {
            return Response::json([
                'data' => $data,
                'success' => true,
                'message' => $message
            ], $statusCode);
        });

        Response::macro('error', function (string $message, int $statusCode=422) {
            return Response::json([
                'data' => null,
                'success' => false,
                'message'=> $message,
            ], $statusCode);
        });

    }
}
