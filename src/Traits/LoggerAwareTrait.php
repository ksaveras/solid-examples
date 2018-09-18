<?php

namespace App\Traits;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Trait LoggerAwareTrait.
 */
trait LoggerAwareTrait
{
    use \Psr\Log\LoggerAwareTrait;

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        if (null === $this->logger) {
            $this->logger = new NullLogger();
        }

        return $this->logger;
    }
}
