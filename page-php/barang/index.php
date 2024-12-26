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
    <title>Data Barang</title>

    <link rel="stylesheet" href="../../backend/style.css">
</head>

<body>

    <!-- Navbar -->
    <?php include '../../backend/navbar.php'; ?>

    <div class="container">
        <h1>Data Barang : <?php echo $username; ?>!</h1>
        <a href="./addbarang.php" class="buttonadd">Tambah</a>
        <table>
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- batas php untuk menampilkan data dengan koneksi.php -->
                <?php
                include '../../backend/koneksi.php';
                $sql = "SELECT * FROM barang"; // Ganti dengan nama tabel Anda
                $result = $conn->query($sql);
                ?>
                <?php if($result->num_rows > 0): ?>
                <?php foreach($result as $key => $row): ?>
                <tr>
                    <td><?php echo $key+1 ?></td>
                    <td><?php echo $row['nama_barang'] ?></td>
                    <td><?php echo number_format($row['harga'],3,',','.') ?></td>
                    <td>
                    <a href="edit.php?id=<?php echo $row['id_barang']; ?>" class="buttonedit">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id_barang']; ?>" class="buttonhapus">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <td colspan="3">Tabelnya Kosong</td>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <!-- Footer -->
    <?php include '../../backend/footer.php'; ?>

</body>
</html>