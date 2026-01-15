<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'label' => 'Contraseña actual',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Introduce tu contraseña actual']),
                ],
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => 'Nueva contraseña',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Introduce la nueva contraseña']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres',
                    ]),
                ],
            ])
            ->add('repeatPassword', PasswordType::class, [
                'label' => 'Repetir nueva contraseña',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Repite la nueva contraseña']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
