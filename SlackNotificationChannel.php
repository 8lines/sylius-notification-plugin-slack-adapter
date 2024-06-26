<?php

declare(strict_types=1);

namespace EightLines\SyliusNotificationPlugin\NotificationChannel\Symfony;

use EightLines\SyliusNotificationPlugin\NotificationChannel\NotificationBody;
use EightLines\SyliusNotificationPlugin\NotificationChannel\NotificationChannelInterface;
use EightLines\SyliusNotificationPlugin\NotificationChannel\NotificationContext;
use EightLines\SyliusNotificationPlugin\NotificationChannel\NotificationRecipient;
use Symfony\Component\Notifier\Bridge\Slack\Block\SlackHeaderBlock;
use Symfony\Component\Notifier\Bridge\Slack\Block\SlackSectionBlock;
use Symfony\Component\Notifier\Bridge\Slack\SlackOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

final class SlackNotificationChannel implements NotificationChannelInterface
{
    private const SLACK_TRANSPORT = 'slack';

    public function __construct(
        private ChatterInterface $chatter,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(
        ?NotificationRecipient $recipient,
        NotificationBody $body,
        NotificationContext $context,
    ): void {
        $message = $body->getMessage();

        if (null === $message) {
            throw new \InvalidArgumentException('The message cannot be null.');
        }

        $options = $this->buildSlackOptions($body, $context);

        $chatMessage = new ChatMessage($message);
        $chatMessage->options($options);
        $chatMessage->transport(self::SLACK_TRANSPORT);

        $this->chatter->send($chatMessage);
    }

    public static function getIdentifier(): string
    {
        return 'slack';
    }

    public static function supportsUnknownRecipient(): bool
    {
        return true;
    }

    public static function getConfigurationFormType(): ?string
    {
        return SlackNotificationChannelFormType::class;
    }

    private function buildSlackOptions(NotificationBody $body, NotificationContext $context): SlackOptions
    {
        $message = $body->getMessage();

        $configuration = $context->getConfiguration();

        if (json_validate($message)) {
            $jsonMessage = json_decode($message, true);

            if (true === $configuration->hasCustomValue('recipient')) {
                $jsonMessage['recipient_id'] = $configuration->getCustomValue('recipient');
            }

            return new SlackOptions($jsonMessage);
        }

        $options = new SlackOptions();

        if (true === $configuration->hasCustomValue('recipient')) {
            $options->recipient($configuration->getCustomValue('recipient'));
        }

        $subject = $body->getSubject();

        if (null !== $subject) {
            $options->block(new SlackHeaderBlock($subject));
        }

        $options->block((new SlackSectionBlock())->text($message));

        return $options;
    }
}
