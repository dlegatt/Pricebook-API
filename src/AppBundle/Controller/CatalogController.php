<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CatalogController
 * @package AppBundle\Controller
 * @Route("/catalog")
 */
class CatalogController extends FOSRestController
{
    /**
     * @Route("")
     * @Method("GET")
     */
    public function indexAction()
    {
        $products = $this->forward('AppBundle:Product:index')->getContent();
        $stores = $this->forward('AppBundle:Store:index')->getContent();
        $purchases = $this->forward('AppBundle:Purchase:index')->getContent();

        $products = json_decode($products,true);
        $stores = json_decode($stores,true);
        $purchases = json_decode($purchases, true);

        return array_merge($products,$stores,$purchases);
    }
}
