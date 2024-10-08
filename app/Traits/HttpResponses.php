<?php

namespace App\Traits;

trait HttpResponses
{
    protected function success($data = null, $message = null, $status = null, $code = 200)
    {
        return response()->json([
            'status' => $status ?: "Request was successful",
            'message' => $message ?: 'Success',
            'data' => $data
        ], $code);
    }
    protected function error($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => "Error has occured",
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function internalServerError()
    {
        return response()->json([
            'status' => "Error has occured",
            'message' => 'Internal Server Error',
        ], 500);
    }
}
