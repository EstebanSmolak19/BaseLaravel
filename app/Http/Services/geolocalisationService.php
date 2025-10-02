<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class geolocalisationService {

    public function coord(string $city)
    {
        $url = "https://nominatim.openstreetmap.org/search";

        $response = Http::withHeaders([
            'User-Agent' => 'MonApp/1.0 (tonemail@example.com)'
        ])
        ->get($url, [
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
    }
}