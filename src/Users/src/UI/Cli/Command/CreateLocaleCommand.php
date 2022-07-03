<?php

declare(strict_types=1);

namespace Zentlix\Users\UI\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Zentlix\Core\App\Shared\Application\Command\CommandBusInterface;
use Zentlix\Users\App\Locale\Application\Command\CreateCommand;

final class CreateLocaleCommand extends Command
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('users:create:locale')
            ->setDescription('Given a title, code, country code, sort generates a new locale.')
            ->addArgument('title', InputArgument::REQUIRED, 'Locale title');
    }

    /** @throws \Exception */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $command = new CreateCommand();

        $command->title = $input->getArgument('title');

        /** @psalm-suppress PropertyTypeCoercion */
        $command->code = (string) $io->ask('Locale code', null, function (mixed $code): string {
            if (empty($code)) {
                throw new \RuntimeException('Locale code cannot be empty.');
            }

            return $code;
        });

        /** @psalm-suppress PropertyTypeCoercion */
        $command->countryCode = (string) $io->ask('Country code', null, function (mixed $code): string {
            if (empty($code)) {
                throw new \RuntimeException('Country code cannot be empty.');
            }

            return $code;
        });

        /** @psalm-suppress PropertyTypeCoercion */
        $command->sort = (int) $io->ask('Locale sort', '1', function (mixed $sort): int {
            if ((int) $sort < 1) {
                throw new \RuntimeException('Locale sort must be a positive int.');
            }

            return (int) $sort;
        });

        try {
            $this->commandBus->handle($command);
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());

            return self::FAILURE;
        }

        $io->success('Locale was created!');
        $io->text([
            "Title: $command->title",
            "Code: $command->code",
            "Country code: $command->countryCode",
            "Sort: $command->sort",
        ]);

        return self::SUCCESS;
    }
}
