<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Store;
use AppBundle\Form\StoreType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class StoreController
 * @package AppBundle\Controller
 * @Route("/store")
 */
class StoreController extends FOSRestController
{
    /**
     * @Route("")
     * @Method("GET")
     * @Rest\View(serializerGroups={"list"})
     */
    public function indexAction()
    {
        $stores = $this->getDoctrine()->getRepository('AppBundle:Store')->findAll();
        return ['stores' => $stores];
    }

    /**
     * @Route("/{id}")
     * @Method("GET")
     * @param Store $store
     * @return Store
     */
    public function detailAction(Store $store)
    {
        return $store;
    }

    /**
     * @Route("")
     * @Method("POST")
     * @param Request $request
     * @return Response|\Symfony\Component\Form\Form
     */
    public function createAction(Request $request)
    {
        $store = new Store();
        $form = $this->createForm(StoreType::class,$store);
        $form->handleRequest($request);
        $status = Response::HTTP_OK;
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            if ($existing = $em->getRepository('AppBundle:Store')
                ->findOneBy(['name' => $store->getName()])){
                $store = $existing;
            } else {
                $em->persist($store);
                $em->flush();
                $status = Response::HTTP_CREATED;
            }
            return $this->handleView(View::create(['stores' => [$store]], $status));
        }
        return $form;
    }

    /**
     * @Route("/{id}")
     * @Method("PUT")
     * @param Store $store
     * @param Request $request
     * @return null|\Symfony\Component\Form\Form
     */
    public function editAction(Store $store, Request $request)
    {
        $form = $this->createForm(StoreType::class, $store, [
            'method' => 'PUT'
        ]);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()){
            $this->getDoctrine()->getManager()->flush();
            return null;
        }
        return $form;
    }

    /**
     * @Route("/{id}")
     * @Method("DELETE")
     * @param Store $store
     * @return null
     */
    public function deleteAction(Store $store)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($store);
        return null;
    }
}
