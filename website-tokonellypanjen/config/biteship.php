<?php

/**
 * Biteship Shipping API Configuration.
 *
 * API Key can be obtained from the Biteship Dashboard:
 * https://biteship.com/dashboard → Settings → API Keys
 *
 * Use Test key for development/testing, Live key for production.
 */
return [
    'api_key'  => env('BITESHIP_API_KEY', ''),
    'base_url' => env('BITESHIP_BASE_URL', 'https://api.biteship.com'),

    // Store origin location (Toko Kain Nelly, Pasar Panjen, Kepanjen, Malang)
    'origin_postal_code' => env('BITESHIP_ORIGIN_POSTAL_CODE', '65163'),
    'origin_latitude'    => env('BITESHIP_ORIGIN_LAT', -8.127528635332222),
    'origin_longitude'   => env('BITESHIP_ORIGIN_LNG', 112.57075539619163),

    // Supported couriers (gojek, grab require lat/lng coordinates)
    'couriers' => env('BITESHIP_COURIERS', 'gojek,grab'),
];