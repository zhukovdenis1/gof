<?php

/*
 * ABSTRACT FACTORY
 * Преимуществао: выбор макрки авто в клиентском коде происходит только один раз (вместо множетсва if-else) и при
 *   необходимости сменить марку, правку нужно сделать только в этом месте.
 * Недостаток: Данный паттерн хорошо подходит для добавления новых марок, например Ford
 *   но плохо подходит для добавления новых видов автомобилей, наример универсал,купе
 *   Т.е. если ось изменений проходит через виды авто, а не марки, то вместо этого паттерна лучше использовать FactoryMethod
 * Сигналы к использованию:
 *   - есть дерево однотипных объектов: (toyota, vokswagen, ford...), (pdf,xml,ecxel...), (mac,windows,unix...)
 *   - в коде много одинаковых конструкций if-else
 */

interface Car {
    function drive();
}


class ToyotaSedan implements Car
{
    public function drive() {
        echo 'Driving toyota sedan';
    }
}
class ToyotaHatchback implements Car
{
    public function drive() {
        echo 'Driving toyota hatchback';
    }
}

class VolksWagenSedan /*implements Car*/ {/**/}
class VolksWagenHatchback /*implements Car*/ {/**/}



interface CarFactory
{
    public function createSedan();
    public function createHatchback();
}

    class ToyotaFactory implements CarFactory
    {
        public function createSedan() : Car {
            return new ToyotaSedan();
        }

        public function createHatchback() : Car {
            return new ToyotaHatchback();
        }
    }
    class VolksWagenFactory implements CarFactory
    {
        public function createSedan() {/**/}
        public function createHatchback() {/**/}
    }

/*client code:*/
$factory = new ToyotaFactory();
$car = $factory->createSedan();
$car->drive();