<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}
include '../../backend/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Paket Member</title>
    <link rel="stylesheet" href="../../backend/style.css">
</head>
<body>
    <?php include '../../backend/navbar.php'; ?>
    <div class="container">
        <h1>Data Paket Member</h1>
        <a href="addpaket.php" class="buttonadd">Tambah</a>
        <table>
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Durasi</th>
                    <th>Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM paket_member";
                $result = $conn->query($sql);
                if ($result->num_rows > 0):
                    foreach ($result as $key => $row):
                ?>
                <tr>
                    <td><?php echo $key + 1 ?></td>
                    <td><?php echo $row['durasi'] ?></td>
                    <td><?php echo $row['harga'] ?></td>
                    <td>
                        <a href="editpaket.php?id=<?php echo $row['id_paket']; ?>" class="buttonedit">Edit</a>
                        <a href="deletepaket.php?id=<?php echo $row['id_paket']; ?>" class="buttonhapus">Hapus</a>
                    </td>
                </tr>
                <?php
                    endforeach;
                else:
                ?>
                <tr>
                    <td colspan="4">Tabelnya Kosong</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php include '../../backend/footer.php'; ?>
</body>
</html>