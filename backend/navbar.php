<?php 
// Mendapatkan role pengguna
$role = $_SESSION['role'];
?>
<!-- bagian role session -->

<?php if ($role == 'admin'): ?>
    <nav>
        <label for="username" id="navbar-title">KasirKu</label>
        <ul>
            <li><a href="/tugasweb/page-php/dashboard.php">Dashboard</a></li>
            <li><a href="/tugasweb/page-php/user/index.php">User</a></li>
            <li><a href="/tugasweb/page-php/barang/index.php">Barang</a></li>
            <li><a href="#">Member</a></li>
            <li><a href="#">Paket Member</a></li>
            <li><a href="#">Transaksi</a></li>
            <li><a href="/tugasweb/backend/logout.php">Logout</a></li>
        </ul>
    </nav>
<?php elseif ($role == 'member'): ?>
    <nav>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Barang</a></li>
            <li><a href="#">Cart</a></li>
            <li><a href="#">Transaksi</a></li>
            <li><a href="/tugasweb/backend/logout.php">Logout</a></li>
        </ul>
    </nav>
<?php else: ?>
    <nav>
    <ul>
        <li><a href="#">Dashboard</a></li>
        <li><a href="/tugasweb/backend/logout.php">Logout</a></li>
    </ul>
</nav>
<?php endif; ?>