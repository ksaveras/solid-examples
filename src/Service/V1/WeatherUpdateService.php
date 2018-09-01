<?php

namespace App\Service\V1;

use App\Entity\WeatherInfo;
use App\Manager\WeatherManager;
use App\Weather\WeatherProviderInterface;

/**
 * Class WeatherUpdateService.
 */
class WeatherUpdateService
{
    /**
     * @var WeatherProviderInterface
     */
    private $weatherProvider;

    /**
     * @var WeatherManager
     */
    private $manager;

    /**
     * WeatherUpdateService constructor.
     *
     * @param WeatherProviderInterface $weatherProvider
     * @param WeatherManager           $manager
     */
    public function __construct(WeatherProviderInterface $weatherProvider, WeatherManager $manager)
    {
        $this->weatherProvider = $weatherProvider;
        $this->manager = $manager;
    }

    /**
     * @param string $location
     *
     * @return WeatherInfo
     */
    public function downloadWeatherInfo(string $location): WeatherInfo
    {
        $weatherInfo = $this->weatherProvider->getWeatherInfo($location);
        $this->manager->updateWeather($weatherInfo);

        return $weatherInfo;
    }
}
