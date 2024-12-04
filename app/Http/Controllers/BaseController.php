<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Success response method.
     */
    public function sendResponse($message, $result)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ];
  
        return response()->json($response, 200);
    }

    /**
     * Return error response.
     */
    public function sendError($errorMessages, $errorSpecific = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $errorMessages,
        ];
  
        if(!empty($errorSpecific)){
            $response['data'] = $errorSpecific;
        }
  
        return response()->json($response, $code);
    }
}
