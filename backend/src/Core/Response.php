<?php
namespace App\Core;

class Response
{
    public static function json($data, int $status = 200)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($status);
        echo json_encode([
            'success' => $status >= 200 && $status < 300,
            'data' => $data
        ]);
        exit;
    }
}