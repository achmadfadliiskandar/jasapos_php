<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}
include '../../backend/koneksi.php';
if (isset($_POST['submit'])) {
    $nama_member = $_POST['nama_member'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $id_paket = $_POST['id_paket'];
    $sql = "INSERT INTO member(nama_member, alamat, telepon, id_paket) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssi", $nama_member, $alamat, $telepon, $id_paket);
        if ($stmt->execute()) {
            echo "<script>alert('Member berhasil ditambahkan!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan member!'); window.history.back();</script>";
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
    <title>Tambah Member</title>
    <link rel="stylesheet" href="../../backend/style.css">
</head>
<body>
    <?php include '../../backend/navbar.php'; ?>
    <div class="container">
        <h1>Tambah Member</h1>
        <form action="addmember.php" method="POST">
            <label for="nama_member">Nama Member</label>
            <input type="text" id="nama_member" name="nama_member" placeholder="Masukkan nama member" required>
            <br><br>
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" placeholder="Masukkan alamat" required></textarea>
            <br><br>
            <label for="telepon">Telepon</label>
            <input type="text" id="telepon" name="telepon" placeholder="Masukkan telepon" required>
            <br><br>
            <label for="id_paket">ID Paket</label>
            <input type="number" id="id_paket" name="id_paket" placeholder="Masukkan ID paket" required>
            <br><br>
            <button type="submit" name="submit">Tambah Member</button>
        </form>
    </div>
    <?php include '../../backend/footer.php'; ?>
</body>
</html>