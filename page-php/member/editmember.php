<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}
include '../../backend/koneksi.php';

// Ambil ID dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validasi dan ambil data member
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

// Query untuk mendapatkan data user dengan role 'member'
$userQuery = "SELECT id_user, username FROM user WHERE role = 'member'";
$userResult = $conn->query($userQuery);

// Query untuk mendapatkan data paket
$paketQuery = "SELECT id_paket, durasi FROM paket_member";
$paketResult = $conn->query($paketQuery);

// Proses update data
if (isset($_POST['update'])) {
    $id_user = $_POST['nama_member'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $id_paket = $_POST['id_paket'];

    $updateSql = "UPDATE member SET id_user = ?, alamat = ?, telepon = ?, id_paket = ? WHERE id_member = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("issii", $id_user, $alamat, $telepon, $id_paket, $id);
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
            <select id="nama_member" name="nama_member" required>
                <?php while ($user = $userResult->fetch_assoc()): ?>
                    <option value="<?php echo $user['id_user']; ?>" 
                        <?php echo $user['id_user'] == $member['nama_member'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($user['username']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <br><br>
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" required><?php echo htmlspecialchars($member['alamat']); ?></textarea>
            <br><br>
            <label for="telepon">Telepon</label>
            <input type="text" id="telepon" name="telepon" value="<?php echo htmlspecialchars($member['telepon']); ?>" required>
            <br><br>
            <label for="id_paket">Paket</label>
            <select id="id_paket" name="id_paket" required>
                <?php while ($paket = $paketResult->fetch_assoc()): ?>
                    <option value="<?php echo $paket['id_paket']; ?>" 
                        <?php echo $paket['id_paket'] == $member['id_paket'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($paket['durasi']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <br><br>
            <button type="submit" name="update">Update</button>
        </form>
    </div>
    <?php include '../../backend/footer.php'; ?>
</body>
</html>