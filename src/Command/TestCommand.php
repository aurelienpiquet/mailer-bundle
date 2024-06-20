<?php

namespace Apb\MailerBundle\Command;

use Apb\MailerBundle\Event\SendMailEvent;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'mailer-bundle:test',
    description: 'Send a test email from MailerBundle to specified address',
    hidden: false,
)]
class TestCommand extends Command
{
    public function __construct(
        private readonly EventDispatcherInterface $dispatcher,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->dispatcher->dispatch(new SendMailEvent('apiquet@feelity.fr', ['title' => 'Email received from command', 'message' => 'Mailer bundle works']));

        $io->success('Mail send');

        return Command::SUCCESS;
    }
}