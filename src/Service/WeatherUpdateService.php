<?php

namespace App\Service;

use App\Entity\WeatherInfo;
use Doctrine\ORM\EntityManager;

/**
 * Class WeatherUpdateService.
 */
class WeatherUpdateService
{
    public const API_KEY = '64a9a0d304ce60d730cf08ebb378fa27';

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * WeatherUpdateService constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $location
     *
     * @return WeatherInfo
     */
    public function downloadWeatherInfo(string $location): WeatherInfo
    {
        $weather = $this->getData($location);

        $this->storeInDatabase($weather);

        return $weather;
    }

    /**
     * @param string $locationName
     *
     * @return WeatherInfo
     */
    protected function getData(string $locationName): WeatherInfo
    {
        $url = sprintf(
            'http://api.openweathermap.org/data/2.5/weather?q=%s&units=metric&appid=%s',
            $locationName,
            static::API_KEY
        );
        $data = file_get_contents($url);

        $weatherData = json_decode($data, true);

        return (new WeatherInfo())
            ->setLocation($weatherData['name'])
            ->setTemp((float) $weatherData['main']['temp'])
            ->setHumidity((int) $weatherData['main']['humidity'])
            ->setPressure((int) $weatherData['main']['pressure']);
    }

    /**
     * @param WeatherInfo $weather
     */
    protected function storeInDatabase(WeatherInfo $weather): void
    {
        $entity = $this->entityManager
            ->getRepository(WeatherInfo::class)
            ->find($weather->getLocation());

        if (null === $entity) {
            $this->entityManager->persist($weather);
            $this->entityManager->flush($weather);

            return;
        }

        $this->entityManager->merge($weather);
        $this->entityManager->flush($entity);
    }
}
