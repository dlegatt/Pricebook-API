<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProductController
 * @package AppBundle\Controller
 * @Route("/product")
 */
class ProductController extends FOSRestController
{
    /**
     * @Rest\View(serializerGroups={"list"})
     * @Route("")
     * @Method("GET")
     */
    public function indexAction()
    {
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findAllWithPurchases();
        return ['products' => $products];
    }

    /**
     * @Rest\View(serializerGroups={"list"})
     * @param Product $product
     * @return Product
     * @Route("/{id}")
     * @Method("GET")
     */
    public function detailAction(Product $product)
    {
        return $product;
    }

    /**
     * @Rest\View(serializerGroups={"list"})
     * @Route("")
     * @Method("POST")
     * @param Request $request
     * @return Form|Response
     */
    public function createAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            if ($existing = $em->getRepository('AppBundle:Product')
                ->findOneBy(['name' => $product->getName()])){
                $product = $existing;
            } else {
                $em->persist($product);
                $em->flush();
            }
            return $this->handleView(View::create(['products' => [$product]]));
        }
        return $form;
    }

    /**
     * @param Product $product
     * @param Request $request
     * @Route("/{id}")
     * @return Form | null
     * @Method("PUT");
     */
    public function editAction(Product $product, Request $request)
    {
        $form = $this->createForm(ProductType::class, $product,[
            'method' => 'PUT'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();
            return null;
        }
        return $form;
    }

    /**
     * @param Product $product
     * @Route("/{id}")
     * @Method("DELETE")
     */
    public function deleteAction(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        return;
    }
}
