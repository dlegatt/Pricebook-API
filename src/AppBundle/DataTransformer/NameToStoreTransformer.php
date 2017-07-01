<?php

namespace AppBundle\DataTransformer;

use AppBundle\Entity\Store;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class NameToStoreTransformer implements DataTransformerInterface
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
     * @param Store $product
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
        if (! $name){
            return;
        }

        $store = $this->em->getRepository('AppBundle:Store')
            ->findOneBy(['name' => $name]);
        if (null === $store){
            $store = new Store();
            $store->setName($name);
            $this->em->persist($store);
        }
        return $store;
    }
}
