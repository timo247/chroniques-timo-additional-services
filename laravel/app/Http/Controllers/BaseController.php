<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    //transform model to string readable by human
    public  static function modelToReadableString($model)
    {
        $attributes = $model->getAttributes();
        $attributesAsString = '{';
        foreach ($attributes as $key => $value) {
            $attributesAsString .= ucfirst(str_replace('_', ' ', $key)) . ': ' . $value . "\n";
        }
        $attributesAsString .= '}';
        return $attributesAsString;
    }
}
