<?php 

function send_error($status, $message, $messages = [], $code = 404)
{
    $response = [
        'status' => $status,
        'message' => $message,
        'status_code' => $code 
    ];

    $response['errors'] = !empty($messages) ? $message : null;

    return response()->json([$response], $code);
}   