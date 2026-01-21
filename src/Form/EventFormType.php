<?php
namespace App\Form;

use App\Entity\Event;
use App\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre del evento'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción'
            ])
            ->add('eventDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Fecha del evento'
            ])
            ->add('games', EntityType::class, [
                'class' => Game::class,
                'choices' => $options['user_games'],
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true, 
                'label' => 'Juegos del evento'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'user_games' => [] 
        ]);
    }
}
