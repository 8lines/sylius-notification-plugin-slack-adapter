<?php

declare(strict_types=1);

namespace EightLines\SyliusNotificationPlugin\NotificationChannel\Symfony;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class SlackNotificationChannelCustomConfigurationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('recipient', TextType::class, [
            'label' => 'eightlines_sylius_notification_plugin.form.notification_channel.recipient',
            'required' => false,
        ]);
    }
}
