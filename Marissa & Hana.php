<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Sederhana</title>
</head>
<body>
    <h2>Kalkulator Sederhana</h2>
    <form method="post" action="">
        <label for="a">Masukkan bilangan pertama (a):</label>
        <input type="number" step="any" name="a" id="a" required><br><br>
        
        <label for="b">Masukkan bilangan kedua (b):</label>
        <input type="number" step="any" name="b" id="b" required><br><br>
        
        <label for="operator">Pilih operasi:</label>
        <select name="operator" id="operator">
            <option value="tambah">Penjumlahan (+)</option>
            <option value="kurang">Pengurangan (-)</option>
            <option value="kali">Perkalian (x)</option>
            <option value="bagi">Pembagian (/)</option>
        </select><br><br>

        <input type="submit" name="hitung" value="Hitung">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $a = filter_input(INPUT_POST, 'a', FILTER_VALIDATE_FLOAT);
        $b = filter_input(INPUT_POST, 'b', FILTER_VALIDATE_FLOAT);
        $operator = $_POST['operator'] ?? '';

        if ($a === false || $b === false) {
            echo "<p style='color: red;'>Input tidak valid. Harap masukkan angka yang benar.</p>";
        } else {
            switch ($operator) {
                case 'tambah':
                    $hasil = $a + $b;
                    $operasi = "$a + $b = $hasil";
                    break;
                case 'kurang':
                    $hasil = $a - $b;
                    $operasi = "$a - $b = $hasil";
                    break;
                case 'kali':
                    $hasil = $a * $b;
                    $operasi = "$a × $b = $hasil";
                    break;
                case 'bagi':
                    if ($b == 0) {
                        $operasi = "Kesalahan: Tidak bisa membagi dengan nol.";
                    } else {
                        $hasil = $a / $b;
                        $operasi = "$a ÷ $b = $hasil";
                    }
                    break;
                default:
                    $operasi = "Operasi tidak dikenali.";
            }

            echo "<h3>Hasil: $operasi</h3>";
        }
    }
    ?>
</body>
</html>
