<?php


namespace App\Http\Traits;


trait ResponseTrait
{

    public function success($message = '',$data=[], $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => $message
        ], $code);
    }

    public function failed(string $message = '', int $statusCode=400): \Illuminate\Http\JsonResponse
    {
        return response()->json([

            'message' => $message
        ], $statusCode);
    }
}
