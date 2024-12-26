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
    <title>Tambah User</title>

    <link rel="stylesheet" href="../../backend/style.css">
</head>
<body>

    <!-- Navbar -->
    <?php include '../../backend/navbar.php'; ?>

    <div class="container">
        <h1>Tambah User : <?php echo $username; ?>!</h1>
            <?php
            include '../../backend/koneksi.php';
            if (isset($_POST['submit'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $role = $_POST['role'];

                $sql = "INSERT INTO user(username,password,role) VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("sss", $username, $password, $role);
                    if ($stmt->execute()) {
                        echo "<script>
                                alert('User berhasil ditambahkan!');
                                window.location.href = '/tugasweb/page-php/user';
                            </script>";
                    } else {
                        echo "<script>
                                alert('Gagal menambahkan user!');
                                window.history.back();
                            </script>";
                    }
                } else {
                    $conn->close();
                }
            }
            ?>
            <form action="./adduser.php" method="POST">
                <!-- Input untuk username -->
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                <br><br>

                <!-- Input untuk password -->
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                <br><br>

                <!-- Select untuk role -->
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="" selected disabled>Pilih role</option>
                    <option value="admin">Admin</option>
                    <option value="member">Member</option>
                    <option value="guest">Guest</option>
                </select>
                <br><br>

                <!-- Tombol submit -->
                <button type="submit" name="submit">Tambah User</button>
            </form>
        </div>

    <!-- Footer -->
    <?php include '../../backend/footer.php'; ?>

</body>

</html>