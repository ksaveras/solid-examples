<?php

namespace App\Weather;

use App\Entity\WeatherInfo;
use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 * Class CachedWeatherProvider.
 */
class CachedWeatherProvider implements WeatherProviderInterface
{
    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * @var WeatherProviderInterface
     */
    private $service;

    /**
     * CachedWeatherProvider constructor.
     *
     * @param AdapterInterface         $cache
     * @param WeatherProviderInterface $service
     */
    public function __construct(AdapterInterface $cache, WeatherProviderInterface $service)
    {
        $this->cache = $cache;
        $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function getWeatherInfo(string $location): WeatherInfo
    {
        $item = $this->cache->getItem($location);
        if (!$item->isHit()) {
            $weatherInfo = $this->service->getWeatherInfo($location);
            $item->set($weatherInfo);
            $this->cache->save($item);
        }

        return $item->get();
    }
}
