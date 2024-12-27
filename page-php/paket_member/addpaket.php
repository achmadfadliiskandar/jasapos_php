<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}
include '../../backend/koneksi.php';
if (isset($_POST['submit'])) {
    $durasi = $_POST['durasi'];
    $harga = $_POST['harga'];
    $sql = "INSERT INTO paket_member(durasi, harga) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sd", $durasi, $harga);
        if ($stmt->execute()) {
            echo "<script>alert('Paket member berhasil ditambahkan!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan paket member!'); window.history.back();</script>";
        }
    } else {
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Paket Member</title>
    <link rel="stylesheet" href="../../backend/style.css">
</head>
<body>
    <?php include '../../backend/navbar.php'; ?>
    <div class="container">
        <h1>Tambah Paket Member</h1>
        <form action="addpaket.php" method="POST">
            <label for="durasi">Durasi</label>
            <select id="durasi" name="durasi" required>
                <option value="1 bulan">1 bulan</option>
                <option value="6 bulan">6 bulan</option>
                <option value="12 bulan">12 bulan</option>
            </select>
            <br><br>
            <label for="harga">Harga</label>
            <input type="number" step="0.01" id="harga" name="harga" placeholder="Masukkan harga" required>
            <br><br>
            <button type="submit" name="submit">Tambah Paket</button>
        </form>
    </div>
    <?php include '../../backend/footer.php'; ?>
</body>
</html>