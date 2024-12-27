<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}
include '../../backend/koneksi.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    $sql = "DELETE FROM member WHERE id_member = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Member berhasil dihapus!'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus member!'); window.history.back();</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('ID tidak valid!'); window.location.href = 'index.php';</script>";
}
$conn->close();
?>