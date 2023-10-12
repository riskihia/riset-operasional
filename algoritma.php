<?php
include_once("persamaan.php");
include_once("batasan.php");

// membuat funcion bantuan
function cari_titik_potong_batasan($nilai_batasan, $nilai_unit, $nilai_unit_yang_dicari, $hasil){
    $hasil_sementara = $hasil; 
    $nilai_sementara_unit = $nilai_unit * $nilai_batasan; //konstanta x dikali dengan variabel x 
    $hasil_sementara -= $nilai_sementara_unit;
    $nilai_sementara_yang_dicari = $hasil_sementara/$nilai_unit_yang_dicari;
    $nilai_sementara_yang_dicari = number_format($nilai_sementara_yang_dicari, 0);

    return $nilai_sementara_yang_dicari;
}

//melakukan eliminasi
function eliminasi($nilai1, $nilai2, $hasil1, $hasil2){
    $tempNilai = $nilai1-$nilai2;
    $tempHasil = $hasil1-$hasil2;
    if($tempNilai == 0){
        echo "elim = ".$tempHasil."<br>";
        return $tempHasil;
    }else{
        echo "elim = ".$tempHasil/$tempNilai."<br>";
        return $tempHasil/$tempNilai;
    }
}

// melakukan subsitusi
function subsitusi($variabel, $nilaiSubsitusi, $nilaiYangDicari ,$hasil){
    $hasilSubsitusi = $variabel * $nilaiSubsitusi;
    $tempHasil = $hasil - $hasilSubsitusi;
    echo "subs = ".$tempHasil/$nilaiYangDicari."<br>";
    return $tempHasil/$nilaiYangDicari;
}

