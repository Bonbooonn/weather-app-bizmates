<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->newResponseData();
    }

    private function newResponseData()
    {
        $lists = $this['list'];
        $today = now()->format('M j, Y');

        $datas = [];
        $icons = [];

        foreach ($lists as $list) {
            $date = Carbon::parse($list['dt'])->format('Ymd');

            if (!isset($icons[$list['weather'][0]['main']])) {
                $icons[$list['weather'][0]['main']] = $list['weather'][0]['icon'];
            }

            if (!isset($datas[$date])) {
                $datas[$date] = [
                    'date' => Carbon::parse($date)->format('M j, Y'),
                    'day' => Carbon::parse($date)->format('D'),
                    'timestamp' => $list['dt'],
                    'temp' => [
                        'temp_max' => $list['main']['temp_max'],
                        'temp' => $list['main']['temp'],
                        'temp_min' => $list['main']['temp_min'],
                        'feels_like' => $list['main']['feels_like'],
                    ],
                    'weather' => [
                        $list['weather'][0]['main'],
                    ],
                    'total' => 1,
                ];
            } else {
                $datas[$date]['temp']['temp_max'] += $list['main']['temp_max'];
                $datas[$date]['temp']['temp'] += $list['main']['temp'];
                $datas[$date]['temp']['temp_min'] += $list['main']['temp_min'];
                $datas[$date]['temp']['feels_like'] += $list['main']['feels_like'];
                $datas[$date]['weather'][] = $list['weather'][0]['main'];
                ++$datas[$date]['total'];
            }
        }

        $response = [];
        foreach ($datas as $data) {
            $data['temp']['temp_max'] = floor($data['temp']['temp_max'] / $data['total']);
            $data['temp']['temp'] = floor($data['temp']['temp'] / $data['total']);
            $data['temp']['temp_min'] = floor($data['temp']['temp_min'] / $data['total']);
            $data['temp']['feels_like'] = floor($data['temp']['feels_like'] / $data['total']);
            $weather = array_count_values($data['weather']);

            if ($today == $data['date']) {
                $data['today'] = true;
            }

            arsort($weather);
            $data['weather'] = key($weather);
            $data['icon'] = 'http://openweathermap.org/img/wn/'.$icons[$data['weather']].'.png';
            $data['id'] = $this['id'];

            unset($data['total']);
            $response[] = $data;
        }

        return array_values($response);
    }
}
