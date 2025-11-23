<?php

namespace App\Services\Courier;

use InvalidArgumentException;

class CourierFactory
{
    public static function make(string $courierSlug): CourierContract
    {
        return match (strtolower($courierSlug)) {
            'pathao' => new PathaoCourierService(),
            // 'paperfly' => new PaperflyCourierService(),
            // 'redx' => new RedxCourierService(),
            // Add other courier services here

            default => throw new InvalidArgumentException("Courier [$courierSlug] not supported."),
        };
    }
}
