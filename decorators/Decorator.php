<?php

namespace app\decorators;

/**
 * Decorator
 *
 * @author s.kamnev
 */
class Decorator
{
    public static function sypexResponseEn($data)
    {
        return [
            'city' => [
               'lat'  => $data['city']['lat'],
               'lon'  => $data['city']['lon'],
               'name' => $data['city']['name_en'],
            ],
            'country' => [
               'lat'  => $data['country']['lat'],
               'lon'  => $data['country']['lon'],
               'name' => $data['country']['name_en'],
            ],
        ];
    }
}
