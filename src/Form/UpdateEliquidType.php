<?php

namespace App\Form;

use App\Entity\EliquidProducts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateEliquidType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('brand')
            ->add('flavor')
            ->add('size')
            ->add('price')
            ->add('stock')
            ->add('img')
            ->add('Enregistrer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EliquidProducts::class,
        ]);
    }
}
