<?php

namespace Strawberry\Shopify\Webhooks\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Strawberry\Shopify\Rest\Client as Shopify;

class CreateWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var array */
    private $webhook;

    /** @var Shopify */
    public $shopify;

    public function __construct(array $webhook, Shopify $shopify)
    {
        $this->webhook = $webhook;
        $this->shopify = $shopify;
    }

    public function handle(): void
    {
        $this->shopify->webhooks->create($this->webhook);
    }
}
