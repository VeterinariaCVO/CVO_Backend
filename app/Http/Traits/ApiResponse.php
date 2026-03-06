<?php

namespace App\Http\Traits;

trait ApiResponse
{
    protected function success(
        $data = null,
        string $message = 'Operacion exitosa',
        int $code = 200
    ){
        return response()->json([
            "status" => true,
            "message" => $message,
            "data" => $data,
            "error" => null
        ], $code);
    }

    protected function error(
        string $message = 'Error',
        int $code = 400,
               $error = null
    ){
        return response()->json([
            "status" => false,
            "message" => $message,
            "data" => null,
            "error" => $error
        ], $code);
    }
}
