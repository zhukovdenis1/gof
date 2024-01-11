<?php

/**
 * Observer (Наблюдатель) (Listener)
 * Задача: один объект (подписчик) должен знать об изменении состояний или некоторых событий другого объекта.
 * Пример: GUI (например при определенном действии производить disable кнопки)
 * Проблемы в web-е т.к простокол однонаправленный. Но html5 + sockets решают эту проблему
 * Замечание: подписчик и рассыльщик могут исполнять двойные функции и быть подписанными друг на друга.
 * Замечание: этот шаблон усложняет код и не стоит его применять, если мало объектов и их число постоянное.
 */

class News
{
    private $news;
    private $observers;

    public function addObserver(IObserver $observer) {$this->observers[$observer->getId()] = $observer;}

    public function removeObserver(IObserver $observer) {unset($this->observers[$observer->getId()]);}

    public function add(string $news)
    {
        $this->news[] = $news;
        $this->notify($news);
    }

    public function notify(string $news)
    {
        foreach ($this->observers as $o) {
            $o->notification($news);
        }
    }
}

interface IObserver
{
    public function getId();
    public function notification(string $txt);
}

class Observer implements IObserver
{
    private $id;

    public function __construct() {$this->id = uniqid(mt_rand(), true);}

    public function getId() {return $this->id}

    public function notification(string $news)
    {
        echo 'Уведомление о новости: '. $news . '<br />';
    }
}

/*client code*/

$news = new News();
$observer1 = new Observer();
$observer2 = new Observer();
$news->addObserver($observer1);
$news->addObserver($observer2);
$news->add('Новость 1');
$news->add('Новость 2');