<?php
session_start();
include '../../backend/koneksi.php';

if (isset($_POST['buat_transaksi'])) {
    // Inisialisasi variabel transaksi
    $id_user = $_SESSION['id_user'];
    $total_harga = 0;

    // Hitung total harga dari cart
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total_harga += $item['harga'] * $item['jumlah'];
        }
    }

    // Masukkan data transaksi ke tabel transaksi
    $sql_transaksi = "INSERT INTO transaksi (id_user, total, tanggal_transaksi) VALUES (?, ?, NOW())";
    $stmt_transaksi = $conn->prepare($sql_transaksi);
    $stmt_transaksi->bind_param("id", $id_user, $total_harga);

    if ($stmt_transaksi->execute()) {
        $id_transaksi = $stmt_transaksi->insert_id; // Dapatkan ID transaksi terakhir

        // Masukkan detail transaksi
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $id_barang = $item['id_barang'];
                $kuantitas = $item['jumlah'];
                $harga_satuan = $item['harga'];
            
                $sql = "INSERT INTO detail_transaksi (id_transaksi, id_barang, kuantitas, harga_satuan) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iiid", $id_transaksi, $id_barang, $kuantitas, $harga_satuan);
                $stmt->execute();
            }            
        }

        // Kosongkan session cart setelah transaksi berhasil
        unset($_SESSION['cart']);

        echo "<script>
                alert('Transaksi berhasil!');
                window.location.href = '/tugasweb/page-php/cart';
              </script>";
    } else {
        echo "<script>
                alert('Terjadi kesalahan saat memproses transaksi.');
                window.history.back();
              </script>";
    }
}
?>