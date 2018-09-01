<?php

use App\Manager\WeatherManager;
use App\Service\V1\WeatherUpdateService;
use App\Weather\OpenWeatherProvider;

require_once __DIR__.'/bootstrap.php';

$config = [
    'openWeather' => [
        'url' => 'http://api.openweathermap.org/data/2.5/weather?q=%LOCATION%&units=metric&appid=%APIKEY%',
        'apikey' => '64a9a0d304ce60d730cf08ebb378fa27',
    ],
];

$weatherProvider = new OpenWeatherProvider(
    $config['openWeather']['url'],
    $config['openWeather']['apikey']
);

$weatherManager = new WeatherManager($entityManager);

$weatherUpdateService = new WeatherUpdateService($weatherProvider, $weatherManager);

$weatherInfo = $weatherUpdateService->downloadWeatherInfo('kaunas');

var_dump($weatherInfo);
