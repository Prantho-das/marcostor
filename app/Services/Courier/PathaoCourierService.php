<?php

namespace App\Services\Courier;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class PathaoCourierService implements CourierContract
{
    protected $baseUrl;
    protected $accessToken;

    public function generateAccessToken($grantType = "password", $refresh_token = null)
    {
$body=[
    "client_secret" => config('couriers.pathao.client_secret'),
    "grant_type" => $grantType,
    "username" => config('couriers.pathao.username'),
    "password" => config('couriers.pathao.password'),
    "client_id" => config('couriers.pathao.client_id'),
    "refresh_token" => $refresh_token
];
        $response = Http::post("{$this->baseUrl}/aladdin/api/v1/issue-token",$body);
       
        if ($response->successful()) {
            Cookie::queue('couriers.pathao.access_token', $response->json('access_token'));
            Cookie::queue('couriers.pathao.refresh_token', $response->json('refresh_token'));
            Cookie::queue('couriers.pathao.expires_in', $response->json('expires_in'));
            return $response->json();
        }

        return [];
    }
    public function __construct()
    {
        $this->baseUrl = config('couriers.pathao.base_url');
        $this->accessToken = $this->getAccessToken();
    }

    protected function getAccessToken(): string
    {

        $access_token = Cookie::get('couriers.pathao.access_token', null);
        $expires_in = Cookie::get('couriers.pathao.expires_in', null);
        $refresh_token = Cookie::get('couriers.pathao.refresh_token', null);
        if (!$access_token || !$expires_in || time() >= $expires_in) {
            $tokenData = $this->generateAccessToken($refresh_token ? 'refresh_token' : 'password', $refresh_token);
            return $tokenData['access_token'] ?? '';
        }
        return $access_token;
    }

    protected function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/json',
        ];
    }

    public function getCities(): array
    {
        $response = Http::withHeaders($this->headers())->get("{$this->baseUrl}/aladdin/api/v1/city-list");

        if ($response->successful()) {
            return $response->json('data.data', []);
        }

        return [];
    }

    public function getZones(int $cityId): array
    {
        $response = Http::withHeaders($this->headers())->get("{$this->baseUrl}/aladdin/api/v1/cities/{$cityId}/zone-list");

        if ($response->successful()) {
            return $response->json('data.data', []);
        }

        return [];
    }

    public function getAreas(int $zoneId): array
    {
        $response = Http::withHeaders($this->headers())->get("{$this->baseUrl}/aladdin/api/v1/zones/{$zoneId}/area-list");

        if ($response->successful()) {
            return $response->json('data.data', []);
        }

        return [];
    }

    public function createStore(array $data): array
    {
        $response = Http::withHeaders($this->headers())->post("{$this->baseUrl}/aladdin/api/v1/stores", $data);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => $response->body()];
    }

    public function createOrder(array $data): array
    {
        $response = Http::withHeaders($this->headers())->post("{$this->baseUrl}/aladdin/api/v1/orders", $data);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => $response->body()];
    }

    public function createBulkOrders(array $orders): array
    {
        $response = Http::withHeaders($this->headers())->post("{$this->baseUrl}/aladdin/api/v1/orders/bulk", ['orders' => $orders]);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => $response->body()];
    }

    public function calculatePrice(array $data): array
    {
        $response = Http::withHeaders($this->headers())->post("{$this->baseUrl}/aladdin/api/v1/merchant/price-plan", $data);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => $response->body()];
    }
}
