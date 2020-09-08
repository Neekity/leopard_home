<?php

abstract class User
{
    abstract public function getAll();
}

interface MySubmit
{
    public function getCode();
}

class Leader extends User implements MySubmit
{
    public function getAll()
    {
        echo 'getallleader';
    }

    public function getCode()
    {
        echo 'getalllcodeleader';
    }
}

class M2 extends Leader{
    public function getCode()
    {
        echo 'getalllcodeM2';
    }
}

$a = new M2();

var_dump($a->getCode());
?>