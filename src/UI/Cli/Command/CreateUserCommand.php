<?php

namespace App\UI\Cli\Command;

use App\Application\User\Command\CreateUser;
use Exception;
use League\Tactician\CommandBus;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreateUserCommand
 */
class CreateUserCommand extends Command
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * CreateUserCommand constructor.
     *
     * @param CommandBus $commandBus
     * @param LoggerInterface $logger
     */
    public function __construct(CommandBus $commandBus, LoggerInterface $logger, ValidatorInterface $validator)
    {
        parent::__construct();

        $this->commandBus = $commandBus;
        $this->logger = $logger;
        $this->validator = $validator;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:user:create')
            ->setDescription('Creates a new user with given data.')

            ->addArgument('name', InputArgument::REQUIRED, 'First name')
            ->addArgument('surname', InputArgument::REQUIRED, 'Last name')
            ->addArgument('email', InputArgument::REQUIRED, 'Email address')
            ->addArgument('pesel', InputArgument::REQUIRED, 'PESEL')
            ->addArgument('langs', InputArgument::OPTIONAL, 'Programming languages')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $uuid = Uuid::uuid4()->toString();

        $command = new CreateUser(
            $uuid,
            $input->getArgument('name'),
            $input->getArgument('surname'),
            $input->getArgument('email'),
            $input->getArgument('pesel'),
            $input->getArgument('langs')
        );

        $errors = $this->validator->validate($command);

        if ($errors->count() === 0) {
            try {
                $this->commandBus->handle($command);

                $this->logger->info("Created user: $uuid");
            } catch (Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $this->logger->error(sprintf('%s: %s', $error->getPropertyPath(), $error->getMessage()));
        }

        return 1;
    }
}
