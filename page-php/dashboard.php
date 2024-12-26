<?php
session_start();

// Redirect ke halaman login jika belum login
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/tugasweb/login.html");
    exit;
}

// Mendapatkan role pengguna
$username = htmlspecialchars($_SESSION['username']);
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="../backend/style.css">
</head>

<body>

    <!-- Navbar -->
    <?php include '../backend/navbar.php'; ?>

    <div class="container">
        <h1>Welcome <?php echo $username; ?>!</h1>
        
        <?php if ($role == 'admin'): ?>
            <h2>Admin Dashboard</h2>
            <p>Ini adalah fitur khusus admin:</p>

            <!-- batas admin-member -->
        <?php elseif ($role == 'member'): ?>
            <h2>User Dashboard</h2>
            <p>Ini adalah fitur untuk member yang telah berlangganan dengan kami:</p>
            <!-- batas member-guest -->
             
        <?php else: ?>
            <h2>Guest Dashboard</h2>
            <p>Selamat datang, Anda masuk sebagai tamu.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include '../backend/footer.php'; ?>

</body>

</html>