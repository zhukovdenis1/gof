<?php

/*
 * ADAPTER
 *
 * Варианта использования:
 *  - Подключение внешних библиотек, интерфейсы которых могут меняться
 *  - Неудобный интерфейс (например на непонятном языке)
 */

class BadClass
{
    public function asdfasdf()
    {
        return 'asdfasf';
    }

    public function bbbbeeee()
    {
        return 'eeeeaaa';
    }
}


interface IAdapter
{
    public function a();

    public function b();
}

class Adapter implements IAdapter
{
    private $badObject;

    public function __construct(ВadClass $badObj)
    {
        $this->badObject = new ВadClass();
    }

    public function a()
    {
        return $this->badObject->asdfasdf();
    }

    public function b()
    {
        return $this->badObject->bbbbeeee();
    }
}

/*client code:*/

$obj = new Adapter();
echo $obj->a();