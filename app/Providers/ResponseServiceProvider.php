<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data) {
            return response()->json([
                'success' => 'true',
                'message' => 'عملیات با موفقیت انجام شد',
                'data' => $data
            ]);
        });
        Response::macro('error', function ($error, $status_code) {
            return response()->json([
                'success' => 'false',
                'error' => $error
            ], $status_code);
        });
    }
}
