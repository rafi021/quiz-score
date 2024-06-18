<?php

namespace App\Traits;

trait ApiResponse
{
    public function ResponseSuccess(
        $data,
        $metadata = null,
        $message = 'Successfull!',
        $status_code = 200,
        $status = true
    ) {
        return response()->json([
            'success' => $status,
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data,
            'metadata' => $metadata,
        ], $status_code);
    }

    public function ResponseError(
        $errors,
        $metadata = null,
        $message = 'Data Process Error!',
        $status_code = 400,
        $status = false
    ) {
        return response()->json([
            'success' => $status,
            'status_code' => $status_code,
            'message' => $message,
            'errors' => $errors,
            'metadata' => $metadata,
        ], $status_code);
    }
}
