<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}

// Include file koneksi ke database
include '../../backend/koneksi.php';

// Ambil ID dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Periksa apakah ID valid
if ($id > 0) {
    // Query untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM barang WHERE id_barang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href = '/tugasweb/page-php/barang';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data!');
                window.history.back();
              </script>";
    }

    $stmt->close();
} else {
    echo "<script>
            alert('ID tidak valid!');
            window.location.href = '/tugasweb/page-php/barang';
          </script>";
}

$conn->close();
?>