<?php

namespace App\Services;

class WhatsAppService
{
    public static function send($target, $pesan)
    {
        // $token = env('FONNTE_TOKEN');
        $token = "NXA2LKAMfwhw7F9afon7";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'target'  => $target,
                'message' => $pesan,
                'delay'   => '2',
            ],
            CURLOPT_HTTPHEADER => [
                "Authorization: $token"
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error    = curl_error($curl);

        curl_close($curl);

        return [
            'success' => !$error && $httpCode == 200,
            'response' => $response,
            'error' => $error,
        ];
    }
}
