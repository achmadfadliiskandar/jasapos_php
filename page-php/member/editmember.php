<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}
include '../../backend/koneksi.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    $sql = "SELECT * FROM member WHERE id_member = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $member = $result->fetch_assoc();
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href = 'index.php';</script>";
        exit;
    }
    $stmt->close();
} else {
    echo "<script>alert('ID tidak valid!'); window.location.href = 'index.php';</script>";
    exit;
}
if (isset($_POST['update'])) {
    $nama_member = $_POST['nama_member'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $id_paket = $_POST['id_paket'];
    $updateSql = "UPDATE member SET nama_member = ?, alamat = ?, telepon = ?, id_paket = ? WHERE id_member = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sssii", $nama_member, $alamat, $telepon, $id_paket, $id);
    if ($updateStmt->execute()) {
        echo "<script>alert('Data member berhasil diperbarui!'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data member!'); window.history.back();</script>";
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
    <title>Edit Member</title>
    <link rel="stylesheet" href="../../backend/style.css">
</head>
<body>
    <?php include '../../backend/navbar.php'; ?>
    <div class="container">
        <h1>Edit Member</h1>
        <form method="POST">
            <label for="nama_member">Nama Member</label>
            <input type="text" id="nama_member" name="nama_member" value="<?php echo htmlspecialchars($member['nama_member']); ?>" required>
            <br><br>
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" required><?php echo htmlspecialchars($member['alamat']); ?></textarea>
            <br><br>
            <label for="telepon">Telepon</label>
            <input type="text" id="telepon" name="telepon" value="<?php echo htmlspecialchars($member['telepon']); ?>" required>
            <br><br>
            <label for="id_paket">ID Paket</label>
            <input type="number" id="id_paket" name="id_paket" value="<?php echo htmlspecialchars($member['id_paket']); ?>" required>
            <br><br>
            <button type="submit" name="update">Update</button>
        </form>
    </div>
    <?php include '../../backend/footer.php'; ?>
</body>
</html>