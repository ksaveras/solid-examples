<?php

namespace App\Manager\V1;

use App\Entity\WeatherInfo;
use App\Traits\LoggerAwareTrait;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerAwareInterface;

/**
 * Class WeatherManager.
 */
class WeatherManager implements LoggerAwareInterface
{
    use LoggerAwareTrait;

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
            $this->getLogger()->info('Create new weather info', ['location' => $weatherInfo->getLocation()]);
            $this->entityManager->persist($weatherInfo);
        } else {
            $this->getLogger()->info('Update weather info', ['location' => $weatherInfo->getLocation()]);
            $this->entityManager->merge($weatherInfo);
        }

        $this->entityManager->flush();
    }
}
