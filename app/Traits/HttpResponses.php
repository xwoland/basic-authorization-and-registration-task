<?php

namespace App\Traits;

trait HttpResponses {

    /**
     * Response of the success API Response
     * 
     * @param string $access_token
     * @param array  $user_info
     * @param string $error
     * @param string $error_key
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    protected function success($access_token, $user_info, $error = '', $error_key = '')
    {
        return response()->json([
            'access_token' => $access_token,
            'user_info'    => $user_info,
            'error'        => $error,
            'error_key'    => $error_key
        ]);
    }

    /**
     * Response of the failure API Response
     * 
     * @param string $error
     * @param string $error_key
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    protected function error($error, $error_key)
    {
        return response()->json([
            'error' => $error,
            'error_key' => $error_key
        ]);
    }
}