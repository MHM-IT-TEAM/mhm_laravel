<?php


namespace App\Providers;



use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Response::macro('success', function ($data=null) {
            return Response::json([
                'errors'  => false,
                'success'=>true,
                'data' => $data,
            ]);
        });

        Response::macro('error', function ($message=null, $status = 400) {
            return Response::json([
                'errors'  => true,
                'success'=>false,
                'message' => $message,
            ], $status);
        });
    }
}
