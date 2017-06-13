<?php

namespace AppBundle\Factory;

use AppBundle\Entity\Purchase;

class PurchaseFactory
{
    public function create()
    {
        $purchase = new Purchase();
        $purchase->setPurchasedAt(new \DateTime());
        return $purchase;
    }
}