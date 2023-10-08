<?php
include_once("persamaan.php");
include_once("batasan.php");

// membuat funcion bantuan
function cari_titik_potong_batasan($nilai_batasan, $nilai_unit, $nilai_unit_yang_dicari, $hasil){
    echo $nilai_batasan."<br>"; // nilai batasan x atau batasan y ex : nilai_batasan_unit_1
    echo $nilai_unit."<br>"; // nilai x,y
    echo $nilai_unit_yang_dicari."<br>"; // nilai x,y
    echo $hasil."<br>"; // batasan atau hasil persamaan ex: persamaan->hasil

    $hasil_sementara = $hasil; 
    $nilai_sementara_unit = $nilai_unit * $nilai_batasan; //konstanta x dikali dengan variabel x 
    $hasil_sementara -= $nilai_sementara_unit;
    $nilai_sementara_yang_dicari = $hasil_sementara/$nilai_unit_yang_dicari;
    $nilai_sementara_yang_dicari = number_format($nilai_sementara_yang_dicari, 1);

    return $nilai_sementara_yang_dicari;
}

//melakukan eliminasi
function eliminasi($nilai1, $nilai2, $hasil1, $hasil2){
    // echo $nilai1."<br>";
    // echo $nilai2."<br>";
    // echo $hasil1."<br>";
    // echo $hasil2."<br>";
    $tempNilai = $nilai1-$nilai2;
    $tempHasil = $hasil1-$hasil2;
    if($tempNilai == 0){
        return $tempHasil;
    }else{
        return $tempHasil/$tempNilai;
    }
}

// melakukan subsitusi
function subsitusi($variabel, $nilaiSubsitusi, $nilaiYangDicari ,$hasil){
    $hasilSubsitusi = $variabel * $nilaiSubsitusi;
    $tempHasil = $hasil - $hasilSubsitusi;
    return $tempHasil/$nilaiYangDicari;
}

// Menangkap varibel dari form
$nama_unit_1 = $_POST["nama_unit_1"] = "mtk";
$nama_unit_2 = $_POST["nama_unit_2"] = "bahasa";
// $nilai_batasan_1 = $_POST["nilai_batasan_1"] = 240;
// $nilai_batasan_2 = $_POST["nilai_batasan_2"] = 100;
$nilai_batasan_1 = $_POST["nilai_batasan_1"] = 3;
$nilai_batasan_2 = $_POST["nilai_batasan_2"] = 5;
$nilai_unit_1_untuk_batasan_1 = $_POST["nilai_unit_1_untuk_batasan_1"] = 0;
$nilai_unit_2_untuk_batasan_1 = $_POST["nilai_unit_2_untuk_batasan_1"] = 0;
$nilai_unit_1_untuk_batasan_2 = $_POST["nilai_unit_1_untuk_batasan_2"] = 1;
$nilai_unit_2_untuk_batasan_2 = $_POST["nilai_unit_2_untuk_batasan_2"] = 1;
$nilai_batasan_unit_1 = $_POST["nilai_batasan_unit_1"] = 3;
$nilai_batasan_unit_2 = $_POST["nilai_batasan_unit_2"] = 3;
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
$titikPotongTemp = [];

// Garis persamaan 
if($nilai_batasan_1 != 0 && $nilai_unit_1_untuk_batasan_1 != 0 && $nilai_unit_2_untuk_batasan_1 != 0){
    // ada persamaan 1
    $persamaan1 = new Persamaan($nilai_unit_1_untuk_batasan_1, $nilai_unit_2_untuk_batasan_1, $nilai_batasan_1);
}
if($nilai_batasan_2 != 0 && $nilai_unit_1_untuk_batasan_2 !=0 && $nilai_unit_2_untuk_batasan_2 != 0 ){
    // ada persamaan 2
    $persamaan2 = new Persamaan($nilai_unit_1_untuk_batasan_2, $nilai_unit_2_untuk_batasan_2, $nilai_batasan_2);
}

//Garis batasan
if ($nilai_batasan_unit_1 != 0) {
    //membuat class batasan
    $batasanX = new Batasan($nilai_batasan_unit_1, 0);
} 
if ($nilai_batasan_unit_2 != 0) {
    $batasanY = new Batasan(0, $nilai_batasan_unit_2);
}


