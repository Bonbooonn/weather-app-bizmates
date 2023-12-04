<?php

namespace App\Http\Controllers\Api;

use App\Facades\Weather;
use App\Http\Controllers\Controller;
use App\Http\Resources\WeatherResource;
use App\Models\UserSavedPlace;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $lat = $request->input('lat');
        $long = $request->input('long');

        $params = [
            'lat' => $lat,
            'long' => $long,
        ];

        $response = Weather::weather(...$params);

        $user = auth()->user();

        $saved = $user->savedPlaces()->create([
            'lat' => $lat,
            'long' => $long,
            'name' => $request->input('name'),
        ]);

        $response['id'] = $saved->id;

        return new WeatherResource($response);
    }

    public function getSavedPlacesWeather()
    {
        $user = auth()->user();
        $user->load('savedPlaces');

        foreach ($user->savedPlaces as $savedPlace) {
            $response = Weather::weather($savedPlace->lat, $savedPlace->long);

            $response['id'] = $savedPlace->id;
            $savedPlace->weather = new WeatherResource($response);
        }

        return $user;
    }

    public function deleteSavedPlace(UserSavedPlace $userSavedPlace)
    {
        $userSavedPlace->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }
}
