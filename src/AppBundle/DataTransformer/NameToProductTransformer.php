<?php

namespace AppBundle\DataTransformer;

use AppBundle\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

class NameToProductTransformer implements DataTransformerInterface
{
    /** @var  ObjectManager */
    private $em;

    /**
     * NameToStoreTransformer constructor.
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }


    /**
     * @param Product $product
     * @return string
     */
    public function transform($product)
    {
        if (null === $product){
            return '';
        }

        return $product->getName();
    }


    public function reverseTransform($name)
    {
        if (!$name) {
            return;
        }

        $product = $this->em->getRepository('AppBundle:Product')
            ->findOneBy(['name' => $name]);
        if (null === $product) {
            $product = new Product();
            $product->setName($name);
            $this->em->persist($product);
        }
        return $product;
    }
}