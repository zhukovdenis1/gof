<?php

/*
 * Template Method
 * Преимущества: нет дублирующегося кода. Весь этот код описывается один раз в родительском классе
 * Последовательность задаётся в родительском классе и в подклассах нет необходимости помнить о ней (например помнить,
 *   что первой операцией должен быть connect, а последней close в случае подключения к бд)
 * Пример: m1: openConnect, m2: do_smth, m3: closeConnect
 * Замечание: что если в class1 5 методов, а в class2 - 3 метода. Ответ: поднять все 5 методов в родительский класс, а
 *   в class2 реализацию ненужных методов оставить пустой. Либо построить иерархию классов со своими templateMethod
*/

abstract class AClass
{
    public function method1() {echo 'method 1<br />';}
    abstract public function method2();
    public function method3() {echo 'method 3<br />';}

    public function templateMethod()
    {
        $this->method1();
        $this->method2();
        $this->method3();
    }
}

class Class1 extends AClass
{
    public function method2() {echo 'mothod 2 from Class1<br />';}
}

class Class2 extends AClass
{
    public function method2() {echo 'mothod 2 from Class2<br />';}
}

/* client code */

$c1 = new Class1();
$c2 = new Class2();

$c1->templateMethod();
echo '---<br />';
$c2->templateMethod();



