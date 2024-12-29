<?php
session_start();

if (isset($_POST['remove_cart'])) {
    $index = $_POST['index'];

    // Menghapus item dari cart
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        // Reindex array
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    // Redirect kembali ke halaman dashboard
    header("Location: /tugasweb/page-php/cart");
    exit;
}
?>