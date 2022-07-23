<?php

declare(strict_types=1);

namespace Zentlix\Users\UI\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Zentlix\Core\App\Shared\Application\Command\CommandBusInterface;
use Zentlix\Users\App\User\Application\Command\CreateUserGroupCommand as GroupCommand;
use Zentlix\Users\App\User\Domain\Role;

final class CreateUserGroupCommand extends Command
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('users:create:group')
            ->setDescription('Given a title, code, group role, and sort generates a new user group.')
            ->addArgument('title', InputArgument::REQUIRED, 'User group title');
    }

    /** @throws \Exception */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = new GroupCommand();

        $command->title = $input->getArgument('title');

        $io = new SymfonyStyle($input, $output);

        $command->code = $io->ask('Group symbol code', null, function (mixed $code) {
            if (empty($code)) {
                throw new \InvalidArgumentException('Symbol code cannot be empty.');
            }

            return (string) $code;
        });
        $command->role = Role::from($io->choice(
            'Please, select a group role',
            [Role::ADMIN->value, Role::USER->value],
            0
        ));
        $command->sort = $io->ask('Group sort', '1', function (mixed $sort) {
            if (empty($sort) || (int) $sort < 1) {
                throw new \InvalidArgumentException('Group sort must be a positive int.');
            }

            return (int) $sort;
        });

        try {
            $this->commandBus->handle($command);
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());

            return self::FAILURE;
        }

        $io->success('User group was created!');
        $io->text([
            sprintf('Title: %s', $command->title),
            sprintf('Symbol code: %s', $command->code),
            sprintf('Role: %s', $command->role->value),
            sprintf('Sort: %s', $command->sort),
        ]);

        return self::SUCCESS;
    }
}
