<?php
class my_class
{
    public $arr = array();
}

$a = new my_class;
$b = clone $a;

$b->arr[] = 1;

var_dump($a === $b);
?>