// Menangkap varibel dari form
$nama_unit_1 = $_POST["nama_unit_1"] = "mtk";
$nama_unit_2 = $_POST["nama_unit_2"] = "bhs";
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
$titikArsiran = [
    [0,0]
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


// Menentukan apakah ada titik potong antar garis dengan batasan
// jika titik garis lebih besar dari batasan, maka berpotongan
if(isset($persamaan1)){
    if(isset($batasanX)){
        //garis miring satu dan garis batas x bertitik potong
        if($persamaan1->koordinatX[0] > $batasanX->koordinatX){            
            // hitung titik potong menggunakan function cari titik potong
            $titik_cari = cari_titik_potong_batasan($batasanX->koordinatX, $persamaan1->nilaiX, $persamaan1->nilaiY, $persamaan1->hasil);
            array_push($titikPotong, [$batasanX->koordinatX, $titik_cari]);
        }
    }
    if(isset($batasanY)){
        if($persamaan1->koordinatY > $batasanY->koordinatY){            
            // hitung titik potong menggunakan function cari titik potong
            $titik_cari = cari_titik_potong_batasan($batasanY->koordinatY, $persamaan1->nilaiY, $persamaan1->nilaiX, $persamaan1->hasil);
            array_push($titikPotong, [$titik_cari, $batasanY->koordinatY]);

        }
    }
    array_push($titikX, $persamaan1->koordinatX[0]);
    array_push($titikY, $persamaan1->koordinatY[1]);
}
if(isset($persamaan2)){
    if(isset($batasanX)){
        //garis miring satu dan garis batas x bertitik potong
        if($persamaan2->koordinatX > $batasanX->koordinatX){
            // hitung titik potong menggunakan function cari titik potong
            $titik_cari = cari_titik_potong_batasan($batasanX->koordinatX, $persamaan2->nilaiX, $persamaan2->nilaiY, $persamaan2->hasil);
            array_push($titikPotong, [$batasanX->koordinatX, $titik_cari]);
        }
    }
    if(isset($batasanY)){
        if($persamaan2->koordinatY > $batasanY->koordinatY){
            // hitung titik potong menggunakan function cari titik potong
            $titik_cari = cari_titik_potong_batasan($batasanY->koordinatY, $persamaan2->nilaiY, $persamaan2->nilaiX, $persamaan2->hasil);
            array_push($titikPotong, [$titik_cari, $batasanY->koordinatY]);
        }
    }
    array_push($titikX, $persamaan2->koordinatX[0]);
    array_push($titikY, $persamaan2->koordinatY[1]);
}


// Menentukan apakah ada titik potong antar garis
// jika titik x lebih besar, maka titik y harus lebih kecil supaya bertitik potong
if(isset($persamaan1) && isset($persamaan2)){

    //kasus jika garis satu x lebih besar, dan y lebih kecil dari garis dua
    if($persamaan1->nilaiX > $persamaan2->nilaiX){
        if($persamaan2->nilaiX == 1){
            $selisih = $persamaan1->nilaiX;
        }else{
            $selisih = $persamaan1->nilaiX - $persamaan2->nilaiX;
        }
        
        $persamaan2->nilaiX *= $selisih;
        $persamaan2->nilaiY *= $selisih;
        $persamaan2->hasil *= $selisih;

        // cari nilai y titik potong, dan masukan ke array
        $titikPotongTemp[1] = eliminasi($persamaan1->nilaiY, $persamaan2->nilaiY, $persamaan1->hasil, $persamaan2->hasil);
        $titikPotongTemp[0] = subsitusi($persamaan1->nilaiY, $titikPotongTemp[1], $persamaan1->nilaiX, $persamaan1->hasil);

        array_push($titikPotong, [$titikPotongTemp[0], $titikPotongTemp[1]]); 
    }

    //kasus jika garis dua x lebih besar, dan y lebih kecil dari garis satu
    else if($persamaan2->nilaiX > $persamaan1->nilaiX){
        if($persamaan1->nilaiX == 1){
            $selisih = $persamaan2->nilaiX;
        }else{
            $selisih = $persamaan2->nilaiX - $persamaan1->nilaiX;
        }

        $persamaan1->nilaiX *= $selisih;
        $persamaan1->nilaiY *= $selisih;
        $persamaan1->hasil *= $selisih;

        // cari nilai y titik potong, dan masukan ke array
        $titikPotongTemp[1] = eliminasi($persamaan2->nilaiY, $persamaan1->nilaiY, $persamaan2->hasil, $persamaan1->hasil);;
        $titikPotongTemp[0] = subsitusi($persamaan2->nilaiY, $titikPotongTemp[1], $persamaan2->nilaiX, $persamaan2->hasil);
        
        array_push($titikPotong, [$titikPotongTemp[0], $titikPotongTemp[1]]);
    }

}

if(isset($batasanX)){
    array_push($titikX, $batasanX->koordinatX);
}
if(isset($batasanY)){
    array_push($titikY, $batasanY->koordinatY);
}

// memasukan nilai terendah dari titikX ke dalam array titik potong
array_push($titikPotong, [min($titikX), 0]);
array_push($titikPotong, [0, min($titikY)]);

// memasukan array titik potong ke array arsiran

$titikArsiran = array_merge($titikPotong, $titikArsiran);

// menghitung nilai maksimum dari laba, kali semua array titik arsiran
// dengan nilai laba x dan y
function hitungNilaiMaksimum($titikArsiran, $labaX, $labaY){
    $hasil = 0;
    $hasil_max = 0;
    
    $titik_dan_hasil = [];

    for($x=0; $x < count($titikArsiran); $x++){
        $hasil= $titikArsiran[$x][0] * $labaX + $titikArsiran[$x][1] * $labaY;
        if($hasil >= $hasil_max){
            $hasil_max = $hasil;
            $titik_dan_hasil["titik"] =  $titikArsiran[$x];
            $titik_dan_hasil["hasil"] = $hasil_max;
        }
    }

    return $titik_dan_hasil;
}

$tertinggi = hitungNilaiMaksimum($titikArsiran, $nilai_keuntungan_unit_1, $nilai_keuntungan_unit_2);
$pernyataan1 = "untuk mendapatkan laba maksimum, maka ".$nama_unit_1." harus bernilai ".$tertinggi["titik"][0]."<br>";
$pernyataan2 = "untuk mendapatkan laba maksimum, maka ".$nama_unit_2." harus bernilai ".$tertinggi["titik"][1]."<br>";
$pernyataanhasil = "sehingga diperoleh keuntungan sebesar = Rp ".$tertinggi["hasil"]."<br>";

// Mengarahkan ke halaman "index" dengan membawa data sebagai parameter URL

// header("Location: index.php?nama=riski");
// exit;

$dataToSend = array(
    'pernyataan1' => $pernyataan1,
    'pernyataan2' => $pernyataan2,
    'pernyataanhasil' => $pernyataanhasil,
    'titikArsiran' => $titikArsiran,
    'tertinggi' => $tertinggi
);

// Mengubah data menjadi format JSON
$jsonData = json_encode($dataToSend);

// Redirect ke halaman index dengan membawa data JSON
header("Location: index.php?data=" . urlencode($jsonData));
exit;
?>