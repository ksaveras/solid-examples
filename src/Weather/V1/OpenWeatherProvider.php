<?php

namespace App\Weather\V1;

use App\Entity\WeatherInfo;
use App\Traits\LoggerAwareTrait;
use App\Weather\WeatherProviderInterface;
use Psr\Log\LoggerAwareInterface;

/**
 * Class OpenWeatherProvider.
 */
class OpenWeatherProvider implements WeatherProviderInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

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
            $this->getLogger()->error('Got empty location argument');

            throw new \BadMethodCallException('Argument $location can not be empty');
        }

        $url = $this->buildUrl($location);
        try {
            $response = file_get_contents($url);
            if ($response === false) {
                throw new \DomainException('Can not fetch location weather info from URL: '.$url);
            }
        } catch (\Exception $exception) {
            $this->getLogger()->error('Got error while fetching location weather data: '.$exception->getMessage());
            $response = '';
        }

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
