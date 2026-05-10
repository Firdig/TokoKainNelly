<?php

/**
 * Midtrans Payment Gateway Configuration.
 *
 * Server Key & Client Key can be obtained from the Midtrans Dashboard:
 * https://dashboard.midtrans.com/ → Settings → Access Keys
 *
 * Use Sandbox keys for development/testing, Production keys for live.
 */
return [
    'server_key'    => env('MIDTRANS_SERVER_KEY', ''),
    'client_key'    => env('MIDTRANS_CLIENT_KEY', ''),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized'  => true,
    'is_3ds'        => true,

    // Snap API base URL (auto-resolved based on is_production)
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',
];
