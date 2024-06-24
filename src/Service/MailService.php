<?php

declare(strict_types=1);

namespace Apb\MailerBundle\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

/**
 * {@inheritdoc}
 */
readonly class MailService implements MailServiceInterface
{
    public const DEFAULT_TEMPLATE = '@ApbMailer/message.mjml.twig';

    public function __construct(
        private MailerInterface     $mailer,
        private MJMLService         $service,
        private ParameterBagInterface $bag
    ) {
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed[] $context
     */
    public function send(string $mail, array $context = [], ?string $template = null, ?bool $showError = false): bool|string
    {
        if (!$template) {
            $template = self::DEFAULT_TEMPLATE;
        }

        $email = $this->prepare($mail, $template, $context);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            if ($showError) {
                return $e->getMessage();
            }

            return false;
        }

        return true;
    }

    /**
     * @param string $template
     * @param mixed[] $context
     * @return Email
     */
    private function prepare(string $mail, string $template, array $context = []): Email
    {
        $configuration = $this->bag->get('mailer_bundle.configuration');

        foreach ($configuration as $key => $value) {
            $context[$key] = $value;
        }

        $context['style'] = isset($configuration['style']) ? file_get_contents($configuration['style']) : file_get_contents(__DIR__ . '/../../Resources/private/template.css');

        $email = (new Email())
            ->to($mail)
            ->subject(sprintf("[%s] %s", $context['projectName'], $context['title']))
            ->from(new Address($context['sender'], $context['senderStr']))
            ->html(
                $this->service->render($template, $context)
            )
        ;

        if (\array_key_exists('attachment', $context)) {
            $email->attach($context['attachment']['content'], $context['attachment']['name']);
        }

        return $email;
    }
}
