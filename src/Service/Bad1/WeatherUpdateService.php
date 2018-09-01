<?php

namespace App\Service\Bad1;

use App\Entity\WeatherInfo;
use App\Manager\WeatherManager;
use App\Weather\WeatherProviderInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

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
     * @var AdapterInterface
     */
    private $cache;

    /**
     * WeatherUpdateService constructor.
     *
     * @param WeatherProviderInterface $weatherProvider
     * @param WeatherManager           $manager
     * @param AdapterInterface         $cache
     */
    public function __construct(
        WeatherProviderInterface $weatherProvider,
        WeatherManager $manager,
        AdapterInterface $cache
    ) {
        $this->weatherProvider = $weatherProvider;
        $this->manager = $manager;
        $this->cache = $cache;
    }

    /**
     * @param string $location
     *
     * @return WeatherInfo
     */
    public function downloadWeatherInfo(string $location): WeatherInfo
    {
        $item = $this->cache->getItem($location);
        if (!$item->isHit()) {
            $weatherInfo = $this->weatherProvider->getWeatherInfo($location);
            $item->set($weatherInfo);
            $this->cache->save($item);
        }

        $weatherInfo = $item->get();
        $this->manager->updateWeather($weatherInfo);

        return $weatherInfo;
    }
}
