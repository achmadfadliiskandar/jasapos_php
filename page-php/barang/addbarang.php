<?php
session_start();

// Redirect ke halaman login jika belum login
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}

// Mendapatkan role pengguna
$username = htmlspecialchars($_SESSION['username']);
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>

    <link rel="stylesheet" href="../../backend/style.css">
</head>
<body>

    <!-- Navbar -->
    <?php include '../../backend/navbar.php'; ?>

    <div class="container">
        <h1>Tambah Barang : <?php echo $username; ?>!</h1>
            <?php
            include '../../backend/koneksi.php';
            if (isset($_POST['submit'])) {
                $nama_barang = $_POST['nama_barang'];
                $harga = $_POST['harga'];
                $stok = $_POST['stok'];

                $sql = "INSERT INTO barang(nama_barang,harga,stok) VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("sss", $nama_barang, $harga, $stok);
                    if ($stmt->execute()) {
                        echo "<script>
                                alert('Barang berhasil ditambahkan!');
                                window.location.href = '/tugasweb/page-php/barang';
                            </script>";
                    } else {
                        echo "<script>
                                alert('Gagal menambahkan Barang!');
                                window.history.back();
                            </script>";
                    }
                } else {
                    $conn->close();
                }
            }
            ?>
            <form action="./addbarang.php" method="POST">
                <!-- Input untuk username -->
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" placeholder="Masukkan nama_barang" required>
                <br><br>

                <!-- Input untuk password -->
                <label for="harga">Harga</label>
                <input type="harga" id="harga" name="harga" placeholder="Masukkan harga" required>
                <br><br>

                <!-- Input untuk password -->
                <label for="stok">Stok</label>
                <input type="stok" id="stok" name="stok" placeholder="Masukkan stok" required>
                <br><br>

                <!-- Tombol submit -->
                <button type="submit" name="submit">Tambah Barang</button>
            </form>
        </div>

    <!-- Footer -->
    <?php include '../../backend/footer.php'; ?>

</body>

</html>