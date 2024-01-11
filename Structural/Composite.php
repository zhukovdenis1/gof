<?php

/**
 * COMPOSITE
 * Применяется для обработки композиции структур (обычно деревья) (скрытая рекурсия)
 * Преимущества: 
 *    - нет явной рекурсии, которая может зациклиться
 *    - код сложно испортить, он легко читается
 */

abstract class Composite
{
    protected $name;
    public abstract function print();
}

class Node extends Composite
{
    protected $children = array();

    public function __construct($name) {$this->name = $name;}

    public function print($space = '')
    {
        $space .= "-";
        echo $space . $this->name . '<br />';
        foreach ($this->children as $c) {
            $c->print($space);
        }
    }

    public function addChild(Composite $child)
    {
        $this->children[] = $child;
    }
}

class Leaf extends Composite
{
    public function __construct($name) {$this->name = $name;}

    public function print($space = '')
    {
        $space .= "-";
        echo $space . $this->name . '<br />';
    }
}


/*client code*/

$mainNode = new Node('mainNode');
$node1 = new Node('node1');
$node2 = new Node('node2');
$leaf1_1 = new Leaf('leaf 1-1');
$leaf1_2 = new Leaf('leaf 1-2');
$leaf2_1 = new Leaf('leaf 2-1');
$mainNode->addChild($node1);
$mainNode->addChild($node2);
$node1->addChild($leaf1_1);
$node1->addChild($leaf1_2);
$node2->addChild($leaf2_1);

$node3 = new Node('node3');
$leaf3_1 = new Leaf('leaf 3-1');
$node2->addChild($node3);
$node3->addChild($leaf3_1);

$mainNode->print();
