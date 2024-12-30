<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}
include '../../backend/koneksi.php';

// Periksa apakah `id` transaksi ada di URL
if (!isset($_GET['id'])) {
    echo "ID transaksi tidak ditemukan!";
    exit;
}

$id_transaksi = $_GET['id'];
$id_user = $_SESSION['id_user'];

// Query untuk mengambil data transaksi dan detail transaksi
$sql_transaksi = "SELECT * FROM transaksi WHERE id_transaksi = ? AND id_user = ?";
$stmt_transaksi = $conn->prepare($sql_transaksi);
$stmt_transaksi->bind_param("ii", $id_transaksi, $id_user);
$stmt_transaksi->execute();
$result_transaksi = $stmt_transaksi->get_result();

if ($result_transaksi->num_rows === 0) {
    echo "Transaksi tidak ditemukan atau bukan milik Anda!";
    exit;
}
$transaksi = $result_transaksi->fetch_assoc();

// Query untuk mengambil detail transaksi
$sql_detail = "SELECT dt.id_barang, b.nama_barang, dt.kuantitas, dt.harga_satuan, dt.subtotal 
               FROM detail_transaksi dt
               JOIN barang b ON dt.id_barang = b.id_barang
               WHERE dt.id_transaksi = ?";
$stmt_detail = $conn->prepare($sql_detail);
$stmt_detail->bind_param("i", $id_transaksi);
$stmt_detail->execute();
$result_detail = $stmt_detail->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="../../backend/style.css">
</head>

<body>
    <?php include '../../backend/navbar.php'; ?>
    <div class="container">
        <h1>Detail Transaksi</h1>
        <div class="transaksi-info">
            <p><strong>ID Transaksi:</strong> <?php echo $transaksi['id_transaksi']; ?></p>
            <p><strong>Tanggal Transaksi:</strong> <?php echo $transaksi['tanggal_transaksi']; ?></p>
        </div>

        <h2>Daftar Barang</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_harga = 0;
                while ($row = $result_detail->fetch_assoc()) {
                    $total_harga += $row['subtotal'];
                ?>
                    <tr>
                        <td><?php echo $row['nama_barang']; ?></td>
                        <td><?php echo $row['kuantitas']; ?></td>
                        <td><?php echo number_format($row['harga_satuan'], 2, ',', '.'); ?></td>
                        <td><?php echo number_format($row['subtotal'], 2, ',', '.'); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong><?php echo number_format($total_harga, 2, ',', '.'); ?></strong></td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <a href="./index.php" class='buttonadd'>Back</a>
    </div>
    <?php include '../../backend/footer.php'; ?>
</body>

</html>