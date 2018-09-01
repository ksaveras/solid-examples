<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require_once 'vendor/autoload.php';

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration([__DIR__.'/src/Entity'], $isDevMode, null, null, false);

$conn = [
    'driver' => 'pdo_sqlite',
    'path' => __DIR__.'/db.sqlite',
];

$entityManager = EntityManager::create($conn, $config);
