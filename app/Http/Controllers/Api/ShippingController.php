<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ShippingService;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    protected ShippingService $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    /**
     * Get available shipping destinations
     */
    public function destinations()
    {
        $destinations = $this->shippingService->getAvailableDestinations();

        return response()->json([
            'success' => true,
            'data' => $destinations,
        ]);
    }

    /**
     * Calculate shipping cost
     */
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|string',
            'province' => 'required|string',
            'total_weight' => 'sometimes|integer|min:1',
            'total_weight_grams' => 'sometimes|integer|min:1',
        ]);

        // Support both parameter names for flexibility
        $totalWeight = $validated['total_weight_grams'] ?? $validated['total_weight'] ?? 0;

        if ($totalWeight <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Total weight must be greater than 0',
            ], 400);
        }

        try {
            $shipping = $this->shippingService->calculateShippingCost(
                $validated['city'],
                $validated['province'],
                $totalWeight
            );

            return response()->json([
                'success' => true,
                'data' => $shipping,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Check if shipping is available to the given province
     */
    private function isShippingAvailable(string $province): bool
    {
        $availableProvinces = [
            'Banten', 'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah',
            'DI Yogyakarta', 'Jawa Timur', 'Bali', 'Nusa Tenggara Barat',
            'Nusa Tenggara Timur',
        ];

        return in_array($province, $availableProvinces);
    }
}
        