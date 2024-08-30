<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function apiSuccess($message, $data, $statusCode)
    {
        return response()->json(['message' => $message, 'data' => $data], $statusCode);
    }
    protected function apiError($message, $errors, $statusCode)
    {
        return response()->json(['message' => $message, 'errors' => $errors], $statusCode);
    }
}
