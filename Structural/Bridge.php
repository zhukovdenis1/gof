<?php

/**
 * BRIDGE
 * Проблема: нужно отделить абстракцию(пр: отчет) от реализации(пр: пдф), чтобы они могли независимо модифицироваться
 * (Наследование не подходит т.к. абстракция привязывается к реализации. Если кол-во абстракций и реализаций не меняется и их мало, то проще сделать наследование)
 * Используется когда 2 оси изменения (может добавиться вид отчета (годовой) или фортат вывода (xml))
 * Проблема в том что нужно следить, чтобы общение с Format шло только через Report, а не внутри DailyReport и чтобы в
 *  Report c реализациями была зависимость только через интерфейс Format (а не напрямую с pdf, word);
 * Код легко пишется, но может быть легко испорчен
 * Замечание: в паттерне Декоратор обратная ситуация: код сложно пишется, но его сложно испортить
 *
 * Преимущества:
 *  Реализацию и абстракцию можно конфигурировать во время выполнения
 */

/*Абстракция*/
abstract class Report
{
    private $formatter;//bridge

    public abstract function print();

    public function __construct(Format $formatter) {$this->formatter = $formatter;}

    protected function format($content)
    {
        //Должны вызываться только методы интерфейса Format
        return $this->formatter->generate($content);
    }
}

/**
 * В этих дочерних классах не должны вызываться методы $formatter. (не должно быть зависимости от Format)
 * $formatter должен остатья недоступным в этом классе
 * Все обращения к $formater должны идти через абстрактные методы Report
 */
class DailyReport extends Report
{
    /* если понадобится конструктор
    public function __construct(Format $formatter)
    {
        parent::__construct($formatter);
    }*/

    public function print()
    {
        echo $this->format('daily report');
    }
}

//class MonthlyReport() ...


/*Реализация*/
interface Format
{
    public function generate($content);
}

class PDF implements Format
{
    public function generate($content)
    {
        return $content . ' in PDF format';
    }
}

//class Word, Xml, ....

/*client code*/
$format = new PDF();
$report = new DailyReport($format);
$report->print();

