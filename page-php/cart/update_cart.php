<?php
session_start();

if (isset($_POST['update_cart'])) {
    $index = $_POST['index'];
    $jumlah = $_POST['jumlah'];

    // Update jumlah barang
    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['jumlah'] = $jumlah;
    }

    // Redirect kembali ke halaman dashboard
    header("Location: /tugasweb/page-php/cart");
    exit;
}
?>