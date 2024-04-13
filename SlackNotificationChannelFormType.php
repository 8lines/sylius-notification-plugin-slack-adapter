<?php

declare(strict_types=1);

namespace EightLines\SyliusNotificationPlugin\NotificationChannel\Symfony;

use EightLines\SyliusNotificationPlugin\Form\EventSubscriber\AddContentFormSubscriber;
use EightLines\SyliusNotificationPlugin\Form\EventSubscriber\AddCustomConfigurationFormSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

final class SlackNotificationChannelFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventSubscriber(new AddCustomConfigurationFormSubscriber(
            type: SlackNotificationChannelCustomConfigurationFormType::class,
        ));

        $builder->addEventSubscriber(new AddContentFormSubscriber(
            subject: true,
            message: true,
            options: [
                'subject_required' => false,
            ],
        ));
    }
}
