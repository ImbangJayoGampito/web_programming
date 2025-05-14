<?php
// session_example.php
session_start();
// Fungsi untuk reset session
function resetSession()
{
    $_SESSION = array();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
// Cek apakah tombol reset ditekan
if (isset($_POST['reset'])) {
    resetSession();
}
// Tambah item ke keranjang jika ada form submission
if (isset($_POST['add_item'])) {
    $item = $_POST['item'];
    $price = $_POST['price'];
    if (!empty($item) && !empty($price)) {
        // Inisialisasi array keranjang jika belum ada
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        // Tambahkan item ke keranjang
        $_SESSION['cart'][] = array(
            'item' => $item,
            'price' => $price
        );
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;

            padding: 20px;
        }

        .cart {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Demonstrasi $_SESSION Superglobal</h1>
    <div class="form-container">
        <h2>Tambah Item ke Keranjang</h2>
        <form method="post" action="">
            <label for="item">Nama Item:</label>
            <input type="text" id="item" name="item" required><br><br>
            <label for="price">Harga (Rp):</label>
            <input type="number" id="price" name="price" required><br><br>
            <input type="submit" name="add_item" value="Tambah ke Keranjang">
        </form>
    </div>
    <div class="cart">
        <h2>Keranjang Belanja</h2>
        <?php
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo "<p>Keranjang masih kosong</p>";
        } else {
            echo "<table>";
            echo "<tr><th>No</th><th>Item</th><th>Harga</th></tr>";
            $total = 0;

            foreach ($_SESSION['cart'] as $index => $item) {
                echo "<tr>";
                echo "<td>" . ($index + 1) . "</td>";
                echo "<td>" . $item['item'] . "</td>";
                echo "<td>Rp " . number_format($item['price'], 0, ',', '.') . "</td>";
                echo "</tr>";
                $total += $item['price'];
            }
            echo "<tr style='font-weight: bold;'>";
            echo "<td colspan='2'>Total</td>";
            echo "<td>Rp " . number_format($total, 0, ',', '.') . "</td>";
            echo "</tr>";
            echo "</table>";
            echo "<form method='post' action=''>";
            echo "<input type='submit' name='reset' value='Reset Keranjang'>";
            echo "</form>";
        }
        ?>
    </div>
    <div class="session-info">
        <h2>Informasi Session</h2>
        <p>Session ID: <?php echo session_id(); ?></p>
        <p>Session Name: <?php echo session_name(); ?></p>
        <h3>Isi array $_SESSION:</h3>
        <pre><?php print_r($_SESSION); ?></pre>
    </div>
</body>

</html>