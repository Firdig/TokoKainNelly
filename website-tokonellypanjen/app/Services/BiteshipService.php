<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service class for Biteship shipping API integration.
 *
 * Handles:
 * - Area search (autocomplete) for destination selection
 * - Courier rate calculation for shipping cost estimation
 * - Weight calculation from fabric specifications (GSM / G/Y)
 *
 * API Reference: https://biteship.com/id/docs/api
 */
class BiteshipService
{
    private string $apiKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey  = config('biteship.api_key');
        $this->baseUrl = config('biteship.base_url');
    }

    /**
     * Search areas for autocomplete (destination selection).
     *
     * Uses the Biteship Maps API to find areas matching user input.
     * Results include area IDs needed for rate calculation.
     *
     * @param  string  $query  User's search input (e.g., "Kepanjen Malang")
     * @return array   List of matching areas
     */
    public function searchAreas(string $query): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->get("{$this->baseUrl}/v1/maps/areas", [
                'countries' => 'ID',
                'input'     => $query,
                'type'      => 'single',
            ]);

            if ($response->successful()) {
                return $response->json('areas', []);
            }

            Log::warning('Biteship area search failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('Biteship area search error', [
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    /**
     * Get courier shipping rates from Biteship.
     *
     * For instant couriers (Gojek, Grab), lat/lng coordinates are required.
     * For regular couriers (JNE, SiCepat), area_id or postal codes work.
     *
     * @param  string      $destinationAreaId  Biteship area ID for the destination
     * @param  array       $items              Cart items with weight/dimensions
     * @param  float|null  $destinationLat     Destination latitude (required for instant couriers)
     * @param  float|null  $destinationLng     Destination longitude (required for instant couriers)
     * @return array   Available courier rates grouped by courier
     */
    public function getRates(string $destinationAreaId, array $items, ?float $destinationLat = null, ?float $destinationLng = null): array
    {
        try {
            $requestBody = [
                'origin_postal_code'    => config('biteship.origin_postal_code'),
                'origin_latitude'       => (float) config('biteship.origin_latitude'),
                'origin_longitude'      => (float) config('biteship.origin_longitude'),
                'destination_area_id'   => $destinationAreaId,
                'couriers'              => config('biteship.couriers'),
                'items'                 => $items,
            ];

            // Add destination coordinates if provided (required for Gojek/Grab)
            if ($destinationLat !== null && $destinationLng !== null) {
                $requestBody['destination_latitude']  = $destinationLat;
                $requestBody['destination_longitude'] = $destinationLng;
            }

            Log::info('Biteship rate request', $requestBody);

            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
                'Content-Type'  => 'application/json',
            ])->post("{$this->baseUrl}/v1/rates/couriers", $requestBody);

            Log::info('Biteship rate response', [
                'status' => $response->status(),
                'body'   => $response->json(),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $pricing = $data['pricing'] ?? [];

                // Biteship returns a flat array where each item is one service.
                // Group by courier_code for the frontend display.
                $grouped = [];
                foreach ($pricing as $item) {
                    $code = $item['courier_code'] ?? 'unknown';
                    if (!isset($grouped[$code])) {
                        $grouped[$code] = [
                            'courier_code' => $code,
                            'courier_name' => $item['courier_name'] ?? $code,
                            'costs'        => [],
                        ];
                    }
                    $etd = '';
                    if (!empty($item['shipment_duration_range'])) {
                        $etd = $item['shipment_duration_range'] . ' ' . ($item['shipment_duration_unit'] === 'days' ? 'hari' : ($item['shipment_duration_unit'] ?? ''));
                    }
                    $grouped[$code]['costs'][] = [
                        'service' => $item['courier_service_name'] ?? ($item['courier_service_code'] ?? ''),
                        'price'   => $item['price'] ?? 0,
                        'etd'     => $etd ?: ($item['duration'] ?? '-'),
                    ];
                }

                return array_values($grouped);
            }

            Log::warning('Biteship rate calculation failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('Biteship rate calculation error', [
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    /**
     * Calculate the shipping weight of a fabric item in grams.
     *
     * Supports two industry-standard weight units:
     * - GSM (Gram per Square Meter): weight = GSM × width_m × length_m
     * - G/Y (Gram per Yard): weight = G/Y × (length_m / 0.9144)
     *
     * @param  int     $weightValue   The fabric weight value (GSM or G/Y)
     * @param  string  $weightUnit    'gsm' or 'gpy'
     * @param  string|null  $fabricWidth  Fabric width (e.g., "150", "150 cm", "1.5 m")
     * @param  float   $quantityMeters  Length in meters ordered by customer
     * @return int     Total weight in grams
     */
    public function calculateWeightGrams(
        int $weightValue,
        string $weightUnit,
        ?string $fabricWidth,
        float $quantityMeters
    ): int {
        if ($weightUnit === 'gsm') {
            // Parse fabric width to meters
            $widthMeters = $this->parseWidthToMeters($fabricWidth);
            // GSM × width(m) × length(m) = total grams
            return (int) ceil($weightValue * $widthMeters * $quantityMeters);
        }

        // G/Y (Gram per Yard): weight per linear yard at full width
        // Convert meters to yards: 1 yard = 0.9144 meters
        $yards = $quantityMeters / 0.9144;
        return (int) ceil($weightValue * $yards);
    }

    /**
     * Parse a fabric width string into meters.
     *
     * Handles formats like: "150", "150 cm", "1.5 m", "150cm"
     * Default: assumes centimeters if no unit specified.
     *
     * @param  string|null  $width  Raw width string from product
     * @return float  Width in meters (defaults to 1.5m if unparseable)
     */
    private function parseWidthToMeters(?string $width): float
    {
        if (empty($width)) {
            return 1.5; // Default fabric width: 150cm = 1.5m
        }

        // Clean up the string
        $width = strtolower(trim($width));

        // Try to extract numeric value
        if (preg_match('/^([\d.]+)\s*(m|cm|meter|centimeter)?/', $width, $matches)) {
            $value = (float) $matches[1];
            $unit  = $matches[2] ?? '';

            if (in_array($unit, ['m', 'meter'])) {
                return $value;
            }

            // Default: centimeters
            if ($value > 10) {
                return $value / 100; // e.g., 150 → 1.5m
            }

            return $value; // Already in meters (e.g., 1.5)
        }

        return 1.5; // Fallback default
    }

    /**
     * Build Biteship items array from cart items for rate calculation.
     *
     * @param  \Illuminate\Support\Collection  $cartItems  Cart items with productVariant.product loaded
     * @return array  Items formatted for Biteship rates API
     */
    public function buildItemsFromCart($cartItems): array
    {
        $biteshipItems = [];

        foreach ($cartItems as $item) {
            $product = $item->productVariant->product;

            $weightGrams = $this->calculateWeightGrams(
                $product->weight_value ?? 200,
                $product->weight_unit ?? 'gsm',
                $product->width,
                $item->quantity
            );

            $biteshipItems[] = [
                'name'        => mb_substr($product->name, 0, 50),
                'description' => mb_substr(($item->productVariant->color_name ?? 'Default') . ' - ' . $item->quantity . 'm', 0, 100),
                'value'       => (int) round($product->price * $item->quantity),
                'weight'      => max($weightGrams, 1), // Minimum 1 gram
                'quantity'    => 1, // Each item is already aggregated by weight
                'length'      => 30, // Default package dimensions (cm)
                'width'       => 20,
                'height'      => 10,
            ];
        }

        return $biteshipItems;
    }
}
