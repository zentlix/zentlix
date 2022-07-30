<?php

declare(strict_types=1);

namespace Zentlix\Users\UI\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Uid\Uuid;
use Zentlix\Core\App\Shared\Application\Command\CommandBusInterface;
use Zentlix\Users\App\User\Application\Command\CreateUserCommand as CreateCommand;
use Zentlix\Users\App\User\Domain\Status;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\UserGroupRepositoryInterface;
use Zentlix\Users\App\User\Infrastructure\ReadModel\UserGroupView;

final class CreateUserCommand extends Command
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly UserGroupRepositoryInterface $groupRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('users:create:user')
            ->setDescription('Given an email, password, and name generates a new user.')
            ->addArgument('email', InputArgument::REQUIRED, 'Email address');
    }

    /** @throws \Exception */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $groups = array_map(
            static fn (UserGroupView $userGroup) => [
                'uuid' => $userGroup->uuid->toRfc4122(),
                'title' => $userGroup->title,
            ], $this->groupRepository->findAll());
        if ([] === $groups) {
            $io->info('Please, create at least one user group.');

            return self::INVALID;
        }

        $command = new CreateCommand();

        $command->setEmail($input->getArgument('email'));
        $command->password = $io->ask('Password', null, function ($password) {
            if (empty($password)) {
                throw new \InvalidArgumentException('Password cannot be empty.');
            }

            return $password;
        });

        $group = $io->choice('Please, select group', array_column($groups, 'title', 'uuid'), null);

        $command->setGroups([Uuid::fromString($group)]);
        $command->firstName = (string) $io->ask('First name');
        $command->lastName = (string) $io->ask('Last name');
        $command->middleName = (string) $io->ask('Middle name');

        $command->status = Status::from((string) $io->choice('Please, select user status', [
            Status::ACTIVE->value,
            Status::BLOCKED->value,
            Status::WAIT->value,
        ], 0));

        try {
            $this->commandBus->handle($command);
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());

            return self::FAILURE;
        }

        $io->success('User was created!');

        $io->text(array_filter([
            sprintf('Email: %s', $command->getEmail()->getValue()),
            sprintf('Password: %s', $command->password),
            $command->firstName ? sprintf('First name: %s', $command->firstName) : null,
            $command->lastName ? sprintf('Last name: %s', $command->lastName) : null,
            $command->middleName ? sprintf('Middle name: %s', $command->middleName) : null,
            sprintf('Group: %s', array_column($groups, 'title', 'uuid')[$group]),
            sprintf('Status: %s', $command->status->value),
        ]));

        return self::SUCCESS;
    }
}
