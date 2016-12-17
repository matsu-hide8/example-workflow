<?php

namespace AppBundle\Entity;

class Cart
{
    private $marking;

    private $products;

    public function __construct()
    {
        $this->marking = 'shopping';
        $this->products = [];
    }

    public function getMarking()
    {
        return $this->marking;
    }

    public function setMarking($marking)
    {
        $this->marking = $marking;
        return $this;
    }

    public function addProduct($product)
    {
        $this->products[] = $product;
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
    }

    public function getProducts()
    {
        return $this->products;
    }
}
