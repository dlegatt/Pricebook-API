<?php

namespace AppBundle\Form;

use AppBundle\Entity\Product;
use AppBundle\Entity\Purchase;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity',NumberType::class)
            ->add('product', EntityType::class,[
                'class' => Product::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Purchase::class,
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return 'purchase_form';
    }
}
