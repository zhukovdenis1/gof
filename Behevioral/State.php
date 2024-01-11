<?php

/**
 * STATE/Strategy
 * Проблема: Варьировать поведение объекта в зависимости от его внутреннего состояния
 * Логика переключения между состояниями в самих состояниях
 * В некотрых реализациях встречал, что в State есть ссылка на контекст, для переключения состояния. В данном случае я сделал return new State. Мне кажется это лучше чем делать дополнительную зависиомость от context
 */

interface State
{
    public function next();
    public function getName();
}

class State1 implements State
{
    public function getName() {return 'State 1';}
    public function next() {return new State2();}

}

class State2 implements State
{
    public function getName() {return 'State 2';}
    public function next() {return new State1();}
}

class Context
{
    private $state;

    public function __construct(State $state) {$this->state = $state;}

    public function getStateName() {return $this->state->getName();}

    public function nextState() {$this->state = $this->state->next();}

}

/*client code*/

$context = new Context(new State1());
echo $context->getStateName() . '<br />';
$context->nextState();
echo $context->getStateName() . '<br />';
