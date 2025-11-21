<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use App\Services\CartService;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;


class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Event::listen(Login::class, function (Login $event) {
            $cartService = app(CartService::class);
            $cartService->mergeSessionToDb($event->user->id);
        });
    }
}
