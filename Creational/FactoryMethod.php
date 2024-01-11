<?php

/*
 * FACTORY METHOD
 *
 * Преимущества:
 *  - в клиентском коде нет конструкций if-else, все они в Factory
 *   (что тоже является недостатком, но это лучше чем если эти конструкции будут в клиентском коде)
 *  - подходит, если ось изменений проходит через модели (добавляются/изменяются модели, например добавится hatchback)
 * Недостатки:
 *  - не подходит, если ось изменения проходит через макри авто (например добавится ford)
 *  - нарушен принцип GRASP Low coupling т.к. carFactory имеет зависимость от множества классов
 * Замечание: Метод createSedan класса CarFactory можно сделать static
 *    В примере он не static для более наглядного сравнения с AbstractFactory
 *
 * Де-факто это способ инстанциацирования полиморфных классов
 *
 */

class CarFactory
{
    public function createSedan(string $type) : Car
    {
        switch ($type) {
            case 'toyota':
                return new Toyota();
            case 'volkswagen':
                return new VolksWagen();
        }
        throw new Exception('Unknown car type');
    }
}

interface Car
{
    public function drive();
}

class Toyota implements Car
{
    public function drive() {
        echo 'Driving toyota...';
    }
}
class VolksWagen implements Car
{
    public function drive() {
        echo 'Driving volkswagen...';
    }
}

/*client code:*/
$factory = new CarFactory();
$car = $factory->createSedan('toyota');
$car->drive();


/*
 * Можно упростить до вида

abstract class Car
{
    abstract public function drive() {}
    public static function create($type) : Car { switch-case ...}
}

class Toyota extends Car
{
    public function drive() {
        echo 'Driving toyota...';
    }
}

$car = Car::create('toyota');
$car->drive();
*/