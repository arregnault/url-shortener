<?php

namespace App\Shared\Traits;


trait HttpResponse
{


    /**
     * Build a success response
     *
     * @param mixed $data Response data
     * @param int   $code Response code/status
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $code=200)
    {
        $response = [
            'code'   => $code,
            'data'   => $data,
            'status' => 'success',
        ];
        return response()->json($response, $code);

    }//end successResponse()


    /**
     * Build an error response
     *
     * @param int|bool|string|array $messages Error messages
     * @param int                   $code     Error code/status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code=400)
    {
        $response = [
            'code'    => $code,
            'message' => $message,
            'status'  => 'error',
        ];
        return response()->json($response, $code);

    }//end errorResponse()


}
