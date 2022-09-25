<?php

namespace Yahrdy\Shurjopay;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class Shurjopay
{
    protected $amount;

    protected $successUrl;

    protected $serverUrl;

    protected $merchantUsername;

    protected $merchantPassword;

    protected $merchantKeyPrefix;

    protected $clientIp;

    protected $useCurl;

    protected $responseHandler;

    private $token;

    private $storeId;

    public function __construct(
        float $amount,
        string $successUrl,
        string $serverUrl = null,
        string $merchantUsername = null,
        string $merchantPassword = null,
        string $merchantKeyPrefix = null,
        bool $useCurl = false,
        string $responseHandler = null
    ) {
        $this->amount = $amount;
        $this->successUrl = $successUrl;
        $this->serverUrl = $serverUrl ?? config('shurjopay.server_url');
        $this->merchantUsername = $merchantUsername ?? config('shurjopay.merchant_username');
        $this->merchantPassword = $merchantPassword ?? config('shurjopay.merchant_password');
        $this->merchantKeyPrefix = $merchantKeyPrefix ?? config('shurjopay.merchant_key_prefix');
        $this->clientIp = Request::ip();
        $this->useCurl = $useCurl;
        $this->responseHandler = $responseHandler;
    }

    public function initiatePayment(): Response
    {
        $tokenResponse = $this->getToken();
        $this->token = $tokenResponse['token'];
        $this->storeId = $tokenResponse['store_id'];

        return $this->checkout();
    }

    public function verifyPayment(): PromiseInterface|Response
    {
        $tokenResponse = $this->getToken();
        $this->token = $tokenResponse['token'];
        $this->storeId = $tokenResponse['store_id'];

        return $this->verify();
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
        return Http::post($this->serverUrl.'/api/get_token', [
            'username' => $this->merchantUsername,
            'password' => $this->merchantPassword,
        ]);

        return $response;
    }

    private function checkout(): Response
    {
        $response = Http::post($this->serverUrl.'/api/secret-pay', [
            'prefix' => 'sp',
            'token' => $this->token,
            'amount' => $this->amount,
            'return_url' => $this->successUrl,
            'cancel_url' => $this->successUrl,
            'store_id' => $this->storeId,
            'client_ip' => $this->clientIp,
            'order_id' => '123456',
            'customer_name' => 'John Doe',
            'customer_address' => 'Dhaka',
            'customer_phone' => '01700000000',
            'customer_city' => 'Dhaka',
            'customer_post_code' => '1200',
            'currency' => 'BDT',
        ]);

        return $response;
    }

    public function verify(): PromiseInterface|Response
    {
        return Http::withToken($this->token)->post($this->serverUrl.'/api/verification', [
            'order_id' => 'spay612b73a935ab1',
        ]);
    }

    public function check(): PromiseInterface|Response
    {
        return Http::withToken($this->token)->withToken($this->token)->post($this->serverUrl.'/api/payment-status', [
            'order_id' => 'spay612b73a935ab1',
        ]);
    }
}
