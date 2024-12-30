<?php
session_start();

// Mengurangi jumlah barang
if (isset($_POST['decrement_cart'])) {
    $index = $_POST['index'];

    if (isset($_SESSION['cart'][$index])) {
        // Cek jika jumlah lebih besar dari 1 sebelum mengurangi
        if ($_SESSION['cart'][$index]['jumlah'] > 1) {
            $_SESSION['cart'][$index]['jumlah'] -= 1;
        }
    }
}

// Redirect kembali ke halaman cart
header("Location: /tugasweb/page-php/cart");
exit;
?>