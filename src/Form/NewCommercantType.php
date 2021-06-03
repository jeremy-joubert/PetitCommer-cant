<?php

namespace App\Form;

use App\Entity\Boutique;
use App\Entity\Commercant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewCommercantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                "label" => 'Nom : ',
                "required" => true,
            ])
            ->add('prenom', TextType::class,[
                "label" => 'Prénom : ',
                "required" => true,
            ])
            ->add('boutique', EntityType::class,[
                'class' => Boutique::class,
                'choice_label' => 'nom',
                'multiple' => false,
                "label" => 'Boutique :',
                "required" => true,
            ])
            ->add('images', FileType::class,[
                'multiple' => true,
                "label" => 'Image(s) :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
}
