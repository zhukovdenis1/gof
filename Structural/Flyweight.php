<?php

/**
 * Flyweight
 * Проблема: слишком много одинаковых объектов
 * Решение: не дублировать объекты с одинковыми свойствами. Создавать только один объект с данным набором свойств.
 */

interface Developer
{
    public function writeCode();
}

class JavaDeveloper implements Developer
{
    public function writeCode() { echo 'write java code<br />';}
}

class PHPDeveloper implements Developer
{
    public function writeCode() { echo 'write php code<br />';}
}

class DeveloperFactory
{
    private $developers = [];

    public function getDeveloper(string $type) : Developer
    {
        if (!isset($this->developers[$type])) {
            switch ($type) {
                case 'java':
                    $this->developers[$type] = new JavaDeveloper();
                    break;
                case 'php':
                    $this->developers[$type] = new PHPDeveloper();
                    break;
            }
        }

        return $this->developers[$type];
    }
}

/*client code*/
$factory = new DeveloperFactory();

$factory->getDeveloper('java')->writeCode();
$factory->getDeveloper('java')->writeCode();
$factory->getDeveloper('php')->writeCode();
$factory->getDeveloper('php')->writeCode();
$factory->getDeveloper('php')->writeCode();