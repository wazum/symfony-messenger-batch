<?php

declare(strict_types=1);

namespace App\Example\Domain\Event;

use App\Example\Domain\Contract\DomainEvent;

final class CatFactReceived implements DomainEvent
{
    private readonly string $fact;

    public function __construct(string $fact)
    {
        $this->fact = trim($fact);
    }

    public function getFact(): string
    {
        return $this->fact;
    }
}
