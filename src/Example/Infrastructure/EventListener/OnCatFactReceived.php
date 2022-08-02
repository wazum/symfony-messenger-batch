<?php

declare(strict_types=1);

namespace App\Example\Infrastructure\EventListener;

use App\Example\Domain\Event\CatFactReceived;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\Acknowledger;
use Symfony\Component\Messenger\Handler\BatchHandlerInterface;
use Symfony\Component\Messenger\Handler\BatchHandlerTrait;

#[AsMessageHandler(fromTransport: 'async')]
final class OnCatFactReceived implements BatchHandlerInterface
{
    use BatchHandlerTrait;

    public function __construct(private readonly ConsoleOutput $output)
    {
    }

    public function __invoke(CatFactReceived $event, Acknowledger $ack = null): mixed
    {
        return $this->handle($event, $ack);
    }

    // Set a custom limit
    private function shouldFlush(): bool
    {
        return 12 <= \count($this->jobs);
    }

    private function process(array $jobs): void
    {
        $facts = [];
        foreach ($jobs as [$message, $ack]) {
            $facts[] = $message->getFact();
            $ack->ack($message);
        }

        $this->output->writeln('Processed new batch of cat facts');
        $this->output->writeln(str_repeat('-', 60));
        $line = 1;
        foreach ($facts as $fact) {
            $this->output->writeln(sprintf('%d. %s', $line++, $fact));
        }
        $this->output->writeln(PHP_EOL);
    }
}
