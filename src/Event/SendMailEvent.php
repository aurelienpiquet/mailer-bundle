<?php

namespace Apb\MailerBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class SendMailEvent extends Event
{
    public function __construct(
        private string $email,
        private array $context,
        private ?string $template = null,
    )
    {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): SendMailEvent
    {
        $this->email = $email;
        return $this;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function setContext(array $context): SendMailEvent
    {
        $this->context = $context;
        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): SendMailEvent
    {
        $this->template = $template;
        return $this;
    }


}