<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}
$id_user = $_SESSION['id_user'];
include '../../backend/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
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
                    <th>Tanggal Transaksi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Prepare SQL query untuk mendapatkan transaksi berdasarkan id_user
                $sql = "SELECT * FROM transaksi WHERE id_user = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id_user);
                $stmt->execute();
                $result = $stmt->get_result(); // Ambil hasil dari prepared statement

                if ($result->num_rows > 0): // Jika ada data transaksi
                    $nomor = 1;
                    while ($row = $result->fetch_assoc()): // Loop untuk setiap transaksi
                ?>
                        <tr>
                            <td><?php echo $nomor++; ?></td>
                            <td><?php echo $row['tanggal_transaksi']; ?></td>
                            <td>
                                <a href="detailtransaksi.php?id=<?php echo $row['id_transaksi']; ?>" class="buttonedit">Detail Transaksi</a>
                            </td>
                        </tr>
                    <?php
                    endwhile;
                else:
                    ?>
                    <tr>
                        <td colspan="3">Tabelnya Kosong</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php include '../../backend/footer.php'; ?>
</body>

</html>