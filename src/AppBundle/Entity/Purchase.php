<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

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
     * @JMS\Groups({"list"})
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="purchasedAt", type="date")
     * @JMS\Groups({"list"})
     */
    private $purchasedAt;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="purchases")
     */
    private $product;

    /**
     * @var float
     * @ORM\Column(name="quantity",type="decimal",precision=10,scale=2)
     * @JMS\Groups({"list"})
     */
    private $quantity;

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
}
