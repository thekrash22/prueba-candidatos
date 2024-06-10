<?php

namespace App\Helpers;

class ApiResponseHelper
{
    public static function successResponse($result, $statusCode = 200, $message = ''){
        $response = [
            'meta'=> [
                'success'=>true,
                'error'=>[],
            ],
            'data' => $result

        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }
        return response()->json($response, $statusCode);
    }

    public static function getErrorFromRequest($message, $errors = [], $statusCode)
    {
        $response = [
            'meta' => [
                'success' => false,
                'message' => $message,
                'errors' => $errors,
            ]
        ];
        return response()->json($response, $statusCode);
    }

    public static function errorResponse($errors, $statusCode){
        if (!is_array($errors)) {
            $errors = [$errors];
        }
        $response = [
            'meta' => [
                'success' => false,
                'errors' => $errors,
            ]
        ];
        return response()->json($response, $statusCode);
    }
}
