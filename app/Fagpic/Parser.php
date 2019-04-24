<?php

namespace App\Fagpic;

abstract class Parser
{
    private $data = array();

    /* 取得データを解析します*/
    abstract public function parse( $object );

    public function setData(array $data)
    {
        array_push( $this->data, $data );
    }

    public function getData()
    {
        return $this->data;
    }
}
