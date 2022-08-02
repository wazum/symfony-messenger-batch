<?php

declare(strict_types=1);

namespace App\Example\Infrastructure\Console;

use App\Example\Domain\Event\CatFactReceived;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(name: 'app:import')]
final class ImportCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $eventBus,
        private readonly HttpClientInterface $httpClient
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        for ($i = 0; $i < 15; ++$i) {
            try {
                $response = $this->httpClient->request('GET', 'https://catfact.ninja/fact');
                $content = $response->toArray();
            } catch (ClientExceptionInterface|DecodingExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
                continue;
            }
            $this->eventBus->dispatch(new CatFactReceived($content['fact']));
        }

        return Command::SUCCESS;
    }
}
