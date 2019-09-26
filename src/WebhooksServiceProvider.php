<?php

namespace Strawberry\Shopify\Webhooks;

use Illuminate\Support\ServiceProvider;

class WebhooksServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/shopify-webhooks.php' => config_path('shopify-webhooks.php'),
        ]);
    }
}