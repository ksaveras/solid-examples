<?php

namespace App\Weather;

use App\Entity\WeatherInfo;

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
     * OpenWeatherProvider constructor.
     *
     * @param string $url
     * @param string $apiKey
     */
    public function __construct(string $url, string $apiKey)
    {
        $this->url = $url;
        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getWeatherInfo(string $location): WeatherInfo
    {
        if (empty($location)) {
            throw new \BadMethodCallException('Argument $location can not be empty');
        }

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
