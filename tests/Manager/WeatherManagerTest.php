<?php

namespace App\Test\Manager;

use App\Entity\WeatherInfo;
use App\Manager\WeatherManager;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;

/**
 * Class WeatherManagerTest.
 */
class WeatherManagerTest extends TestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function testUpdateWeather(): void
    {
        $manager = new WeatherManager($this->entityManager);
        $location = 'demo';

        $weatherInfo = (new WeatherInfo())
            ->setLocation($location);

        $manager->updateWeather($weatherInfo);
        $this->entityManager->clear();

        $wi = $this->findWeatherInfo($location);
        $this->assertInstanceOf(WeatherInfo::class, $wi);
        $this->assertEquals($weatherInfo, $wi);

        $weatherInfo = (new WeatherInfo())
            ->setLocation($location)
            ->setTemp(11.7)
            ->setPressure(1100)
            ->setHumidity(77);

        $manager->updateWeather($weatherInfo);
        $this->entityManager->clear();

        $wi = $this->findWeatherInfo($location);
        $this->assertInstanceOf(WeatherInfo::class, $wi);
        $this->assertEquals($weatherInfo, $wi);
    }

    protected function setUp()
    {
        $this->createTestEntityManager();

        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $schemaTool->createSchema(
            [
                $this->entityManager->getClassMetadata(WeatherInfo::class),
            ]
        );
    }

    /**
     * @param string $location
     *
     * @return WeatherInfo|object
     */
    protected function findWeatherInfo(string $location)
    {
        return $this->entityManager
            ->getRepository(WeatherInfo::class)
            ->find($location);
    }

    private function createTestEntityManager(): void
    {
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration(
            [__DIR__.'/../../src/Entity'],
            $isDevMode,
            null,
            new ArrayCache(),
            false
        );

        $params = [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];

        $this->entityManager = EntityManager::create($params, $config);
    }
}
