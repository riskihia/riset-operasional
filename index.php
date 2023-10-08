<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linear Programming</title>
    <link rel="stylesheet" href="./css/output.css">
</head>
<body class="bg-yellow-400">
    <h1 class="text-4xl text-center font-bold py-6">Riset Operasional : Linear programming</h1>
    
    <div class="container px-10">
        <form class="grid grid-rows grid-flow-col gap-4" action="algoritma.php" method="POST">
            
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
</body>
</html>