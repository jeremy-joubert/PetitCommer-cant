<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                "label" => false,
                "required" => true,
                'attr' => array(
                    'placeholder' => 'Entrez votre nom'
                )
            ])
            ->add('prenom', TextType::class,[
                "label" => false,
                "required" => true,
                'attr' => array(
                    'placeholder' => 'Entrez votre prenom'
                )
            ])
            ->add('email', EmailType::class,[
                "label" => false,
                "required" => true,
                'attr' => array(
                    'placeholder' => 'Entrez votre mail'
                )
            ])
            ->add('contenu', TextareaType::class,[
                "label" => false,
                "required" => true,
                'attr' => array(
                    'placeholder' => 'contenu'
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
