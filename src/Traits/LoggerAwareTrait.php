<?php

namespace App\Traits;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Trait LoggerAwareTrait.
 */
trait LoggerAwareTrait
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

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

    /**
     * @param LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }
}
