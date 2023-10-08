<?php
// membuat funcion bantuan
function cari_titik_potong($nilai_batasan, $nilai_unit, $nilai_unit_yang_dicari, $hasil){
    // hitung titik potong
    // subsitusi nilai batas x ke persamaan 1, untuk mendapatkan nilai y
    // titik potong = nilai batas x , nilai perhitungan y

    // echo $nilai_batasan."<br>"; // nilai batasan x atau batasan y ex : nilai_batasan_unit_1
    // echo $nilai_unit."<br>"; // nilai x,y
    // echo $nilai_unit_yang_dicari."<br>"; // nilai x,y
    // echo $hasil."<br>"; // batasan atau hasil persamaan ex: nilai_batasan_1

    $hasil_sementara = $hasil; 
    $nilai_sementara_unit = $nilai_unit * $nilai_batasan; //konstanta x dikali dengan variabel x 
    $hasil_sementara -= $nilai_sementara_unit;
    $nilai_sementara_yang_dicari = $hasil_sementara/$nilai_unit_yang_dicari;
    $nilai_sementara_yang_dicari = number_format($nilai_sementara_yang_dicari, 1);

    return $nilai_sementara_yang_dicari;
}


// Menangkap varibel dari form
$nama_unit_1 = $_POST["nama_unit_1"] = "mtk";
$nama_unit_2 = $_POST["nama_unit_2"] = "bahasa";
$nilai_batasan_1 = $_POST["nilai_batasan_1"] = 240;
$nilai_batasan_2 = $_POST["nilai_batasan_2"] = 100;
$nilai_unit_1_untuk_batasan_1 = $_POST["nilai_unit_1_untuk_batasan_1"] = 4;
$nilai_unit_2_untuk_batasan_1 = $_POST["nilai_unit_2_untuk_batasan_1"] = 3;
$nilai_unit_1_untuk_batasan_2 = $_POST["nilai_unit_1_untuk_batasan_2"] = 2;
$nilai_unit_2_untuk_batasan_2 = $_POST["nilai_unit_2_untuk_batasan_2"] = 1;
$nilai_batasan_unit_1 = $_POST["nilai_batasan_unit_1"] = 40;
$nilai_batasan_unit_2 = $_POST["nilai_batasan_unit_2"] = 50;
$nilai_keuntungan_unit_1 = $_POST["nilai_keuntungan_unit_1"] = 1000;
$nilai_keuntungan_unit_2 = $_POST["nilai_keuntungan_unit_2"] = 800;

// Menentukan garis : garis miring dari persamaan ataupun dari batasan
$garis = [];
$titik = [
    "a" => [0,0]
];
$titikX = [];
$titikY = [];
$titikPotong = [];

// Garis persamaan 
if($nilai_batasan_1 != 0 && $nilai_batasan_2 != 0){
    // ada persamaan 1
    if($nilai_unit_1_untuk_batasan_1 != 0 && $nilai_unit_2_untuk_batasan_1 != 0){
        $garis["garis_miring_satu"] = [($nilai_batasan_1/$nilai_unit_1_untuk_batasan_1), ($nilai_batasan_1/$nilai_unit_2_untuk_batasan_1)];
        //garis 1 = hasil / x dan hasil /y

        // memasukan nilai x persamaan 2 ke array titikX
        array_push($titikX, $garis["garis_miring_satu"][0]);
        // memasukan nilai y persamaan 2 ke array titikY
        array_push($titikY, $garis["garis_miring_satu"][1]);
    }
    // ada persamaan 2
    if($nilai_unit_1_untuk_batasan_2 != 0 && $nilai_unit_2_untuk_batasan_2 != 0){
        $garis["garis_miring_dua"] = [($nilai_batasan_2/$nilai_unit_1_untuk_batasan_2), ($nilai_batasan_2/$nilai_unit_2_untuk_batasan_2)];
        //garis 2 = hasil / x dan hasil /y

        // memasukan nilai x persamaan 2 ke array titikX
        array_push($titikX, $garis["garis_miring_dua"][0]);
        // memasukan nilai y persamaan 2 ke array titikY
        array_push($titikY, $garis["garis_miring_dua"][1]);
    }
}

