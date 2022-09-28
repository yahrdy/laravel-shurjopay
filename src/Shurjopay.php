<?php

namespace Yahrdy\Shurjopay;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class Shurjopay
{
    private $successUrl;
    private $cancelUrl;
    private $serverUrl;
    private $merchantUsername;
    private $merchantPassword;
    private $merchantKeyPrefix;
    private $clientIp;
    private $token;
    private $storeId;

    public function __construct()
    {
        $this->successUrl = config('shurjopay.success_url');
        $this->cancelUrl = config('shurjopay.cancel_url');
        $this->serverUrl = config('shurjopay.server_url');
        $this->merchantUsername = config('shurjopay.merchant_username');
        $this->merchantPassword = config('shurjopay.merchant_password');
        $this->merchantKeyPrefix = config('shurjopay.merchant_key_prefix');
        $this->clientIp = request()->ip();
    }

    public function checkPayment(): PromiseInterface|Response
    {
        $tokenResponse = $this->getToken();
        $this->token = $tokenResponse['token'];
        $this->storeId = $tokenResponse['store_id'];

        return $this->check();
    }

    private function getToken(): Response
    {
        return Http::post($this->serverUrl . '/api/get_token', [
            'username' => $this->merchantUsername,
            'password' => $this->merchantPassword,
        ]);
    }

    public function checkout($amount, $orderId, $name, $address, $phone, $postCode = 1200, $value1 = null, $value2 = null, $value3 = null, $value4 = null): Response
    {
        $tokenResponse = $this->getToken();
        $this->token = $tokenResponse['token'];
        $this->storeId = $tokenResponse['store_id'];
        return Http::post($this->serverUrl . '/api/secret-pay', [
            'amount' => $amount,
            'order_id' => $orderId,
            'customer_name' => $name,
            'customer_address' => $address,
            'customer_city' => $address,
            'customer_phone' => $phone,
            'customer_post_code' => $postCode,
            'value1' => $value1,
            'value2' => $value2,
            'value3' => $value3,
            'value4' => $value4,
            'currency' => 'BDT',
            'prefix' => $this->merchantKeyPrefix,
            'token' => $this->token,
            'return_url' => $this->successUrl,
            'cancel_url' => $this->cancelUrl,
            'store_id' => $this->storeId,
            'client_ip' => $this->clientIp,
        ])->json();
    }

    public function verify($id)
    {
        $tokenResponse = $this->getToken();
        $this->token = $tokenResponse['token'];
        $this->storeId = $tokenResponse['store_id'];
        return Http::withToken($this->token)->post($this->serverUrl . '/api/verification', [
            'order_id' => $id,
        ])->json();
    }

    public function check($id)
    {
        $tokenResponse = $this->getToken();
        $this->token = $tokenResponse['token'];
        $this->storeId = $tokenResponse['store_id'];
        return Http::withToken($this->token)->post($this->serverUrl . '/api/payment-status', [
            'order_id' => $id,
        ])->json();
    }
}
