<?php
include '../../backend/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password
    $role = 'member'; // Default role

    // Menggunakan prepared statements untuk mencegah SQL Injection
    $stmt = $conn->prepare("INSERT INTO user (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        echo "
            <script>
                alert('Registrasi berhasil! Silakan login.');
                window.location.assign('http://localhost/tugasweb/login.html');
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Registrasi gagal! Silakan coba lagi.');
                window.history.back();
            </script>
        ";
    }

    $stmt->close();
    $conn->close();
}
?>