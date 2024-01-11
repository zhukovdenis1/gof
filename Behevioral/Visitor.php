<?php

/*
 * VISITOR
 * Позволяет добавлять функционал к классам, не изменяя эти классы
 * Мои мысли. Если элементы имеют общего родителя, то можно этот новый общий метод реализовать в родителе с тем же перебором instanceof
 * Вместо if else instanceof используется перегрузка метода visit, в ЯП, где это поддерживается
 *
 * Недостатки:
 *   - затрудняется добавление нового элемента ClassN, т.к. во всех посетителях придётся дописывать метод VisitClassN,
 *     поэтому если часто добавляются классы, то этот паттерн использовать не следует
 *   - нарушает принцип grasp: инкапусуляция и information expert
 *   - достаточно легко может быть испорчен
 *   - сложно пишется и сложно читается
 *
 * Область применения: есть какой-то набор классов (имеющий общий интерфейс), но они недоступны для редактирования (фреймворк, относятся к другому
 * отделу, который не соглашается на редактирвоание ...) к котрым нужно добавлять методы
 *
 * Вторая область применения: держать часто меняющийся код за пределами классов: каждый раз передавать необоходимый
 *   visitor в зависимости от ситуации
 *
 * Третья область применения: много классов, к которым часто добавляются новые методы. (В этом случае методы будут
 *   добавляться в виде нового объекта, а старые классы не будут редактироваться)
 *
 * Замечание: если даже один раз один метод нельзя к ним добавить( accept), то можено использвоать адаптер
 */

interface IClass
{
    public function accept(IVisitor $v);
}

class Class1 implements IClass
{
    public function accept(IVisitor $v) {$v->visit($this);}
}

class Class2 implements IClass
{
    public function accept(IVisitor $v) {$v->visit($this);}
}

/* ... ClassN */

interface IVisitor
{
    public function visit(IClass $c);
}

class ExtraFunctional implements IVisitor
{
    public $resultMessage = '';

    public function visit(IClass $c)
    {
        $method = 'visit'.get_class($c);
        $this->$method();
        /*if ($c instanceof Class1)
            $this->resultMessage = 'Action for Class1';
        elseif ($c instanceof Class2)
            $this->resultMessage =  'Action for Class2';*/
    }

    public function visitClass1() { $this->resultMessage = 'Action for Class1';}
    public function visitClass2() { $this->resultMessage = 'Action for Class2';}
}

/*client code*/

$classes = [new Class1(), new Class2()];

foreach ($classes as $c)
{
    $visitor = new ExtraFunctional();
    $c->accept($visitor);
    echo $visitor->resultMessage.'<br>';
}
