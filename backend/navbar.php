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
            <li><a href="/tugasweb/page-php/member/index.php">Member</a></li>
            <li><a href="/tugasweb/page-php/paket_member/index.php">Paket Member</a></li>
            <li><a href="/tugasweb/page-php/transaksi/index.php">Transaksi</a></li>
            <li><a href="/tugasweb/backend/logout.php">Logout</a></li>
        </ul>
    </nav>
<?php elseif ($role == 'member'): ?>
    <nav>
    <label for="username" id="navbar-title">KasirKu</label>
        <ul>
            <li><a href="/tugasweb/page-php/dashboard.php">Dashboard</a></li>
            <li><a href="/tugasweb/page-php/barang/index.php">Barang</a></li>
            <li><a href="#">Cart</a></li>
            <li><a href="/tugasweb/page-php/transaksi/index.php">Transaksi</a></li>
            <li><a href="/tugasweb/backend/logout.php">Logout</a></li>
        </ul>
    </nav>
<?php else: ?>
    <nav>
    <label for="username" id="navbar-title">KasirKu</label>
    <ul>
        <li><a href="/tugasweb/page-php/dashboard.php">Dashboard</a></li>
        <li><a href="/tugasweb/backend/logout.php">Logout</a></li>
    </ul>
</nav>
<?php endif; ?>