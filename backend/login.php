<?php
session_start();
include("koneksi.php");

$username = $_POST['username'];
$password = $_POST['password'];

// Menggunakan prepared statements untuk mencegah SQL Injection
$stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['username'] = $username;
    $_SESSION['id_user'] = $row['id_user']; // Menyimpan id_user ke session
    $_SESSION['role'] = $row['role']; // Simpan role ke session

    header("Location: http://localhost/tugasweb/page-php/dashboard.php");
    exit;
} else {
    echo "
        <script>
            alert('Login gagal! Silakan coba lagi.');
            window.location.assign('http://localhost/tugasweb/login.html');
        </script>
    ";
}

$stmt->close();
$conn->close();
?>