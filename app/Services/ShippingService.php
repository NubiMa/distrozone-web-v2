<?php

namespace App\Services;

use App\Models\ShippingRate;
use Exception;

class ShippingService
{
    /**
     * Calculate shipping cost based on city, province, and total weight
     */
    public function calculateShippingCost(string $city, string $province, int $totalWeightInGrams): array
    {
        // Validate if shipping is available
        if (!$this->isShippingAvailable($province)) {
            throw new Exception('Shipping is only available within Java island');
        }

        // Calculate shipping weight in kg
        // 1 kg = max 3 T-shirts (approximately 300g each)
        // Less than 3 T-shirts still counts as 1 kg
        $shippingWeightKg = $this->calculateShippingWeight($totalWeightInGrams);

        // Get rate per kg
        $rate = $this->getShippingRate($city, $province);

        if (!$rate) {
            throw new Exception("Shipping rate not found for {$city}, {$province}");
        }

        // Calculate total shipping cost
        $shippingCost = $rate->rate_per_kg * $shippingWeightKg;

        return [
            'total_weight_grams' => $totalWeightInGrams,
            'shipping_weight_kg' => $shippingWeightKg,
            'rate_per_kg' => $rate->rate_per_kg,
            'shipping_cost' => $shippingCost,
            'city' => $city,
            'province' => $province,
        ];
    }

    /**
     * Calculate shipping weight in kg
     * Rule: 1 kg = max 3 T-shirts
     * Less than 3 T-shirts = 1 kg
     */
    private function calculateShippingWeight(int $totalWeightInGrams): int
    {
        // Assume average T-shirt weight is 300g
        $avgTshirtWeight = 300;
        $maxTshirtsPerKg = 3;

        // Calculate number of T-shirts
        $numberOfTshirts = ceil($totalWeightInGrams / $avgTshirtWeight);

        // Calculate shipping weight in kg
        // Round up to nearest kg
        $shippingWeightKg = ceil($numberOfTshirts / $maxTshirtsPerKg);

        return max(1, $shippingWeightKg); // Minimum 1 kg
    }

    /**
     * Get shipping rate for city and province
     */
    private function getShippingRate(string $city, string $province): ?ShippingRate
    {
        return ShippingRate::where('is_active', true)
            ->where('city', $city)
            ->where('province', $province)
            ->first();
    }

    /**
     * Cek apakah pengiriman tersedia untuk provinsi tersebut
     * Hanya Pulau Jawa yang dilayani
     */
    public function isShippingAvailable(string $province): bool
    {
        $allowedProvinces = [
            'DKI Jakarta',
            'Jawa Barat',
            'Jawa Tengah',
            'Jawa Timur',
            'Banten',
            'DI Yogyakarta',
        ];

        return in_array($province, $allowedProvinces);
    }

    /**
     * Get all available shipping destinations
     */
    public function getAvailableDestinations(): array
    {
        return ShippingRate::where('is_active', true)
            ->orderBy('province')
            ->orderBy('city')
            ->get()
            ->groupBy('province')
            ->map(function ($items) {
                return $items->pluck('city')->toArray();
            })
            ->toArray();
    }
}