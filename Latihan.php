<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Inisialisasi sesi jika belum ada
if (!isset($_SESSION['hasil'])) {
    $_SESSION['hasil'] = 0;
}

$hasil = "";
$operasi = "";
$valueA = "";
$valueB = "";
$selectedOp = "";

// Tangani input dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reset'])) {
        $hasil = "";
        $operasi = "Kalkulator telah di-reset.";
        $_SESSION['hasil'] = 0;
    } elseif (isset($_POST['pakai_sebelumnya'])) {
        $valueA = $_SESSION['hasil'];
        $valueB = "";
        $operasi = "Menggunakan hasil sebelumnya sebagai bilangan pertama: $valueA";
    } elseif (isset($_POST['hitung'])) {
        $a = filter_input(INPUT_POST, 'a', FILTER_VALIDATE_FLOAT);
        $b = filter_input(INPUT_POST, 'b', FILTER_VALIDATE_FLOAT);
        $operator = $_POST['operator'] ?? '';

        $valueA = $_POST['a'];
        $valueB = $_POST['b'];
        $selectedOp = $operator;

        if ($a === false || $b === false) {
            $operasi = "❗ Input tidak valid. Masukkan angka yang benar.";
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
                        $operasi = "❗ Tidak bisa membagi dengan nol.";
                    } else {
                        $hasil = $a / $b;
                        $operasi = "$a ÷ $b = $hasil";
                    }
                    break;
                default:
                    $operasi = "❗ Operasi tidak dikenali.";
            }
            $_SESSION['hasil'] = $hasil;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Pink - Lanjut Perhitungan</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #ffe6f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff0f6;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(255, 105, 180, 0.3);
        }

        h2 {
            text-align: center;
            color: #cc0066;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #660033;
        }

        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
        }

        .buttons button {
            width: 48%;
            padding: 10px;
            margin-top: 10px;
            background-color: #ff66b2;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .buttons button:hover {
            background-color: #e60073;
        }

        .result {
            margin-top: 20px;
            background-color: #ffe6f0;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ff99cc;
            color: #99004d;
        }

        .result strong {
            display: block;
            margin-bottom: 5px;
            color: #cc0066;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>💖 Kalkulator Pink 💖</h2>

    <?php if ($operasi !== ""): ?>
    <div class="result">
        <strong>Hasil:</strong>
        <?= htmlspecialchars($operasi) ?>
    </div>
    <?php endif; ?>

    <form method="post">
        <label for="a">Bilangan pertama:</label>
        <input type="number" name="a" step="any" id="a" required value="<?= htmlspecialchars($valueA) ?>">

        <label for="b">Bilangan kedua:</label>
        <input type="number" name="b" step="any" id="b" required value="<?= htmlspecialchars($valueB) ?>">

        <label for="operator">Operasi:</label>
        <select name="operator" id="operator" required>
            <option value="tambah" <?= $selectedOp === 'tambah' ? 'selected' : '' ?>>Tambah (+)</option>
            <option value="kurang" <?= $selectedOp === 'kurang' ? 'selected' : '' ?>>Kurang (−)</option>
            <option value="kali" <?= $selectedOp === 'kali' ? 'selected' : '' ?>>Kali (×)</option>
            <option value="bagi" <?= $selectedOp === 'bagi' ? 'selected' : '' ?>>Bagi (÷)</option>
        </select>

        <div class="buttons">
            <button type="submit" name="hitung">Hitung</button>
            <button type="submit" name="reset">Reset</button>
            <button type="submit" name="pakai_sebelumnya">Gunakan hasil sebelumnya</button>
        </div>
    </form>
</div>
</body>
</html>
