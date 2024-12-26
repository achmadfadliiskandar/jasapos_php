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

include '../../backend/koneksi.php';

// Ambil ID dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Periksa apakah ID valid
if ($id > 0) {
    // Query untuk mendapatkan data berdasarkan ID
    $sql = "SELECT * FROM user WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah data ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Ambil data pengguna
    } else {
        echo "<script>
                alert('Data tidak ditemukan!');
                window.location.href = '/tugasweb/dashboard.php';
              </script>";
        exit;
    }
    $stmt->close();
} else {
    echo "<script>
            alert('ID tidak valid!');
            window.location.href = '/tugasweb/dashboard.php';
          </script>";
    exit;
}

// Proses update data
if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Update query
    $updateSql = "UPDATE user SET username = ?, password = ?, role = ? WHERE id_user = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sssi", $username, $password, $role, $id);

    if ($updateStmt->execute()) {
        echo "<script>
                alert('Data berhasil diperbarui!');
                window.location.href = '/tugasweb/page-php/user';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data!');
                window.history.back();
              </script>";
    }
    $updateStmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../../backend/style.css">
</head>

<body>
    <?php include '../../backend/navbar.php'; ?>
    <h1>Edit User</h1>
    <div class="container">
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            <br><br>

            <label for="password">Password:</label>
            <input type="text" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" required>
            <br><br>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="member" <?php echo $user['role'] === 'member' ? 'selected' : ''; ?>>Member</option>
                <option value="guest" <?php echo $user['role'] === 'guest' ? 'selected' : ''; ?>>Guest</option>
            </select>
            <br><br>

            <button type="submit" name="update">Update</button>
            <a href="../user/index.php">Back</a>
        </form>
    </div>
    <!-- Footer -->
    <?php include '../../backend/footer.php'; ?>
</body>

</html>