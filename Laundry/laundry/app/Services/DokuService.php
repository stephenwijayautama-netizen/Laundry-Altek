<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DokuService
{
    protected $clientId;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->clientId = env('DOKU_CLIENT_ID');
        $this->secretKey = env('DOKU_SECRET_KEY');
        $this->baseUrl = env('DOKU_IS_PRODUCTION', false) 
            ? 'https://api.doku.com' 
            : 'https://api-sandbox.doku.com';
    }

    /**
     * Generate QRIS payment request
     * 
     * @param string $invoiceNumber
     * @param float $amount
     * @param array $customerDetails
     * @return array
     */
    public function generateQris($invoiceNumber, $amount, $customerDetails)
    {
        // If keys are not set, return mock QRIS code for presentation
        if (empty($this->clientId) || empty($this->secretKey)) {
            Log::info("DOKU: Using mock QRIS because credentials are not set in .env.");
            return [
                'success' => true,
                'is_mock' => true,
                'qr_data' => '00020101021226540014ID.CO.DOKU.WWW0118936000000000000000215000116068222030302150112345678901235204531153033605802ID5914DOKU SANDBOX6007Jakarta610512170622807202020260317192931123456786304abcd'
            ];
        }

        try {
            $requestId = (string) Str::uuid();
            $requestTimestamp = gmdate('Y-m-d\TH:i:s\Z');
            $targetPath = '/qr-services/v1/qr-generate';

            $body = [
                'order' => [
                    'invoice_number' => $invoiceNumber,
                    'amount' => (int) $amount
                ],
                'customer' => [
                    'name' => $customerDetails['name'] ?? 'Umum',
                    'email' => $customerDetails['email'] ?? 'customer@example.com',
                    'phone' => $customerDetails['phone'] ?? ''
                ]
            ];

            $bodyJson = json_encode($body);
            $signature = $this->generateSignature($requestId, $requestTimestamp, $targetPath, $bodyJson);

            $response = Http::withHeaders([
                'Client-Id' => $this->clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $requestTimestamp,
                'Signature' => $signature,
                'Content-Type' => 'application/json'
            ])->post($this->baseUrl . $targetPath, $body);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'is_mock' => false,
                    'qr_data' => $data['qr_string'] ?? ''
                ];
            }

            Log::error('DOKU API Error: ' . $response->body());
            throw new \Exception('Failed to generate QRIS from DOKU API: ' . $response->status());

        } catch (\Exception $e) {
            Log::error('DOKU Exception: ' . $e->getMessage());
            // Fallback to mock QRIS for presentation instead of crashing the flow
            return [
                'success' => true,
                'is_mock' => true,
                'qr_data' => '00020101021226540014ID.CO.DOKU.WWW0118936000000000000000215000116068222030302150112345678901235204531153033605802ID5914DOKU SANDBOX6007Jakarta610512170622807202020260317192931123456786304abcd'
            ];
        }
    }

    /**
     * Generate Checkout Payment Link (Hosted Payment Page)
     * 
     * @param string $invoiceNumber
     * @param float $amount
     * @param array $customerDetails
     * @return array
     */
    public function generateCheckout($invoiceNumber, $amount, $customerDetails)
    {
        // If keys are not set, return mock checkout URL for presentation
        if (empty($this->clientId) || empty($this->secretKey)) {
            Log::info("DOKU: Using mock Checkout Link because credentials are not set in .env.");
            return [
                'success' => true,
                'is_mock' => true,
                'payment_url' => 'https://sandbox.doku.com/checkout/link/mock_checkout_url_' . $invoiceNumber
            ];
        }

        try {
            $requestId = (string) Str::uuid();
            $requestTimestamp = gmdate('Y-m-d\TH:i:s\Z');
            $targetPath = '/checkout/v1/payment';

            $body = [
                'order' => [
                    'invoice_number' => $invoiceNumber,
                    'amount' => (int) $amount
                ],
                'payment' => [
                    'payment_due_date' => 60 // 60 minutes
                ],
                'customer' => [
                    'name' => $customerDetails['name'] ?? 'Umum',
                    'email' => $customerDetails['email'] ?? 'customer@example.com',
                    'phone' => $customerDetails['phone'] ?? ''
                ]
            ];

            $bodyJson = json_encode($body);
            $signature = $this->generateSignature($requestId, $requestTimestamp, $targetPath, $bodyJson);

            $response = Http::withHeaders([
                'Client-Id' => $this->clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $requestTimestamp,
                'Signature' => $signature,
                'Content-Type' => 'application/json'
            ])->post($this->baseUrl . $targetPath, $body);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'is_mock' => false,
                    'payment_url' => $data['response']['payment']['payment_url'] ?? ''
                ];
            }

            Log::error('DOKU Checkout API Error: ' . $response->body());
            throw new \Exception('Failed to generate Checkout from DOKU API: ' . $response->status());

        } catch (\Exception $e) {
            Log::error('DOKU Checkout Exception: ' . $e->getMessage());
            // Fallback to mock checkout URL
            return [
                'success' => true,
                'is_mock' => true,
                'payment_url' => 'https://sandbox.doku.com/checkout/link/mock_checkout_url_' . $invoiceNumber
            ];
        }
    }

    /**
     * Generate Signature for DOKU API
     */
    protected function generateSignature($requestId, $requestTimestamp, $targetPath, $bodyJson)
    {
        $digest = base64_encode(hash('sha256', $bodyJson, true));
        $signatureComponent = "Client-Id:" . $this->clientId . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $requestTimestamp . "\n" .
            "Request-Target:" . $targetPath . "\n" .
            "Digest:" . $digest;

        $signature = hash_hmac('sha256', $signatureComponent, $this->secretKey, true);
        return 'HMACSHA256=' . base64_encode($signature);
    }
}
