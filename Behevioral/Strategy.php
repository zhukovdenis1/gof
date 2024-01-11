<?php

/**
 * STRATEGY
 * Тот же State, только логика переключения между состояниями в клиентском коде
 */

interface Strategy
{
    public function execute();
}

class Strategy1 implements Strategy
{
    public function execute() {return 'Executed strategy 1';}

}

class Strategy2 implements Strategy
{
    public function execute() {return 'Executed stragegy 2';}
}

class Context
{
    private $strategy;

    public function __construct(Strategy $strategy) {$this->strategy = $strategy;}

    public function execute() {return $this->strategy->execute();}

}

/*client code*/

$context = new Context(new Strategy1());
echo $context->execute() . '<br />';
$context = new Context(new Strategy2());
echo $context->execute() . '<br />';
