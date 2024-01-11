<?php

/**
 * SINGLETON
 * Минусы:
 *  - В многопоточном режиме может создаваться несколько инстансов. Проблема решается в зависимости от языка
 *  - От приватного конструктора нельзя унаследоваться, но лекго создать родителя синглтона и унаследоваться от него
 * Плюсы:
 *  - не используются глобальные переменные
 *  - инициализация только тогда, когда нужно
 * Замечение: паттерн ограничивает количество экземпляров, не обязятельно одним
 * Область примененя: считается антипаттерном т.к часто применяется там где не нужно. Хорошо подходит для классов, 
 *   работающих с файлом. Например логгер. (т.к. одновременно запись файл должен иметь только один процесс)
 * Другие примеры: кеш, аутентификация, проксирование
 */

class Singleton
{
    private static $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new Singleton();
        }

        return static::$instance;
    }

    public function doSomething()
    {
        echo 'do smth...';
    }
}

//$singleton = new Singleton(); //Fatal error

$singleton = Singleton::getInstance();

$singleton->doSomething();