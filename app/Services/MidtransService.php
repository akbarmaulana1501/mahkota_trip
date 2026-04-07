<?php

namespace App\Services;

use GuzzleHttp\Client;

class MidtransService
{

    public function createStaticVA($jamaah)
    {
        if ($jamaah->va_number) {
            return $jamaah->va_number;
        }

        $client = new Client();

        $orderId = 'VA-JAMAAH-' . $jamaah->id;

        $response = $client->post('https://api.sandbox.midtrans.com/v2/charge', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode(config('midtrans.server_key') . ':'),
            ],
            'json' => [
                "payment_type" => "bank_transfer",

                "transaction_details" => [
                    "order_id" => $orderId,
                    "gross_amount" => 10000
                ],

                "bank_transfer" => [
                    "bank" => "bni"
                ],

                "custom_expiry" => [
                    "expiry_duration" => 5256000,
                    "unit" => "minute"
                ],

                "customer_details" => [
                    "first_name" => $jamaah->nama,
                    "email" => $jamaah->email ?? 'jamaah@email.com',
                    "phone" => $jamaah->no_hp ?? '08123456789'
                ]
            ]
        ]);

        $result = json_decode($response->getBody(), true);

        $va = $result['va_numbers'][0]['va_number'] ?? null;

        if ($va) {
            $jamaah->update([
                'va_number' => $va
            ]);
        }

        return $va;
    }
}
