<?php

$persamaan1 = $request->input('persamaan1');
        $persamaan2 = $request->input('persamaan2');
        $fungsiTujuan = $request->input('fungsiTujuan');


        $patterns = [
            '/^(\d+)x/',
            '/(\d+)y/',
        ];
        $arrayFungsiTujuan = [];
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $fungsiTujuan, $matches)) {
                $arrayFungsiTujuan[] = $matches[1];
            } else {
                echo "Fungsi Tujuan tidak valid.";
            }
        }
        $patterns = [
            '/^(\d+)x/',
            '/(\d+)y/',
            '/(\d+)$/',
        ];

        $resultArray = []; // Array untuk menyimpan nilai x, y, dan hasil

        foreach ([$persamaan1, $persamaan2] as $persamaan) {
            $matchesArray = []; // Array sementara untuk setiap persamaan

            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $persamaan, $matches)) {
                    $matchesArray[] = $matches[1]; 
                } else {
                    echo "Persamaan Tidak valid.";
                }
                
            }
            if (count($matchesArray) === 3) {
                $resultArray[] = $matchesArray;
            }
        }


        // Mulai
        function cariNilaiX($paramX, $paramY, $paramHasil){
            return $paramHasil/$paramX;
        }
        function cariNilaiY($paramX, $paramY, $paramHasil){
            return $paramHasil/$paramY;
        }
        function cetakPersamaan($persamaan, $nilaiX, $nilaiY, $hasil){
            return $nilaiX."x + ".$nilaiY."y = ".$hasil;
        }

        function eliminasi($nilai1, $nilai2, $hasil1, $hasil2){
            // echo $nilai1;
            // echo $nilai2;
            // echo $hasil1;
            // echo $hasil2;
            // dd("s");
            $tempNilai = $nilai1-$nilai2;
            $tempHasil = $hasil1-$hasil2;
            if($tempNilai == 0){
                return $tempHasil;
            }else{
                return $tempHasil/$tempNilai;
            }
        }
        function subsitusi($variabel, $nilaiSubsitusi, $nilaiYangDicari ,$hasil){
            $hasilSubsitusi = $variabel * $nilaiSubsitusi;
            $tempHasil = $hasil - $hasilSubsitusi;
            return $tempHasil/$nilaiYangDicari;
        }

        function panjangArray(array $nilai){
            $panjang = 0;

            foreach ($nilai as $element) {
                $panjang++;
            }
            return $panjang;
        }

        function cariNilaiMinimum(array $nilai){
            $min = $nilai[0];
            for($x = 0; $x < panjangArray($nilai); $x++ ){
                if($min > $nilai[$x]){
                    $min = $nilai[$x];
                }
            }
            return $min;
        }

        $titikX = [];
        $titikY = [];
        $titikPotong = [];
        $hasilMaksimum = 0;
        $FUNGSITUJUANX = $arrayFungsiTujuan[0];
        $FUNGSITUJUANY = $arrayFungsiTujuan[1];

        // $persamaan1 = ($resultArray[0][0],$resultArray[0][1],$resultArray[0][2]);
        // $persamaan2 = ($resultArray[1][0],$resultArray[1][1],$resultArray[1][2]);


        $titikX[0] = $persamaan1->cetakNilaiX();
        $titikX[1] = $persamaan2->cetakNilaiX();
        $titikY[0] = $persamaan1->cetakNilaiY();
        $titikY[1] = $persamaan2->cetakNilaiY();


        if($persamaan1->nilaiX > $persamaan2->nilaiX){
            $selisih = ($persamaan1->nilaiX - $persamaan2->nilaiX)+1;
            // dd($selisih+1);
            $persamaan2->nilaiX *= $selisih;
            $persamaan2->nilaiY *= $selisih;
            $persamaan2->hasil *= $selisih;

            // cari nilai y titik potong, dan masukan ke array
            $titikPotong[1] = eliminasi($persamaan1->nilaiY, $persamaan2->nilaiY, $persamaan1->hasil, $persamaan2->hasil);
            $titikPotong[0] = subsitusi($persamaan1->nilaiY, $titikPotong[1], $persamaan1->nilaiX, $persamaan1->hasil);

        }else if($persamaan2->nilaiX > $persamaan1->nilaiX){
            $selisih = ($persamaan2->nilaiX - $persamaan1->nilaiX)+1;
            $persamaan1->nilaiX *= $selisih;
            $persamaan1->nilaiY *= $selisih;
            $persamaan1->hasil *= $selisih;

            // cari nilai y titik potong, dan masukan ke array
            $titikPotong[1] = eliminasi($persamaan2->nilaiY, $persamaan1->nilaiY, $persamaan2->hasil, $persamaan1->hasil);;
            $titikPotong[0] = subsitusi($persamaan2->nilaiY, $titikPotong[1], $persamaan2->nilaiX, $persamaan2->hasil);

        }else{
            $titikPotong[1] = eliminasi($persamaan2->nilaiY, $persamaan1->nilaiY, $persamaan2->hasil, $persamaan1->hasil);;
            $titikPotong[0] = subsitusi($persamaan2->nilaiY, $titikPotong[1], $persamaan2->nilaiX, $persamaan2->hasil);
        }

        // uji Titik
        function ujiTitik(array $titikUji, $FUNGSITUJUANX, $FUNGSITUJUANY){
            return ($titikUji[0] * $FUNGSITUJUANX) + ($titikUji[1] * $FUNGSITUJUANY); 
        }

        // Titik ujia a adalah titik origin 0,0
        $titikUjiA = [0,0];
        $hasilTitikUjiA = ujiTitik($titikUjiA, $FUNGSITUJUANX, $FUNGSITUJUANY);

        // titik uji b adalah titik nilai x terkecil
        $titikUjiB = [cariNilaiMinimum($titikX), 0];
        $hasilTitikUjiB = ujiTitik($titikUjiB, $FUNGSITUJUANX, $FUNGSITUJUANY);

        // titik uji c adalah nilai titik potong
        $titikUjiC = [$titikPotong[0], $titikPotong[1]];
        $hasilTitikUjiC = ujiTitik($titikUjiC, $FUNGSITUJUANX, $FUNGSITUJUANY);

        // titik uji d adalah titik nilai y terkecil
        $titikUjiD = [0,cariNilaiMinimum($titikY)];
        $hasilTitikUjiD = ujiTitik($titikUjiD, $FUNGSITUJUANX, $FUNGSITUJUANY);

        $semuaTitikUji = [$titikUjiA,$titikUjiB,$titikUjiC,$titikUjiD];

        function cariHasilMaksimum($nilai1, $nilai2, $nilai3, $nilai4){
            $arrNilai = [$nilai1, $nilai2, $nilai3, $nilai4];
            $max = $arrNilai[0];
            foreach($arrNilai as $nilai){
                if($max < $nilai){
                    $max = $nilai;
                }
            }
            return $max;
        }

        function cariTitikMaksimum($hasilMaks, $nilai1, $nilai2, $nilai3, $nilai4, $semuaTitikUji){
            $titikUjiA = $semuaTitikUji[0];
            $titikUjiB = $semuaTitikUji[1];
            $titikUjiC = $semuaTitikUji[2];
            $titikUjiD = $semuaTitikUji[3];
            $titikMaksimum = [];

            if($hasilMaks == $nilai1){
                $titikMaksimum = $titikUjiA;
            }
            if($hasilMaks == $nilai2){
                $titikMaksimum = $titikUjiB;
            }
            if($hasilMaks == $nilai3){
                $titikMaksimum = $titikUjiC;
            }
            if($hasilMaks == $nilai4){
                $titikMaksimum = $titikUjiD;
            }
            
            return $titikMaksimum;
        }

        $hasilMaksimum = cariHasilMaksimum($hasilTitikUjiA, $hasilTitikUjiB,$hasilTitikUjiC,$hasilTitikUjiD);
        $titikMaksimum = cariTitikMaksimum($hasilMaksimum, $hasilTitikUjiA, $hasilTitikUjiB,$hasilTitikUjiC,$hasilTitikUjiD,$semuaTitikUji);

        $data = [
            "persamaan1" => cetakPersamaan(1, $persamaan1->nilaiX, $persamaan1->nilaiY, $persamaan1->hasil),
            "persamaan2" => cetakPersamaan(2, $persamaan2->nilaiX, $persamaan2->nilaiY, $persamaan2->hasil),
            "x1" => $persamaan1->cetakNilaiX(),
            "x2" => $persamaan1->cetakNilaiY(),
            "y1" => $persamaan2->cetakNilaiX(),
            "y2" => $persamaan2->cetakNilaiY(),
            "titikPotongX" => $titikPotong[0],
            "titikPotongY" => $titikPotong[1],
            "titikUjiA" => $titikUjiA,
            "titikUjiB" => $titikUjiB,
            "titikUjiC" => $titikUjiC,
            "titikUjiD" => $titikUjiD,
            "hasilTitikUjiA" => $hasilTitikUjiA,
            "hasilTitikUjiB" => $hasilTitikUjiB,
            "hasilTitikUjiC" => $hasilTitikUjiC,
            "hasilTitikUjiD" => $hasilTitikUjiD,
            "hasilTertinggi" => $hasilMaksimum,
            "titikTertinggi" => [$titikMaksimum[0],$titikMaksimum[1]]
        ];
        
        // return response()->json($data);
        // return response()->view('algoritma',[
        //     "dataAlgo" => $data
        // ]);
        // return response()->view('components.try',[
        //     "dataAlgo" => $data
        // ]);