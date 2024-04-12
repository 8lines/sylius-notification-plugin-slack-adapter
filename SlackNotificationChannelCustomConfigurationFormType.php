<?php

declare(strict_types=1);

namespace EightLines\SyliusNotificationPlugin\NotificationChannel\Symfony;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

final class SlackNotificationChannelCustomConfigurationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('recipient', TextType::class, [
            'label' => 'eightlines_sylius_notification_plugin.ui.recipient',
            'required' => false,
            'constraints' => [
                new Length([
                    'max' => 250,
                    'maxMessage' => 'eightlines_sylius_notification_plugin.notification.action.custom.recipient.max_length',
                    'groups' => ['sylius'],
                ]),
            ],
        ]);
    }
}
