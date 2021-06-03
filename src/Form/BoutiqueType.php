<?php

namespace App\Form;

use App\Entity\Boutique;
use App\Entity\CategorieBoutique;
use App\Entity\Horaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoutiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                "label" => 'Nom : ',
                "required" => true,
            ])
            ->add('adresse', TextType::class,[
                "label" => 'Adresse : ',
                "required" => true,
            ])
            ->add('description', TextareaType::class,[
                "label" => 'Description : ',
                "required" => true,
            ])
            ->add('categorieBoutiques', EntityType::class,[
                'class' => CategorieBoutique::class,
                'choice_label' => 'nom',
                'multiple' => true,
                "label" => 'Catégorie :',
                "required" => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Boutique::class,
        ]);
    }
}
