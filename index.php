<?php
if (isset($_GET['data'])) {
    $jsonData = urldecode($_GET['data']);
    $data = json_decode($jsonData, true);

    // Sekarang Anda memiliki data yang dikirim dari algoritma.php dalam bentuk array asosiatif
    // Anda dapat mengakses elemen data seperti ini:
    echo $data['pernyataan1'] . "<br>";
    echo $data['pernyataan2'] . "<br>";
    echo $data['pernyataanhasil'] . "<br>";
    echo "<pre>";
    print_r($data['titikArsiran']);
    print_r($data['tertinggi']);
    echo "</pre>";

    

    $jumlahTitik = count($data["titikArsiran"]);

    $titikUntukChart = [];
    if($jumlahTitik == 4){
        foreach($data["titikArsiran"] as $item){
            if($item[0] == 0 && $item[1] == 0 ){
                // array_unshift($titikUntukChart, $item);
                $titikUntukChart[0] = $item;
            }
            if($item[0] == 0 && $item[1] != 0){
                // array_unshift($titikUntukChart, $item);
                $titikUntukChart[1] = $item;
            }
            if($item[0] != 0 && $item[1] != 0){
                $titikUntukChart[2] = $item;
            }
            if($item[0] != 0 && $item[1] == 0){
                // array_unshift($titikUntukChart, $item);
                $titikUntukChart[3] = $item;
            }
        }
    }else if($jumlahTitik == 5){
        foreach($data["titikArsiran"] as $item){
            if($item[0] == 0 && $item[1] == 0 ){
                // array_unshift($titikUntukChart, $item);
                $titikUntukChart[0] = $item;
            }
            if($item[0] == 0 && $item[1] != 0){
                // array_unshift($titikUntukChart, $item);
                $titikUntukChart[1] = $item;
            }
            if($item[0] != 0 && $item[1] != 0){
                if(empty($titikUntukChart[2])){
                    $titikUntukChart[2] = $item;
                }else{
                    $titikUntukChart[3] = $item;
                }
            }
            if($item[0] != 0 && $item[1] == 0){
                // array_unshift($titikUntukChart, $item);
                $titikUntukChart[4] = $item;
            }
        }

        if($titikUntukChart[2][0] > $titikUntukChart[3][0]){
            $arrTemp = $titikUntukChart[2];
            $titikUntukChart[2] = $titikUntukChart[3];
            $titikUntukChart[3] = $arrTemp;
        }
    }


    //membuat semua isi array menjadi integer
    $titikUntukChart = array_map(function ($item) {
        return array_map('intval', $item);
    }, $titikUntukChart);

    // echo "<pre>";
    // print_r($titikUntukChart);
    // echo "</pre>";
    echo "<script>";
    echo "jsonTitikUntukChart = ".json_encode($titikUntukChart);
    echo "</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linear Programming</title>
    <link rel="stylesheet" href="./css/output.css">
</head>
<body>
    <h1 class="text-4xl text-center font-bold py-6">Riset Operasional : Linear programming</h1>
    
    <div class="container px-10">
        <form class="grid grid-cols-2 grid-flow-col gap-4" action="algoritma.php" method="POST">
            
            <div>
                <!-- Unit -->
                <div class="grid grid-cols-2 grid-flow-col gap-4">
                    <div class="flex flex-col">
                        <label for="">Nama Unit 1</label>
                        <input type="text" name="nama_unit_1">
                    </div>
                    
                    <div class="flex flex-col">
                        <label for="">Nama Unit 2</label>
                        <input type="text" name="nama_unit_2">
                    </div>
                </div>

                <!-- Ini Batasan -->
                <div class="grid grid-cols-2 grid-flow-col gap-4">
                    <div class="flex flex-col">
                        <label for="">Nilai Batasan 1</label>
                        <input type="text" name="nilai_batasan_1">
                    </div>
                    
                    <div class="flex flex-col">
                        <label for="">Nilai Batasan 2</label>
                        <input type="text" name="nilai_batasan_2">
                    </div>
                </div>
                
                <!-- Ini nilai Unit 1,2 untuk Batasan 1-->
                <div class="grid grid-cols-2 grid-flow-col gap-4">
                    <div class="flex flex-col">
                        <label for="">Nilai Unit 1 untuk Batasan 1</label>
                        <input type="text" name="nilai_unit_1_untuk_batasan_1">
                    </div>
                    
                    <div class="flex flex-col">
                        <label for="">Nilai Unit 2 untuk Batasan 1</label>
                        <input type="text" name="nilai_unit_2_untuk_batasan_1">
                    </div>
                </div>
                
                <!-- Ini nilai Unit 1,2 untuk Batasan 2-->
                <div class="grid grid-cols-2 grid-flow-col gap-4">
                    <div class="flex flex-col">
                        <label for="">Nilai Unit 1 untuk Batasan 2</label>
                        <input type="text" name="nilai_unit_1_untuk_batasan_2">
                    </div>
                    
                    <div class="flex flex-col">
                        <label for="">Nilai Unit 2 untuk Batasan 2</label>
                        <input type="text" name="nilai_unit_2_untuk_batasan_2">
                    </div>
                </div>

                <!-- Ini Batasan Unit-->
                <div class="grid grid-cols-2 grid-flow-col gap-4">
                    <div class="flex flex-col">
                        <label for="">Nilai Batasan Unit 1</label>
                        <input type="text" name="nilai_batasan_unit_1">
                    </div>
                    
                    <div class="flex flex-col">
                        <label for="">Nilai Batasan Unit 2</label>
                        <input type="text" name="nilai_batasan_unit_2">
                    </div>
                </div>
                
                <!-- Ini Keuntungan Unit-->
                <div class="grid grid-cols-2 grid-flow-col gap-4">
                    <div class="flex flex-col">
                        <label for="">Nilai Keuntungan Unit 1</label>
                        <input type="text" name="nilai_keuntungan_unit_1">
                    </div>
                    
                    <div class="flex flex-col">
                        <label for="">Nilai Keuntungan Unit 2</label>
                        <input type="text" name="nilai_keuntungan_unit_2">
                    </div>
                </div>
                
                <!-- Button hitung -->
                <div>
                    <button class="px-3 py-1 m-2 bg-blue-300 shadow-lg rounded-sm">Hitung</button>
                </div>
            </form>
            </div>

    </div>
    <div id="canvas-holder" style="width:80%"> 
         <canvas id="myChart"></canvas> 
    </div> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script> 
    <script>
        console.log(jsonTitikUntukChart);
        var outputData = {
            data: []
        };

        for (var key in jsonTitikUntukChart) {
            var x = jsonTitikUntukChart[key][0];
            var y = jsonTitikUntukChart[key][1];
            outputData.data.push({ x: x, y: y });
        }
        console.log(outputData);
        console.log(outputData.data);

        // nilai tertinggi untuk menetapkan luas chart
        var max_x = Math.max(...outputData.data.map(item => item.x));
        var max_y = Math.max(...outputData.data.map(item => item.y));

    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [{
            label: 'Grafik dari titik maksimum',
            // fill: false,
            fill: {
                target: {
                    x: 8,
                    y: 8
                },
                above: 'rgb(255, 0, 0)', 
                },
            lineTension: 0,
            data: outputData.data,
                backgroundColor: [
                'rgba(123, 83, 252, 0.8)',
                ],
                borderColor: [
                'rgba(33, 232, 234, 1)',
                ],
            borderWidth: 1
            }],
        },
        options: {
            scales: {
            xAxes: [{
                type: 'linear',
                position: 'bottom',
                ticks: {
                min: -1,
                max: max_x+10,
                stepSize: 1,
                }
            }],
            yAxes: [{
                ticks: {
                min: -2,
                max: max_y+10,
                stepSize: 2,
                }
            }]
            }
        }
    });

    </script>  
</body>
</html>