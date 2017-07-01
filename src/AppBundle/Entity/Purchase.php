<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Purchase
 *
 * @ORM\Table(name="purchase")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PurchaseRepository")
 */
class Purchase
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Groups({"list", "purchase_create"})
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="purchasedAt", type="date")
     * @JMS\Groups({"list", "purchase_create"})
     */
    private $purchasedAt;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="purchases")
     * @JMS\Groups({"purchase_create"})
     * @Assert\NotNull()
     */
    private $product;

    /**
     * @var float
     * @ORM\Column(name="quantity",type="decimal",precision=10,scale=2)
     * @JMS\Groups({"list","purchase_create"})
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric")
     */
    private $quantity;

    /**
     * @var Store
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Store", inversedBy="purchases")
     * @JMS\Groups({"purchase_create"})
     * @Assert\NotNull()
     */
    private $store;

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
     * Set purchasedAt
     *
     * @param \DateTime $purchasedAt
     *
     * @return Purchase
     */
    public function setPurchasedAt($purchasedAt)
    {
        $this->purchasedAt = $purchasedAt;

        return $this;
    }

    /**
     * Get purchasedAt
     *
     * @return \DateTime
     */
    public function getPurchasedAt()
    {
        return $this->purchasedAt;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Set quantity
     *
     * @param string $quantity
     *
     * @return Purchase
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return int
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("product_id")
     * @JMS\Groups({"list"})
     */
    public function getProductId()
    {
        return $this->getProduct()->getId();
    }

    /**
     * @return int
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("store_id")
     * @JMS\Groups({"list"})
     */
    public function getStoreId()
    {
        return $this->getStore()->getId();
    }

    /**
     * Set store
     *
     * @param \AppBundle\Entity\Store $store
     *
     * @return Purchase
     */
    public function setStore(\AppBundle\Entity\Store $store = null)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Get store
     *
     * @return \AppBundle\Entity\Store
     */
    public function getStore()
    {
        return $this->store;
    }
}
