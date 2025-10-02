<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class GeolocalisationService
{
    /**
     * Récupère les coordonnées (latitude/longitude) d'une ville via Nominatim OpenStreetMap.
     *
     * @param string $city
     * @return array|null
     * @throws Exception
     */
    public function coord(string $city): ?array
    {
        try {
            $url = "https://nominatim.openstreetmap.org/search";

            $response = Http::withHeaders([
                'User-Agent' => 'LaravelApp/1.0'
            ])->get($url, [
                'q' => $city,
                'format' => 'json',
                'limit' => 1
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (!empty($data[0])) {
                    return [
                        'lat' => $data[0]['lat'],
                        'lon' => $data[0]['lon']
                    ];
                }
            }

            return null;
        } catch (Exception $e) {
            throw new Exception('Impossible de récupérer la géolocalisation : ' . $e->getMessage());
        }
    }
}