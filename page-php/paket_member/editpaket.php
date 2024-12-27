<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}
include '../../backend/koneksi.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    $sql = "SELECT * FROM paket_member WHERE id_paket = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $paket = $result->fetch_assoc();
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
    $durasi = $_POST['durasi'];
    $harga = $_POST['harga'];
    $updateSql = "UPDATE paket_member SET durasi = ?, harga = ? WHERE id_paket = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sdi", $durasi, $harga, $id);
    if ($updateStmt->execute()) {
        echo "<script>alert('Data paket member berhasil diperbarui!'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data paket member!'); window.history.back();</script>";
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
    <title>Edit Paket Member</title>
    <link rel="stylesheet" href="../../backend/style.css">
</head>
<body>
    <?php include '../../backend/navbar.php'; ?>
    <div class="container">
        <h1>Edit Paket Member</h1>
        <form method="POST">
            <label for="durasi">Durasi</label>
            <select id="durasi" name="durasi" required>
                <option value="1 bulan" <?php echo $paket['durasi'] == '1 bulan' ? 'selected' : ''; ?>>1 bulan</option>
                <option value="6 bulan" <?php echo $paket['durasi'] == '6 bulan' ? 'selected' : ''; ?>>6 bulan</option>
                <option value="12 bulan" <?php echo $paket['durasi'] == '12 bulan' ? 'selected' : ''; ?>>12 bulan</option>
            </select>
            <br><br>
            <label for="harga">Harga</label>
            <input type="number" step="0.01" id="harga" name="harga" value="<?php echo htmlspecialchars($paket['harga']); ?>" required>
            <br><br>
            <button type="submit" name="update">Update</button>
        </form>
    </div>
    <?php include '../../backend/footer.php'; ?>
</body>
</html>