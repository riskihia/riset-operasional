<?php

namespace App\Algoritma;

class Persamaan {
    function cariNilaiX($paramX, $paramY, $paramHasil){
        return $paramHasil/$paramX;
    }
    function cariNilaiY($paramX, $paramY, $paramHasil){
        return $paramHasil/$paramY;
    }
    public $nilaiX = 0;
    public $nilaiY = 0;
    public $hasil = 0;

    public function __construct($nilaiX, $nilaiY, $hasil)
    {
        $this->nilaiX = $nilaiX;
        $this->nilaiY = $nilaiY;
        $this->hasil = $hasil;

    }
    function cetakNilaiX(){
        return $this->cariNilaiX($this->nilaiX, $this->nilaiY, $this->hasil);
    }
    function cetakNilaiY(){
        return $this->cariNilaiY($this->nilaiX, $this->nilaiY, $this->hasil);
    }
}