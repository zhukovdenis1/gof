<?php

/*
 * Builder позволяет отделить построение сложного объекта от его представления.
 *
 */


class Product
{
    private $id;
    private $name;
    private $price;

    public function getId() {return $this->id;}
    public function getName() {return $this->name;}
    public function getPrice() {return $this->price;}

    public function setId($id) {$this->id = $id;}
    public function setName($name) {$this->name = $name;}
    public function setPrice($price) {$this->price = $price;}

}

class ProductBuilder
{
    private $product;

    public function __construct()
    {
        $this->product = new Product();
        return $this;
    }

    public function setId($id) {$this->product->setId($id); return $this;}

    public function setName($name) {$this->product->setName($name);return $this;}

    public function setPrice($price) {$this->product->setPrice($price); return $this;}

    public function get() { return $this->product;}

    public function getReset()
    {
        $result = $this->product;
        $this->product = new Product();
        return $result;
    }
}

/*client code:*/
$product = (new ProductBuilder)
    ->setId(1)
    ->setName('Computer')
    ->setPrice(100.00)
    ->get();

//Возможно использования менеджера(директор) для сценаривев создания

$manager = new ProductManager();
$manager -> setBuilder(new ProductBuilder());
$product1 = $manager->createCleanProduct();
$product2 = $manager->createFreeProduct();

class ProductManager
{
    private $builder;

    public function setBuilder(ProductBuilder $builder) {
        $this->builder = $builder;
        return $this;
    }

    public function createCleanProduct()
    {
        return $this->builder->getReset();
    }

    public function createFreeProduct()
    {
        return $this->builder->setPrice(0)->getReset();
    }

}
