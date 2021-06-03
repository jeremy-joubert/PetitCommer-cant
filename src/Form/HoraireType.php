<?php

namespace App\Form;

use App\Entity\Horaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HoraireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jour', ChoiceType::class, [
                "label" => 'Selectionner le jour : ',
                'choices'  => [
                    'lundi' => 'lundi',
                    'mardi' => 'mardi',
                    'mercredi' => 'mercredi',
                    'jeudi' => 'jeudi',
                    'vendredi' => 'vendredi',
                    'samedi' => 'samedi'
                ],
            ])
            ->add('heureDebutMatin', IntegerType::class, [
                'attr' => [
                    'min' => 6,
                    'max' => 20
                ]
            ])
            ->add('heureFinMatin', IntegerType::class, [
                'attr' => [
                    'min' => 6,
                    'max' => 20
                ]
            ])
            ->add('heureDebutApresMidi', IntegerType::class, [
                'attr' => [
                    'min' => 6,
                    'max' => 20
                ]
            ])
            ->add('heureFinApresMidi', IntegerType::class, [
                'attr' => [
                    'min' => 6,
                    'max' => 20
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Horaire::class,
        ]);
    }
}
