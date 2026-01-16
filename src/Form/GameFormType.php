<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class GameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Título',
                'constraints' => [
                    new NotBlank(message: 'El título es obligatorio'),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'constraints' => [
                    new NotBlank(message: 'La descripción es obligatoria'),
                ],
            ])
            ->add('price', MoneyType::class, [
                    'currency' => 'EUR',
                    'label' => 'Precio',
                    'constraints' => [
                        new NotBlank(),
                        new PositiveOrZero()
                    ],
                    'attr' => [
                        'class' => 'input form-control',
                        'step' => '0.01',
                    ],
                ])
            ->add('year', IntegerType::class, [
                'label' => 'Año de lanzamiento',
                'constraints' => [
                    new NotBlank(message: 'El año es obligatorio'),
                ],
            ])
            ->add('image', FileType::class, [
                'label' => 'Imagen del juego',
                'mapped' => false,
                'required' => $options['image_required'],
                'constraints' => $options['image_required'] ? [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Solo se permiten imágenes JPG o PNG',
                    ])
                ] : [],
            ])
            ->add('genres', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name',
                'label' => 'Géneros',
                'multiple' => true,
                'expanded' => true, 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
            'image_required' => true, 
        ]);
    }
}
