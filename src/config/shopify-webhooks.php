<?php

return [

    /**
     * Register the webhooks for your application here.
     */
    'webhooks' => [
        //[
        //    'address' => 'http://your-integration-url.com/order/create',
        //    'topic' => 'order/create',
        //    'format' => 'json',
        //],
    ],

    /**
     * Choose which logging channel is informed every time a missing webhook is detected
     */
    'logging' => [
        'channel' => 'stack',
        'level' => 'warning',
    ],
];
