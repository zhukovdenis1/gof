<?php

/**
 * STATE
 * В методе next некрасивая конструкция. Можно делегировать метод next в Station в методе next() вызывать $this->station->next().
 *  Это будет выгдялеть красивее, но логика выбора станции будет размазана по всем стэйтам
 *  Также выбор состояния можно перенести в клиентский код, тогда паттерн будет назваться Стратегия
 *
 */


interface Station {public function play();}//State

class RadioEuropaPlus implements Station //Statу1
{
    public function play() {return 'playing Europa plus';}
}

class RadioDFM implements Station //State2
{
    public function play() {return 'playing DFm';}
}

//Context
class Player
{
    private $station; //state

    public function __construct(Station $station)
    {
        $this->station = $station;
    }

    public function next()
    {
        if ($this->station instanceof RadioEuropaPlus)
        {
            $this->station = new RadioDFM();
        }
        elseif ($this->station instanceof RadioDFM)
        {
            $this->station = new RadioEuropaPlus();
        }
    }

    public function playRadio()
    {
        return $this->station->play();
    }
}

/*client code*/

$player = new Player(new RadioDFM());
echo $player->playRadio() . '<br />';
$player->next();
echo $player->playRadio() . '<br />';
