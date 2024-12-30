<?php
session_start();

// Tambahkan 1 ke jumlah barang
if (isset($_POST['increment_cart'])) {
    $index = $_POST['index'];

    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['jumlah'] += 1;
    }
}

// Redirect kembali ke halaman cart
header("Location: /tugasweb/page-php/cart");
exit;
?>
