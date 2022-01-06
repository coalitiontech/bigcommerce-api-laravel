<?php
/**
 * All kind of Big Commerce API configuration will be here
 */
return [
    /**
     * Big Commerce API base url
     * Default Value is : https://api.bigcommerce.com/stores
     */
    'base_url' => env('BC_BASE_URL', 'https://api.bigcommerce.com/stores/'),

    /**
     * Big Commerce API base url
     * Default Value is : https://api.bigcommerce.com/stores
     */
    'base_url' => env('BC_BASE_URL', 'https://api.bigcommerce.com/stores/'),

    /**
     * Big Commerce has multiple api versions.
     * This version the version which will going to be use by BigCommerceAPI class
     * Default Value is : v3
     */
    'api_version' => env('BC_API_VERSION', 'v3'),

    /**
     * Big Commerce API Client Class.
     * You can modify client by extending it. Just replace the new class here.
     */
    'big_client' => \CoalitionTech\BigCommerceAPI\BigCommerceClient::class,
];
