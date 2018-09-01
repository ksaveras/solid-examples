<?php

namespace App\Manager;

use App\Entity\WeatherInfo;
use App\Traits\LoggerAwareTrait;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerAwareInterface;

/**
 * Class WeatherManager.
 */
class WeatherManager
{
    /**
     * @var ObjectManager
     */
    private $entityManager;

    /**
     * WeatherManager constructor.
     *
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param WeatherInfo $weatherInfo
     *
     * @return void
     */
    public function updateWeather(WeatherInfo $weatherInfo): void
    {
        $entity = $this->entityManager
            ->getRepository(WeatherInfo::class)
            ->find($weatherInfo->getLocation());

        if (null === $entity) {
            $this->entityManager->persist($weatherInfo);
        } else {
            $this->entityManager->merge($weatherInfo);
        }

        $this->entityManager->flush();
    }
}
