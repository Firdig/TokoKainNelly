<?php

namespace App\Http\Controllers;

use App\Services\BiteshipService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;

/**
 * Controller for Biteship API proxy endpoints.
 *
 * Provides AJAX endpoints for the checkout page to:
 * - Search destination areas (autocomplete)
 * - Calculate courier shipping rates
 *
 * All endpoints require authentication and return JSON.
 */
class BiteshipController extends Controller
{
    public function __construct(
        private readonly BiteshipService $biteshipService,
    ) {}

    /**
     * Search areas for destination autocomplete.
     *
     * GET /api/biteship/areas?input=Jakarta+Selatan
     *
     * @return JsonResponse
     */
    public function searchAreas(Request $request): JsonResponse
    {
        $request->validate([
            'input' => 'required|string|min:3|max:100',
        ]);

        $areas = $this->biteshipService->searchAreas($request->input('input'));

        return response()->json([
            'success' => true,
            'areas'   => $areas,
        ]);
    }

    /**
     * Calculate courier shipping rates for the customer's cart.
     *
     * POST /api/biteship/rates
     * Body: { "destination_area_id": "IDNP6IDNC149IDND902IDZ65163" }
     *
     * Uses the current session cart to determine item weights and values.
     *
     * @return JsonResponse
     */
    public function getRates(Request $request): JsonResponse
    {
        $request->validate([
            'destination_area_id' => 'required|string|max:100',
            'destination_lat'     => 'nullable|numeric|between:-90,90',
            'destination_lng'     => 'nullable|numeric|between:-180,180',
        ]);

        // Get the current cart
        $sessionId = Session::get('cart_id');
        $cart = Cart::with('items.productVariant.product')
            ->where('session_id', $sessionId)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong.',
            ], 422);
        }

        // Build items array from cart for Biteship
        $items = $this->biteshipService->buildItemsFromCart($cart->items);

        // Get rates from Biteship (with coordinates for instant couriers)
        $rates = $this->biteshipService->getRates(
            $request->input('destination_area_id'),
            $items,
            $request->input('destination_lat') ? (float) $request->input('destination_lat') : null,
            $request->input('destination_lng') ? (float) $request->input('destination_lng') : null,
        );

        return response()->json([
            'success' => true,
            'rates'   => $rates,
        ]);
    }
}
