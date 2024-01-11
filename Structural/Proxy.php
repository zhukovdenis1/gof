<?php

/**
 * PROXY
 * Проблема: Необходимо управлять доступом к объекту так, чтобы создавать громоздкие объекты "по требованию"
 * По сути та же схема, что и в Адаптере, но применительно к другой задаче.
 */

interface SomeInterface
{
    public function get();
}

class RealClass implements SomeInterface
{
    public function get()
    {
        return 'some data';
    }
}

/*client code*/
$obj = new RealClass();
echo $obj->get();

/*теперь требуется добавить кеширование, не изменив при этом RealClass и с минимальными правками клиентского кода*/
echo '<br />--------------<br />';

class CacheClass implements SomeInterface
{
    private $realObj;
    private static $cacheData = null; //some storage f.e. redis

    public function __construct(SomeInterface $realObject)
    {
        $this->realObj = $realObject;
    }

    public function get() : string
    {
        $data = '';

        if (is_null(static::$cacheData)) {//if isset data in cache
            $data = $this->realObj->get();
            static::$cacheData = $data . ' (cached)';//push data to cache
        } else {
            $data = static::$cacheData;
        }
        return $data;
    }
}

/*new client code*/
$obj = new CacheClass(new RealClass());
echo $obj->get();
echo '<br />';
echo $obj->get();
