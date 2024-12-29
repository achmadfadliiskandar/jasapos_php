<?php
session_start();

// Redirect ke halaman login jika belum login
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}

$role = $_SESSION['role'];
$user_id = $_SESSION['id_user'];

// Menghubungkan ke database
include '../../backend/koneksi.php';

// Menambahkan item ke cart
if (isset($_POST['add_to_cart'])) {
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $jumlah = $_POST['jumlah'];

    // Memeriksa apakah cart sudah ada
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Cek apakah item sudah ada di cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id_barang'] == $id_barang) {
            $item['jumlah'] += $jumlah; // Update jumlah jika sudah ada
            $found = true;
            break;
        }
    }

    // Jika barang belum ada, tambahkan item baru ke cart
    if (!$found) {
        $_SESSION['cart'][] = [
            'id_barang' => $id_barang,
            'nama_barang' => $nama_barang,
            'harga' => $harga,
            'stok' => $stok,
            'jumlah' => $jumlah
        ];
    }

    // Redirect kembali ke halaman cart
    header("Location: cart.php");
    exit;
}

// Menampilkan daftar barang
$sql = "SELECT * FROM barang WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Menggunakan ID user dari sesi
$stmt->execute();
$result = $stmt->get_result();

// Mendapatkan role pengguna dan data dari sesi
$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../../backend/style.css"> <!-- Link ke file CSS -->
</head>

<body>

    <!-- Navbar -->
    <?php include '../../backend/navbar.php'; ?>

    <div class="container mt-4">
        <h1>Welcome <?php echo $username; ?>!</h1>

        <div class="row">
            <!-- Kolom untuk Daftar Barang -->
            <div class="left-column">
                <h2>Daftar Barang</h2>
                <div class="item-list">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="item-card">
                            <h5 style="text-transform: capitalize;"><?php echo $row['nama_barang']; ?></h5>
                            <p>Harga: <?php echo number_format($row['harga'], 3, ',', '.'); ?></p>
                            <p>Stok: <?php echo $row['stok']; ?></p>
                            <form action="cart.php" method="POST">
                                <label for="jumlah">Jumlah:</label>
                                <input type="number" name="jumlah" value="1" min="1" max="<?php echo $row['stok']; ?>" class="form-control">
                                <input type="hidden" name="id_barang" value="<?php echo $row['id_barang']; ?>">
                                <input type="hidden" name="nama_barang" value="<?php echo $row['nama_barang']; ?>">
                                <input type="hidden" name="harga" value="<?php echo $row['harga']; ?>">
                                <input type="hidden" name="stok" value="<?php echo $row['stok']; ?>">
                                <button type="submit" name="add_to_cart" class="buttonadd">Add to Cart</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Kolom untuk Cart -->
            <div class="right-column">
                <h2>Your Cart</h2>
                <?php
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    echo "<table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>";
                    $total = 0;
                    foreach ($_SESSION['cart'] as $index => $item) {
                        $total_harga = $item['harga'] * $item['jumlah'];
                        $total += $total_harga;
                        echo "<tr>
                                <td>{$item['nama_barang']}</td>
                                <td>" . number_format($item['harga'], 3, ',', '.') . "</td>
                                <td>{$item['jumlah']}</td>
                                <td>" . number_format($total_harga, 3, ',', '.') . "</td>
                                <td>
                                    <form action='update_cart.php' method='POST'>
                                        <input type='hidden' name='index' value='$index'>
                                        <button type='submit' name='update_cart' class='btn btn-warning btn-sm'>Update</button>
                                    </form>
                                    <form action='remove_from_cart.php' method='POST'>
                                        <input type='hidden' name='index' value='$index'>
                                        <button type='submit' name='remove_item' class='btn btn-danger btn-sm'>Remove</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                    echo "</tbody></table>";
                    echo "<p><strong>Total: " . number_format($total, 3, ',', '.') . "</strong></p>";
                } else {
                    echo "<p>Your cart is empty.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../../backend/footer.php'; ?>

</body>

</html>