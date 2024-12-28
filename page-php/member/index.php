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
        <h1>Data Member</h1>
        <a href="addmember.php" class="buttonadd">Tambah</a>
        <table>
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Nama Member</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>ID Paket</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "
                    SELECT 
                    member.id_member,
                    member.nama_member, 
                    member.alamat,
                    member.telepon,
                    member.id_paket,
                    paket_member.durasi 
                FROM 
                    member
                INNER JOIN paket_member ON member.id_paket = paket_member.id_paket
                ";
                $result = $conn->query($sql);
                if ($result->num_rows > 0):
                    foreach ($result as $key => $row):
                ?>
                <tr>
                    <td><?php echo $key + 1 ?></td>
                    <td><?php echo $row['nama_member'] ?></td>
                    <td><?php echo $row['alamat'] ?></td>
                    <td><?php echo $row['telepon'] ?></td>
                    <td><?php echo $row['durasi'] ?></td>
                    <td>
                        <a href="editmember.php?id=<?php echo $row['id_member']; ?>" class="buttonedit">Edit</a>
                        <a href="deletemember.php?id=<?php echo $row['id_member']; ?>" class="buttonhapus">Hapus</a>
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