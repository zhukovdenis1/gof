<?php

/*
 * Chain of Responsibility
 * Проблема: запрос должен быть обработан несколькими объектами
 * Область применения:  имеется более одного объекта, способного обработать запрос и обработчик заранее неизвестен
 * Преимущества: ослабляет связанность (объект не обязан знать кто именно обработает его запрос)
 * Недостатки: нет гарантий, что запрос будет обработан, поскольку он не имеет явного получателя. Поэтому по дефолку
 *   обычно ставят errorHandler
 * Замечание: шаблон не говорит о том, где должна быть реализована последовательность: это может быть определено
 *   динамически (в клиентском коде), в конфиг. файле, внутри метода handle, который может прервать цепочку или вызвыать
 *   следующий обработчик...
 */

interface IHandler
{
    public function handle();
}

class ConcreteHandler1
{
    public function handle()
    {
        echo 'handler 1 actions<br />';
        $success = mt_rand(0,1) ? true : false;
        return $success;
    }
}

class ConcreteHandler2
{
    public function handle()
    {
        echo 'handler 2 actions<br />';
        $success = mt_rand(0,1) ? true : false;
        return $success;
    }
}

class ErrorHandler
{
    public function handle()
    {
        echo 'error handler actions<br />';
        return true;
    }
}

/* client code */

$h1 = new ConcreteHandler1();
$h2 = new ConcreteHandler2();
$error = new ErrorHandler();

$chan = [$h1, $h2, $error];

$i = 0;
while (!$chan[$i]->handle()) {$i++;}

