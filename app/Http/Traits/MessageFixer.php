<?php

namespace App\Http\Traits;

use Illuminate\Http\Response;

trait MessageFixer
{
    protected function createSuccess($feature, $message)
    {
        return response()->json([
            'message' => $feature . ' has created!',
            'type' => 'success',
            'data' => $message
        ], Response::HTTP_CREATED);
    }

    protected function updateSuccess($feature, $message)
    {
        return response()->json([
            'message' => $feature . ' has updated!',
            'type' => 'success',
            'data' => $message
        ], Response::HTTP_OK);
    }

    protected function statusSuccess($feature, $message)
    {
        return response()->json([
            'message' => $feature . ' has updated status!',
            'type' => 'success',
            'data' => $message
        ], Response::HTTP_OK);
    }

    protected function deleteSuccess($feature, $message)
    {
        return response()->json([
            'message' => $feature . ' has deleted!',
            'type' => 'success',
            'data' => $message
        ], Response::HTTP_OK);
    }

    protected function error($message)
    {
        return response()->json([
            'message' => $message->getMessage(),
            'type' => 'error',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
