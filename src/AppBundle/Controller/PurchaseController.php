<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Purchase;
use AppBundle\Form\PurchaseType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchaseController extends FOSRestController
{
    /**
     * @Rest\View(serializerGroups={"list"})
     * @Route("/purchase")
     * @Method("GET")
     */
    public function indexAction()
    {
        $purchases = $this->getDoctrine()
            ->getRepository('AppBundle:Purchase')
            ->findAllWithProduct();
        return View::create(['purchases' => $purchases]);
    }

    /**
     * @Route("/purchase/{id}")
     * @Method("GET")
     * @Rest\View(serializerGroups={"list"})
     */
    public function detailAction(Purchase $purchase)
    {
        return $purchase;
    }

    /**
     * @param Request $request
     * @return View|\Symfony\Component\Form\Form
     * @Route("/purchase")
     * @Method("POST")
     * @Rest\View(serializerGroups={"list"})
     */
    public function createAction(Request $request)
    {
        $purchase = $this->get('app.factory.purchase')->create();
        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($purchase);
            $em->flush();
            return View::create(['purchase' => $purchase],Response::HTTP_CREATED);
        }
        return $form;
    }

    /**
     * @param Purchase $purchase
     * @param Request $request
     * @return null|\Symfony\Component\Form\Form
     * @Route("/purchase/{id}")
     * @Method("PUT")
     */
    public function editAction(Purchase $purchase, Request $request)
    {
        $form = $this->createForm(PurchaseType::class, $purchase,[
            'method' => 'PUT'
        ]);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();
            return null;
        }
        return $form;
    }

    /**
     * @param Purchase $purchase
     * @return null
     * @Route("/purchase/{id}")
     * @Method("DELETE")
     */
    public function deleteAction(Purchase $purchase)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($purchase);
        $em->flush();
        return null;
    }
}