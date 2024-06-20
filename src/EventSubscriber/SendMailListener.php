<?php

namespace Apb\MailerBundle\EventSubscriber;

use Apb\MailerBundle\Event\SendMailEvent;
use Apb\MailerBundle\Service\MailService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final readonly class SendMailListener
{
    public function __construct(
        private MailService $mailer,
    )
    {
    }

    #[AsEventListener(event: SendMailEvent::class)]
    public function onSendMail(SendMailEvent $event): void
    {
        $this->mailer->send($event->getEmail(), $event->getContext(), $event->getTemplate());
    }
}