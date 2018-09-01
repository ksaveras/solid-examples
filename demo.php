<?php

require_once __DIR__.'/bootstrap.php';

$service = new \App\Service\WeatherUpdateService($entityManager);

$weatherInfo = $service->downloadWeatherInfo('Kaunas');

var_dump($weatherInfo);
