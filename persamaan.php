<?php

class Persamaan {
    public $nilaiX;
    public $nilaiY;
    public $hasil;

    public $koordinatX;
    public $koordinatY;

    public function __construct($nilaiX, $nilaiY, $hasil)
    {
        $this->nilaiX = $nilaiX;
        $this->nilaiY = $nilaiY;
        $this->hasil = $hasil;

        if($nilaiX != 0 || $nilaiY !=0){
            $this->koordinatX = [$this->hasil/$this->nilaiX, 0];
            $this->koordinatY = [0, $this->hasil/$this->nilaiY];
        }
    }
}