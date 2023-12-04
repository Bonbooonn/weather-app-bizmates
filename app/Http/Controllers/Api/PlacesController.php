<?php

namespace App\Http\Controllers\Api;

use App\Facades\Places;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlacesResource;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    public function getPlaces(Request $request)
    {
        $places = Places::search($request->input('search') ?? '');

        return PlacesResource::collection($places['results']);
    }
}
