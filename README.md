# Laravel Shopify Webhook Manager
This package creates webhooks on your Shopify store.

### Installation and usage:
This package requires PHP 7.2 and Laravel 5.8 or higher.

It uses `strawberry/shopify` under the hood – you should pop over to the documentation and set up the Shopify client before registering your webhooks.

Install the package using composer.

`composer require strawberry/laravel-shopify-webhook-manager`

The package will automatically register its service provider. Publish the configuration by running:

`php artisan vendor:publish --provider="Strawberry\Webhooks\WebhooksServiceProvider"`

You can, of course, have multiple webhooks with the same address or topic.

### The `CreateWebhook` Job
You may use the `CreateWebhook` job anywhere in your application to create a webhook by passing in an array 
(as outlined below in **Define a webhook**) to the constructor.

### The `ReplaceMissingWebhooks` Job
If you like, you can use this package to automatically register your application's webhooks, and replace them if they're removed.

To do this, simply define your webhooks within the configuration file, then schedule the job in your application's console kernel.

```php
// app/Console/Kernel.php

protected function schedule(Schedule $schedule)
{
    $schedule->job(ReplaceMissingWebhooks::class)->hourly();
}
```

### The `CheckForMissingWebhooks` Job
If you just want to check for missing webhooks and have them by your application, you can use the `CheckForMissingWebhooks` job, instead.

Each webhook that has been determined missing will be logged to the channel that you define in the package configuration. Out of the box, it will log to the `stack` channel.

You may also change the level that the issue is reported at. By default, the level is `warning`.

Of course, you could even use both in conjunction with each other – you might want to be aware of any missing webhooks, but also know that they'll be reinstated automatically.

### Define a webhook:
In `config/shopify-webhooks.php`, define each webhook with an array containing the following:
```php
[
    'address' => 'http://your-integration-url.com/order/create',
    'topic' => 'order/create',
    'format' => 'json',
],
```
