<?php

require_once 'bootstrap.php';

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(
    [
        'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager),
    ]
);

return $helperSet;
