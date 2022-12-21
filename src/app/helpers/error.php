<?php

use Illuminate\Support\Facades\Response;

function errorResponse($code, $status, $message)
{
    $data = [
        'meta' =>
        [
            'code' => $code,
            'status' => $status,
            'error' => $message
        ],


    ];
    return Response::json($data, $code);
}