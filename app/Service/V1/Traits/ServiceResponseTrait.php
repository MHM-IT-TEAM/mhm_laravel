<?php


namespace App\Service\V1\Traits;


trait ServiceResponseTrait
{
    public function success($msg){
        return response()->json([
            'success'=>true,
            'msg'=>$msg
        ]);
    }

    public function failure($msg){
        return response()->json([
            'success'=>false,
            'msg'=>$msg
        ]);
    }

}