// Menentukan apakah ada titik potong antar garis
// jika titik x lebih besar, maka titik y harus lebih kecil supaya bertitik potong
if(isset($persamaan1) && isset($persamaan2)){

    //kasus jika garis satu x lebih besar, dan y lebih kecil dari garis dua
    if($persamaan1->koordinatX[0] > $persamaan2->koordinatX[0]){
        if($persamaan1->koordinatY[1] < $persamaan2->koordinatY[1]){
            echo "ya, berititik potong"."<br>";

            $selisih = $persamaan1->nilaiX - $persamaan2->nilaiX;
            $selisih == 1 ? $selisih+1 : $selisih; //jika selisih 1 maka, tambahkan nilainya dengan 1
            
            $persamaan2->nilaiX *= $selisih;
            $persamaan2->nilaiY *= $selisih;
            $persamaan2->hasil *= $selisih;

            // cari nilai y titik potong, dan masukan ke array
            $titikPotongTemp[1] = eliminasi($persamaan1->nilaiY, $persamaan2->nilaiY, $persamaan1->hasil, $persamaan2->hasil);
            $titikPotongTemp[0] = subsitusi($persamaan1->nilaiY, $titikPotongTemp[1], $persamaan1->nilaiX, $persamaan1->hasil);

            array_push($titikPotong, [$titikPotongTemp[0], $titikPotongTemp[1]]); 
        }else{
            echo "tidak, bertitik potong"."<br>";
        }
    }

    //kasus jika garis dua x lebih besar, dan y lebih kecil dari garis satu
    else if($persamaan2->koordinatX[0] > $persamaan1->koordinatX[0]){
        if($persamaan2->koordinatY[1] < $persamaan1->koordinatY[1]){
            echo "ya, berititik potong";
            
            $selisih = $persamaan2->nilaiX - $persamaan1->nilaiX;
            $selisih == 1 ? $selisih+1 : $selisih; //jika selisih 1 maka, tambahkan nilainya dengan 1

            $persamaan1->nilaiX *= $selisih;
            $persamaan1->nilaiY *= $selisih;
            $persamaan1->hasil *= $selisih;

            // cari nilai y titik potong, dan masukan ke array
            $titikPotongTemp[1] = eliminasi($persamaan2->nilaiY, $persamaan1->nilaiY, $persamaan2->hasil, $persamaan1->hasil);;
            $titikPotongTemp[0] = subsitusi($persamaan2->nilaiY, $titikPotongTemp[1], $persamaan2->nilaiX, $persamaan2->hasil);
            
            array_push($titikPotong, [$titikPotongTemp[0], $titikPotongTemp[1]]);
        }else{
            echo "tidak, bertitik potong"."<br>";
        }

    }
}

// Menentukan apakah ada titik potong antar garis dengan batasan
// jika titik garis lebih besar dari batasan, maka berpotongan
if(isset($persamaan1)){
    if(isset($batasanX)){
        //garis miring satu dan garis batas x bertitik potong
        if($persamaan1->koordinatX[0] > $batasanX->koordinatX){
            echo "garis miring 1 bertitik potong dengan x"."<br>";
            
            // hitung titik potong menggunakan function cari titik potong
            $titik_cari = cari_titik_potong_batasan($batasanX->koordinatX, $persamaan1->nilaiX, $persamaan1->nilaiY, $persamaan1->hasil);
            array_push($titikPotong, [$batasanX->koordinatX, $titik_cari]);
        }
    }
    if(isset($batasanY)){
        if($persamaan1->koordinatY > $batasanY->koordinatY){
            echo "garis miring 1 bertitik potong dengan y"."<br>";
            
            // hitung titik potong menggunakan function cari titik potong
            $titik_cari = cari_titik_potong_batasan($batasanY->koordinatY, $persamaan1->nilaiY, $persamaan1->nilaiX, $persamaan1->hasil);
            array_push($titikPotong, [$titik_cari, $batasanY->koordinatY]);

        }
    }
}
if(isset($persamaan2)){
    if(isset($batasanX)){
        //garis miring satu dan garis batas x bertitik potong
        if($persamaan2->koordinatX > $batasanX->koordinatX){
            echo "garis miring 2 bertitik potong dengan x"."<br>";

            // hitung titik potong menggunakan function cari titik potong
            $titik_cari = cari_titik_potong_batasan($batasanX->koordinatX, $persamaan2->nilaiX, $persamaan2->nilaiY, $persamaan2->hasil);
            array_push($titikPotong, [$batasanX->koordinatX, $titik_cari]);
        }
    }
    if(isset($batasanY)){
        if($persamaan2->koordinatY > $batasanY->koordinatY){
            echo "garis miring 2 bertitik potong dengan y"."<br>";

            // hitung titik potong menggunakan function cari titik potong
            $titik_cari = cari_titik_potong_batasan($batasanY->koordinatY, $persamaan2->nilaiY, $persamaan2->nilaiX, $persamaan2->hasil);
            array_push($titikPotong, [$titik_cari, $batasanY->koordinatY]);

        }
    }
}

// Menentukan apakah ada titik potong antara garis dengan batasan
echo "<pre>";
print_r($_POST);
print_r($persamaan1);
print_r($persamaan2);
print_r($batasanX);
print_r($batasanY);
print_r($titikPotong);
// print_r($garis);
// print_r($titik);
// print_r($titikX);
// print_r($titikY);
// print_r($titikPotong);
echo "</pre>";


