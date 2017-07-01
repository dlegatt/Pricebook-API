<?php

namespace AppBundle\Form;

use AppBundle\DataTransformer\NameToProductTransformer;
use AppBundle\DataTransformer\NameToStoreTransformer;
use AppBundle\Entity\Product;
use AppBundle\Entity\Purchase;
use AppBundle\Entity\Store;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchaseType extends AbstractType
{
    /** @var  ObjectManager */
    private $em;

    /**
     * PurchaseType constructor.
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity',NumberType::class)
            ->add('product', TextType::class)
            ->add('store', TextType::class)
        ;

        $builder->get('product')
            ->addModelTransformer(new NameToProductTransformer($this->em));
        $builder->get('store')
            ->addModelTransformer(new NameToStoreTransformer($this->em));
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
