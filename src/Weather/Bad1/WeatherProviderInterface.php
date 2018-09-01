<?php

namespace App\Weather\Bad1;

use App\Entity\WeatherInfo;

/**
 * Interface WeatherProviderInterface.
 */
interface WeatherProviderInterface
{
    /**
     * @param string $location
     * @param bool   $useCache
     *
     * @return WeatherInfo
     */
    public function getWeatherInfo(string $location, bool $useCache = false): WeatherInfo;
}
