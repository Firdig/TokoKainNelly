<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransController;

// ═══════════════════════════════════════════════════════════════
// MIDTRANS WEBHOOK (No CSRF, No Auth)
// ═══════════════════════════════════════════════════════════════

// Midtrans sends POST notifications to this endpoint when payment
// status changes (settlement, expire, cancel, etc.)
// Security is handled via signature_key verification in MidtransService.
Route::post('/midtrans/notification', [MidtransController::class, 'notification'])
    ->name('midtrans.notification');
