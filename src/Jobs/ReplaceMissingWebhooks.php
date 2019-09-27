<?php

namespace Strawberry\Shopify\Webhooks\Jobs;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Strawberry\Shopify\Rest\Client as Shopify;

class ReplaceMissingWebhooks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Collection */
    private $webhooks;

    /** @var Shopify */
    public $shopify;

    public function __construct(Shopify $shopify)
    {
        $this->webhooks = new Collection(
            config('shopify-webhooks.webhooks', [])
        );

        $this->shopify = $shopify;
    }

    public function handle(): void
    {
        $existing = Collection::wrap($this->shopify->webhooks()->get() ?? [])->map(function ($webhook) {
            return Str::slug("{$webhook->topic} {$webhook->address}");
        });

        $this->webhooks->reject(function ($webhook) use ($existing) {
            $webhook = Str::slug("{$webhook['topic']} {$webhook['address']}");

            return $existing->contains($webhook);
        })->each(function ($webhook) {
            CreateWebhook::dispatch($webhook);
        });
    }
}
