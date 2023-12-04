<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlacesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (empty($this['text'])) {
            return [];
        }

        return [
            'id' => \Str::uuid(),
            'name' => $this['text']['primary'],
            'geo' => [
                'lat' => $this['geo']['center']['latitude'],
                'long' => $this['geo']['center']['longitude'],
            ],
            'country_code' => $this['geo']['cc'],
        ];
    }
}
