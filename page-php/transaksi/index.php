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
    <title>Data Member</title>
    <link rel="stylesheet" href="../../backend/style.css">
</head>
<body>
    <?php include '../../backend/navbar.php'; ?>
    <div class="container">
        <h1>Data Transaksi</h1>
        <table>
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>ID Transaksi</th>
                    <th>ID Member</th>
                    <th>Tanggal Transaksi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM transaksi";
                $result = $conn->query($sql);
                if ($result->num_rows > 0):
                    foreach ($result as $key => $row):
                ?>
                <tr>
                    <td><?php echo $key + 1 ?></td>
                    <td><?php echo $row['id_transaksi'] ?></td>
                    <td><?php echo $row['id_member'] ?></td>
                    <td><?php echo $row['tanggal_transaksi'] ?></td>
                    <td>
                        <a href="detailtransaksi.php?id=<?php echo $row['id_transaksi']; ?>" class="buttonedit">Detail Transaksi</a>
                    </td>
                </tr>
                <?php
                    endforeach;
                else:
                ?>
                <tr>
                    <td colspan="6">Tabelnya Kosong</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php include '../../backend/footer.php'; ?>
</body>
</html>