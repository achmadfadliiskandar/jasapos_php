<?php
session_start();

// Redirect ke halaman login jika belum login
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}

// Include file koneksi
include '../../backend/koneksi.php';

// Ambil ID dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Periksa apakah ID valid
if ($id > 0) {
    // Query untuk mendapatkan data barang berdasarkan ID
    $sql = "SELECT * FROM barang WHERE id_barang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah data ditemukan
    if ($result->num_rows > 0) {
        $barang = $result->fetch_assoc();
    } else {
        echo "<script>
                alert('Data tidak ditemukan!');
                window.location.href = '/tugasweb/page-php/barang';
              </script>";
        exit;
    }
    $stmt->close();
} else {
    echo "<script>
            alert('ID tidak valid!');
            window.location.href = '/tugasweb/page-php/barang';
          </script>";
    exit;
}

// Proses update data
if (isset($_POST['update'])) {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $updateSql = "UPDATE barang SET nama_barang = ?, harga = ?, stok = ? WHERE id_barang = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("siii", $nama_barang, $harga, $stok, $id);

    if ($updateStmt->execute()) {
        echo "<script>
                alert('Data barang berhasil diperbarui!');
                window.location.href = '/tugasweb/page-php/barang';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data barang!');
                window.history.back();
              </script>";
    }
    $updateStmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="../../backend/style.css">
</head>

<body>
    <?php include '../../backend/navbar.php'; ?>
    <h1>Edit Barang</h1>
    <div class="container">
        <form method="POST">
            <label for="nama_barang">Nama Barang:</label>
            <input type="text" id="nama_barang" name="nama_barang" value="<?php echo htmlspecialchars($barang['nama_barang']); ?>" required>
            <br><br>

            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" value="<?php echo htmlspecialchars($barang['harga']); ?>" required>
            <br><br>

            <label for="stok">Stok:</label>
            <input type="number" id="stok" name="stok" value="<?php echo htmlspecialchars($barang['stok']); ?>" required>
            <br><br>

            <button type="submit" name="update">Update</button>
            <a href="../barang/index.php">Back</a>
        </form>
    </div>
    <!-- Footer -->
    <?php include '../../backend/footer.php'; ?>
</body>

</html>