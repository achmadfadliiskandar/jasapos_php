<?php
session_start();

// Redirect ke halaman login jika belum login
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}

// Mendapatkan ID user dan username dari sesi
$id_user = $_SESSION['id_user'];
$username = htmlspecialchars($_SESSION['username']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>

    <link rel="stylesheet" href="../../backend/style.css">
</head>

<body>

    <!-- Navbar -->
    <?php include '../../backend/navbar.php'; ?>

    <div class="container">
        <h1>Tambah Barang: <?php echo $username; ?>!</h1>
        <?php
        include '../../backend/koneksi.php';
        if (isset($_POST['submit'])) {
            $nama_barang = $_POST['nama_barang'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];
            $id_user = $id_user;

            // Menambahkan ID user dari sesi
            $sql = "INSERT INTO barang (nama_barang, harga, stok, id_user) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sdii", $nama_barang, $harga, $stok, $id_user); // Menambahkan id_user sebagai parameter
                if ($stmt->execute()) {
                    echo "<script>
                alert('Barang berhasil ditambahkan!');
                window.location.href = '/tugasweb/page-php/barang';
              </script>";
                } else {
                    echo "<script>
                alert('Gagal menambahkan barang!');
                window.history.back();
              </script>";
                }
                $stmt->close();
            } else {
                echo "<script>
            alert('Terjadi kesalahan pada server!');
            window.history.back();
          </script>";
            }
            $conn->close();
        }
        ?>
        <form action="./addbarang.php" method="POST">
            <!-- Input untuk Nama Barang -->
            <label for="nama_barang">Nama Barang</label>
            <input type="text" id="nama_barang" name="nama_barang" placeholder="Masukkan nama barang" required>
            <br><br>

            <!-- Input untuk Harga -->
            <label for="harga">Harga</label>
            <input type="number" step="0.01" id="harga" name="harga" placeholder="Masukkan harga" required>
            <br><br>

            <!-- Input untuk Stok -->
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" placeholder="Masukkan stok" required>
            <br><br>

            <!-- Tombol submit -->
            <button type="submit" name="submit">Tambah Barang</button>
        </form>
    </div>

    <!-- Footer -->
    <?php include '../../backend/footer.php'; ?>

</body>

</html>