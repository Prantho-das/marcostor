<?php

namespace App\Services\Courier;

interface CourierContract
{
    public function getCities(): array;

    public function getZones(int $cityId): array;

    public function getAreas(int $parentId): array;

    public function createStore(array $data): array;

    public function createOrder(array $data): array;

    public function createBulkOrders(array $orders): array;

    public function calculatePrice(array $data): array;
}
