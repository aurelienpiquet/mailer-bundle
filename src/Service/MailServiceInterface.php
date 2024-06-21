<?php

namespace Apb\MailerBundle\Service;

/**
 * Represents the interface that all mail service must implement.
 */
interface MailServiceInterface
{
    /**
     * Interface to send mails. Send requires a mail, an array of context and a template
     *
     * @param string $mail
     * @param array $context
     * @param string|null $template
     * @return bool
     */
    public function send(string $mail, array $context = [], ?string $template = null): bool;
}