//Garis batasan
if ($nilai_batasan_unit_1 != 0) {
    // garis batas x tegak lurus, jari y 0
    $garis["garis_batas_x"] = [$nilai_batasan_unit_1, 0];


    // memasukan nilai x batasan ke array titikX
    array_push($titikX, $garis["garis_batas_x"][0]);
} 
if ($nilai_batasan_unit_2 != 0) {
    // garis batas y tegak lurus, jari x 0
    $garis["garis_batas_y"] = [0, $nilai_batasan_unit_2];


    // memasukan nilai y batasan ke array titikY
    array_push($titikY, $garis["garis_batas_y"][1]);
}


// Menentukan apakah ada titik potong antar garis
// jika titik x lebih besar, maka titik y harus lebih kecil supaya bertitik potong
if(isset($garis["garis_miring_satu"]) && isset($garis["garis_miring_dua"])){

    //kasus jika garis satu x lebih besar, dan y lebih kecil dari garis dua
    if($garis["garis_miring_satu"][0] > $garis["garis_miring_dua"][0]){
        if($garis["garis_miring_satu"][1] < $garis["garis_miring_dua"][1]){
            echo "ya, berititik potong"."<br>";
        }else{
            echo "tidak, bertitik potong"."<br>";
        }
    }

    //kasus jika garis dua x lebih besar, dan y lebih kecil dari garis satu
    else if($garis["garis_miring_dua"][0] > $garis["garis_miring_satu"][0]){
        if($garis["garis_miring_dua"][1] < $garis["garis_miring_satu"][1]){
            echo "ya, berititik potong";
        }else{
            echo "tidak, bertitik potong"."<br>";
        }

    }
}

// Menentukan apakah ada titik potong antar garis dengan batasan
// jika titik garis lebih besar dari batasan, maka berpotongan
if(isset($garis["garis_miring_satu"])){
    if(isset($garis["garis_batas_x"])){
        //garis miring satu dan garis batas x bertitik potong
        if($garis["garis_miring_satu"][0] > $garis["garis_batas_x"][0]){
            echo "garis miring 1 bertitik potong dengan x"."<br>";
            
            // hitung titik potong menggunakan function cari titik potong
            $titik_cari = cari_titik_potong($garis["garis_batas_x"][0], $nilai_unit_1_untuk_batasan_1, $nilai_unit_2_untuk_batasan_1, $nilai_batasan_1);
            $titik_potong = [$garis["garis_batas_x"][0], $titik_cari];
            array_push($titikPotong, $titik_potong);
        }
    }
    if(isset($garis["garis_batas_y"])){
        if($garis["garis_miring_satu"][1] > $garis["garis_batas_y"][1]){
            echo "garis miring 1 bertitik potong dengan y"."<br>";
            
            // hitung titik potong menggunakan function cari titik potong
            $titik_cari = cari_titik_potong($garis["garis_batas_y"][1], $nilai_unit_2_untuk_batasan_1, $nilai_unit_1_untuk_batasan_1, $nilai_batasan_1);
            $titik_potong = [$titik_cari, $garis["garis_batas_y"][1]];
            array_push($titikPotong, $titik_potong);
        }
    }
}
if(isset($garis["garis_miring_dua"])){
    if(isset($garis["garis_batas_x"])){
        //garis miring satu dan garis batas x bertitik potong
        if($garis["garis_miring_dua"][0] > $garis["garis_batas_x"][0]){
            echo "garis miring 2 bertitik potong dengan x"."<br>";
        }
    }
    if(isset($garis["garis_batas_y"])){
        if($garis["garis_miring_dua"][1] > $garis["garis_batas_y"][1]){
            echo "garis miring 2 bertitik potong dengan y"."<br>";
        }
    }
}

// Menentukan apakah ada titik potong antara garis dengan batasan
echo "<pre>";
print_r($_POST);
print_r($garis);
print_r($titik);
print_r($titikX);
print_r($titikY);
print_r($titikPotong);
echo "</pre>";


