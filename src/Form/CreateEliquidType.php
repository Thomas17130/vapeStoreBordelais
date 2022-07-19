<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\EliquidProducts;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateEliquidType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class)
            ->add('brand',EntityType::class, [
                'choice_label' => 'name',
                'class' => Brand::class
            ])
            /*->add('brand', TextType::class)*/
            ->add('flavor',TextType::class)
            ->add('price', NumberType::class)
            ->add('size', NumberType::class)
            ->add('stock', NumberType::class)
            ->add('img', FileType::class, [
                'required' => false,
                'mapped' => false
            ])
            ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EliquidProducts::class,
        ]);
    }
}
