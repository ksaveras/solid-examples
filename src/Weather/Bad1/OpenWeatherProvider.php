<?php

namespace App\Weather\Bad1;

use App\Entity\WeatherInfo;
use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 * Class OpenWeatherProvider.
 */
class OpenWeatherProvider implements WeatherProviderInterface
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * OpenWeatherProvider constructor.
     *
     * @param string           $url
     * @param string           $apiKey
     * @param AdapterInterface $cache
     */
    public function __construct(string $url, string $apiKey, AdapterInterface $cache = null)
    {
        $this->url = $url;
        $this->apiKey = $apiKey;
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function getWeatherInfo(string $location, bool $useCache = false): WeatherInfo
    {
        if (empty($location)) {
            throw new \BadMethodCallException('Argument $location can not be empty');
        }

        if (!$useCache || null === $this->cache) {
            return $this->fetchWeatherInfo($location);
        }

        $item = $this->cache->getItem($location);
        if (!$item->isHit()) {
            $weatherInfo = $this->fetchWeatherInfo($location);

            $item->set($weatherInfo);
            $this->cache->save($item);
        }

        return $item->get();
    }

    /**
     * @param string $location
     *
     * @return WeatherInfo
     */
    protected function fetchWeatherInfo(string $location): WeatherInfo
    {
        $url = $this->buildUrl($location);
        $response = file_get_contents($url);

        return $this->parseResponse($response);
    }

    /**
     * @param string $location
     *
     * @return string
     */
    private function buildUrl(string $location): string
    {
        return str_replace(
            [
                '%LOCATION%',
                '%APIKEY%',
            ],
            [
                $location,
                $this->apiKey,
            ],
            $this->url
        );
    }

    /**
     * @param string $response
     *
     * @return WeatherInfo
     */
    private function parseResponse($response): WeatherInfo
    {
        $response = json_decode($response, true);

        return (new WeatherInfo())
            ->setLocation($response['name'])
            ->setTemp((float) $response['main']['temp'])
            ->setHumidity((int) $response['main']['humidity'])
            ->setPressure((int) $response['main']['pressure']);
    }
}
