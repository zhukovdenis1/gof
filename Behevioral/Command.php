<?php


/**
 * COMMAND
 * Область применения: есть мало сущностей и много операций с ними. Особенно когда нужна возможность делать откаты операций
 *   (для команд добавить наряду с execute() метод undo())
 * Пример: рисование. комманды:нарисовать линию, переместить объект, изменить размер ...
 * Этот паттерн нарушает объектоориентированную парадигму т.к. оперирует не объектами, а событиями, но в ситуациях когда он нужен, без
 *  него обойтись трудно.
 * Преимущества: обработка команды в виде объекта, что позволяет сохранять её, передавать в качестве параметра методам,
 *   а также возвращать ее в виде результата, как и любой другой объект.
 */

interface Command
{
    public function execute();
    public function undo();
}

// Receiver - получатель команды
class TV
{
    private $minVolume = 0;
    private $maxVolume  = 20;
    private $volumeLevel = 0;
    private $power = 'off';

    public function __construct()
    {
        $this->volumeLevel =$this->minVolume;
        $this->power = 'off';
    }

    public function powerOn() {$this->power = 'on'; $this->displayPower();}
    public function powerOff() {$this->power = 'off'; $this->displayPower();}
    public function volumePlus()
    {
        if ($this->volumeLevel < $this->maxVolume && $this->power == 'on') $this->volumeLevel++;
        $this->displayVolume();
    }
    public function volumeMinus() {
        if ($this->volumeLevel > $this->minVolume && $this->power == 'on') $this->volumeLevel--;
        $this->displayVolume();
    }

    public function displayVolume() {echo "Уровень звука " . $this->volumeLevel . '<br />';}
    public function displayPower() {echo "Tv " . $this->power . '<br />';}
}

//ConcreteCommand 1
class TvPowerCommand implements Command
{
    private $receiver;

    public function __construct(TV $receiver) {$this->receiver = $receiver;}
    public function execute() {$this->receiver->powerOn();}
    public function undo() {$this->receiver->powerOff();}
}

//ConcreteCommand 2
class TvVolumeCommand implements Command
{
    private $receiver;

    public function __construct(TV $receiver) {$this->receiver = $receiver;}
    public function execute() {$this->receiver->volumePlus();}
    public function undo() {$this->receiver->volumeMinus();}
}


//Invoker инициатор команды
class Pult
{
    private $commands = array();

    public function setCommand($buttonName, Command $c) {$this->commands[$buttonName] = $c;}

    public function pressPowerOnButton() {$this->commands['power']->execute();}

    public function pressPowerOffButton() {$this->commands['power']->undo();}

    public function pressVolumePlusButton() {$this->commands['volume']->execute();}

    public function pressVolumeMinusButton() {$this->commands['volume']->undo();}
}



/*client code*/

$pult = new Pult(); //invoker
$tv = new TV(); //receiver
$pult->setCommand('power', new TvPowerCommand($tv));
$pult->setCommand('volume', new TvVolumeCommand($tv));
$pult->pressPowerOnButton();
$pult->pressVolumePlusButton();
$pult->pressVolumeMinusButton();
$pult->pressPowerOffButton();