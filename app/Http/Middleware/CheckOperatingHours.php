<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckOperatingHours
{
    /**
     * Online store operating hours:
     * 10:00 – 17:00 (Open every day)
     * 
     * This middleware only applies to checkout and order creation
     */
    public function handle(Request $request, Closure $next): Response
    {
        $now = Carbon::now();
        $currentHour = $now->hour;
        
        // Online store hours: 10:00 - 17:00
        $openHour = 10;
        $closeHour = 17;

        // Check if current time is within operating hours
        if ($currentHour < $openHour || $currentHour >= $closeHour) {
            return response()->json([
                'success' => false,
                'message' => "Online store is closed. Operating hours: {$openHour}:00 - {$closeHour}:00",
                'current_time' => $now->format('H:i:s'),
            ], 403);
        }

        return $next($request);
    }
}