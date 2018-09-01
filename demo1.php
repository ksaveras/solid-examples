<?php

use App\Manager\WeatherManager;
use App\Service\V1\WeatherUpdateService;
use App\Weather\OpenWeatherProvider;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__.'/bootstrap.php';

$dotEnv = new Dotenv();
$dotEnv->load(__DIR__.'/.env');

$config = [
    'openWeather' => [
        'url' => 'http://api.openweathermap.org/data/2.5/weather?q=%LOCATION%&units=metric&appid=%APIKEY%',
        'apikey' => $_ENV['OPEN_WEATHER_API'],
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
