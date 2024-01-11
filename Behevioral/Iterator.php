<?php


/**
 * ITERATOR
 * Задача: составной элемент, например список, должен предоставлять доступ к своим элементам (объектам) не раскрывая
 *   их внутреннюю структуру,причем перебирать список требуется по разному, в зависимости от задачи
 * В примере выдаются нечетные элементы списка
 * Применяется когда дан большой список, от которого не получится сделать отсортированные копии т.к. переполнится память.
 * (если список небольшой, то каждому пользователю можно передать его копию и он может сортировать его как угодно)
 */

interface IIterator
{
    public function next();
}


class OddIterator implements IIterator
{
    private $list;
    private $position;

    public function __construct(array $list)
    {
        $this->position = 0;
        $this->list = $list;
    }

    public function next()
    {
        while ($this->position < count($this->list)) {
            $pos = $this->position++;
            if ($this->list[$pos]->getI() % 2) {
                return $this->list[$pos];
            }
        }
        return false;
    }
}

class Item
{
    private $name = '';
    private $i = 0;

    public function __construct($name, $i)
    {
        $this->name = $name;
        $this->i = $i;
    }

    public function getName() {return $this->name;}
    public function getI() {return $this->i;}
}

/*client code*/

$itemList = [new Item('A', 1), new Item('B', 2), new Item('C', 3)];

$iterator = new OddIterator($itemList);

while ($item = $iterator->next())
{
    echo $item->getName() . ' -> ' . $item->getI() . '<br />';
}

