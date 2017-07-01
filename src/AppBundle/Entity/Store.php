<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;


/**
 * Store
 *
 * @ORM\Table(name="store")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StoreRepository")
 */
class Store
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Groups({"list","purchase_create"})
     */
    private $id;

    /**
     * @var string
     * @JMS\Groups({"list","purchase_create"})
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Purchase", mappedBy="store")
     */
    private $purchases;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->purchases = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Store
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add purchase
     *
     * @param Purchase $purchase
     *
     * @return Store
     */
    public function addPurchase(Purchase $purchase)
    {
        $this->purchases[] = $purchase;

        return $this;
    }

    /**
     * Remove purchase
     *
     * @param Purchase $purchase
     */
    public function removePurchase(Purchase $purchase)
    {
        $this->purchases->removeElement($purchase);
    }

    /**
     * Get purchases
     *
     * @return ArrayCollection
     */
    public function getPurchases()
    {
        return $this->purchases;
    }
}
