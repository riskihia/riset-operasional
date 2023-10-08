<?php

class Batasan {
    public $koordinatX = 0;
    public $koordinatY = 0;

    public function __construct($nilaiX = 0, $nilaiY = 0)
    {
        if($nilaiX != 0){
            $this->koordinatX = $nilaiX;
        }
        if($nilaiY != 0){
            $this->koordinatY = $nilaiY;
        }
    }
}