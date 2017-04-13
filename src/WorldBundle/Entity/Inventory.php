<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Inventory
 *
 * @ORM\Table(name="inventory")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\InventoryRepository")
 */
class Inventory
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Many Player have One Inventory.
     * @ORM\OneToOne(targetEntity="Player", inversedBy="inventory")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    private $player;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    protected $quantity;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Item", mappedBy="inventory")
     * @ORM\JoinTable(name="inventory_item")
     */
    private $items;



    public function __construct() {
      $this->items = new ArrayCollection();
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
     * Set quantity
     *
     * @param int $quantity
     *
     * @return Inventory
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Add quantity
     *
     * @param int $quantity
     *
     * @return Inventory
     */
    public function addQuantity($quantity)
    {
        $this->quantity += $quantity;

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
     * add item
     *
     * @return item
     */
    public function addItem($item){
        $this->addQuantity($item['quantity']);
        $this->items->add($item['item']);
    }
}

