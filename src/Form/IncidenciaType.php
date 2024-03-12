<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Incidencias;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class IncidenciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('estado', ChoiceType::class, [
                'choices' =>[
                    'Iniciada' => 'Iniciada',
                    'En proceso'=> 'En proceso',
                    'Resuelta' => 'Resuelta',
                ],
                'placeholder' => 'Eliga el estado de su incidencia',
            ])
          
            ->add('Insertar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Incidencias::class,
        ]);
    }
}
  // ->add('usuario', EntityType::class, [
            //     'class' => Usuario::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('cliente', EntityType::class, [
            //     'class' => Cliente::class,
            //     'choice_label' => 'id',
            // ])
