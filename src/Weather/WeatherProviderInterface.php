<?php

namespace App\Weather;

use App\Entity\WeatherInfo;

/**
 * Interface WeatherProviderInterface.
 */
interface WeatherProviderInterface
{
    /**
     * @param string $location
     *
     * @return WeatherInfo
     */
    public function getWeatherInfo(string $location): WeatherInfo;
}
