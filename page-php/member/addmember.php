<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}
include '../../backend/koneksi.php';

// Ambil data untuk select option nama_member dari tabel user
$userOptions = [];
$userQuery = "SELECT id_user, username FROM user WHERE role='member'";
$userResult = $conn->query($userQuery);
if ($userResult->num_rows > 0) {
    while ($row = $userResult->fetch_assoc()) {
        $userOptions[] = $row;
    }
}

// Ambil data untuk select option id_paket dari tabel paket_member
$paketOptions = [];
$paketQuery = "SELECT id_paket, durasi FROM paket_member";
$paketResult = $conn->query($paketQuery);
if ($paketResult->num_rows > 0) {
    while ($row = $paketResult->fetch_assoc()) {
        $paketOptions[] = $row;
    }
}

// Proses penambahan member
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
    }
    $stmt->close();
}
$conn->close();
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
            <select id="nama_member" name="nama_member" required>
                <option value="">Pilih Nama Member</option>
                <?php foreach ($userOptions as $user): ?>
                    <option value="<?php echo $user['username']; ?>"><?php echo htmlspecialchars($user['username']); ?></option>
                <?php endforeach; ?>
            </select>
            <br><br>

            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" placeholder="Masukkan alamat" required></textarea>
            <br><br>

            <label for="telepon">Telepon</label>
            <input type="text" id="telepon" name="telepon" placeholder="Masukkan telepon" required>
            <br><br>

            <label for="id_paket">ID Paket</label>
            <select id="id_paket" name="id_paket" required>
                <option value="">Pilih Paket</option>
                <?php foreach ($paketOptions as $paket): ?>
                    <option value="<?php echo $paket['id_paket']; ?>"><?php echo htmlspecialchars($paket['durasi']); ?></option>
                <?php endforeach; ?>
            </select>
            <br><br>

            <button type="submit" name="submit">Tambah Member</button>
        </form>
    </div>
    <?php include '../../backend/footer.php'; ?>
</body>
</html>