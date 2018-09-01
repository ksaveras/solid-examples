<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class WeatherInfo.
 *
 * @ORM\Entity()
 * @ORM\Table(name="weather_info")
 */
class WeatherInfo
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="location", type="string", length=32, nullable=false)
     */
    private $location;

    /**
     * @var float|null
     *
     * @ORM\Column(name="temp", type="float", nullable=true)
     */
    private $temp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="pressure", type="integer", nullable=true)
     */
    private $pressure;

    /**
     * @var int|null
     *
     * @ORM\Column(name="humidity", type="integer", nullable=true)
     */
    private $humidity;

    /**
     * @return null|string
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param null|string $location
     *
     * @return $this
     */
    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTemp(): ?float
    {
        return $this->temp;
    }

    /**
     * @param float|null $temp
     *
     * @return $this
     */
    public function setTemp(?float $temp): self
    {
        $this->temp = $temp;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPressure(): ?int
    {
        return $this->pressure;
    }

    /**
     * @param int|null $pressure
     *
     * @return $this
     */
    public function setPressure(?int $pressure): self
    {
        $this->pressure = $pressure;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getHumidity(): ?int
    {
        return $this->humidity;
    }

    /**
     * @param int|null $humidity
     *
     * @return $this
     */
    public function setHumidity(?int $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }
}
