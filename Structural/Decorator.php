<?php

/**
 * DECORATOR
 * Задача: нужно добавлять обязанности к классу динамически
 * Признак использования: в клиентском коде требуется множество комбинаций
 *
 * Преимущества:
 *   - Позволяет измежать огромного количества классов с разными комбинациями свойств
 *   - возможность добавлять/удалять обязаности во время выполнения программы
 *   - код сложно испортить, он легко читается
 *
 * Недостатки:
 *  - Сложность проектирования
 *
 * Замечание: каждый декоратор может добавить дополнительные методы к своему объекту. Чтобы вызвать этот метод, нужно
 *   конкретный декоратор сохранить в переменной.
 */

interface Coffee
{
    public function get();
}

class SimpleCoffee implements Coffee
{
    public function get()
    {
        return 'coffee';
    }
}

class MilkDecorator implements Coffee
{
    private $coffee;

    public function __construct(Coffee $coffee)
    {
        $this->coffee = $coffee;
    }

    public function get()
    {
        return $this->coffee->get() . ' with milk';
    }
}

class SugarDecorator implements Coffee
{
    private $coffee;

    public function __construct(Coffee $coffee)
    {
        $this->coffee = $coffee;
    }

    public function get()
    {
        return $this->coffee->get() . ' with sugar';
    }
}

/*client code*/
$coffee = new SugarDecorator(new MilkDecorator(new SimpleCoffee()));
echo $coffee->get();