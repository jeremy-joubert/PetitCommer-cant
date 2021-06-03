<?php

namespace App\Form;

use App\Entity\BoutiqueSearch;
use App\Entity\CategorieBoutique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoutiqueSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorieBoutique', EntityType::class,[
                'class' => CategorieBoutique::class,
                'choice_label' => 'nom',
                'multiple' => false,
                "label" => false,
                "required" => false,
                'placeholder' => 'Choisir un type de commerce'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BoutiqueSearch::class,
        ]);
    }
}
