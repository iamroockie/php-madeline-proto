<?php

namespace App;

class Response
{
    public static function error(string $message): string
    {
        return json_encode(['success' => false, 'error' => $message]);
    }

    public static function success(array $data = []): string
    {
        $response = ['success' => true];

        if ($data) {
            $response['data'] = $data;
        }

        return json_encode($response);
    }
}
