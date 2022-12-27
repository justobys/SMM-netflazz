<?php
// ===== Halaman Admin ===== //
//Count Users
$total_pengguna = mysqli_num_rows($conn->query("SELECT * FROM users"));
//Count Pesanan
$count_pesanan_sosmed = mysqli_num_rows($conn->query("SELECT * FROM pembelian_sosmed"));
$count_pesanan_pulsa = mysqli_num_rows($conn->query("SELECT * FROM pembelian_pulsa"));
$count_pesanan_pascabayar = mysqli_num_rows($conn->query("SELECT * FROM pembelian_pascabayar"));
//Total Pemesanan
$total_pemesanan_sosmed = $conn->query("SELECT SUM(harga) AS total FROM pembelian_sosmed");
$data_pesanan_sosmed = $total_pemesanan_sosmed->fetch_assoc();
$total_pemesanan_pulsa = $conn->query("SELECT SUM(harga) AS total FROM pembelian_pulsa");
$data_pesanan_pulsa = $total_pemesanan_pulsa->fetch_assoc();
$total_pemesanan_pascabayar = $conn->query("SELECT SUM(harga) AS total FROM pembelian_pascabayar");
$data_pesanan_pascabayar = $total_pemesanan_pascabayar->fetch_assoc();
//Count Deposit
$count_deposit = mysqli_num_rows($conn->query("SELECT * FROM deposit"));
//Total Deposit
$total_deposit = $conn->query("SELECT SUM(jumlah_transfer) AS total FROM deposit");
$data_deposit = $total_deposit->fetch_assoc();

// Total Profit Pembelian Sosial Media Perbulan
$ThisProfitSosmed = $conn->query("SELECT SUM(profit) AS total FROM pembelian_sosmed WHERE MONTH(pembelian_sosmed.date) = '".date('m')."' AND YEAR(pembelian_sosmed.date) = '".date('Y')."'");
$ProfitSosmed = $ThisProfitSosmed->fetch_assoc();

$ThisTotalSosmed = $conn->query("SELECT SUM(harga) AS total FROM pembelian_sosmed WHERE MONTH(pembelian_sosmed.date) = '".date('m')."' AND YEAR(pembelian_sosmed.date) = '".date('Y')."'");
$AllSosmed = $ThisTotalSosmed->fetch_assoc();

$CountProfitSosmed = mysqli_num_rows($conn->query("SELECT * FROM pembelian_sosmed WHERE MONTH(pembelian_sosmed.date) = '".date('m')."' AND YEAR(pembelian_sosmed.date) = '".date('Y')."'"));
// Data Selesai

// Total Profit Pemebelian Top Up Perbulan
$ThisProfitPulsa = $conn->query("SELECT SUM(profit) AS total FROM pembelian_pulsa WHERE MONTH(pembelian_pulsa.date) = '".date('m')."' AND YEAR(pembelian_pulsa.date) = '".date('Y')."'");
$ProfitPulsa = $ThisProfitPulsa->fetch_assoc();

$ThisTotalPulsa = $conn->query("SELECT SUM(harga) AS total FROM pembelian_pulsa WHERE MONTH(pembelian_pulsa.date) = '".date('m')."' AND YEAR(pembelian_pulsa.date) = '".date('Y')."'");
$AllPulsa = $ThisTotalPulsa->fetch_assoc();

$CountProfitPulsa = mysqli_num_rows($conn->query("SELECT * FROM pembelian_pulsa WHERE MONTH(pembelian_pulsa.date) = '".date('m')."' AND YEAR(pembelian_pulsa.date) = '".date('Y')."'"));
// Data Selesai

// Total Seluruh Saldo Pusat
$total_saldo_pusat = $conn->query("SELECT SUM(saldo) AS total FROM cek_akun");
$data_saldo_pusat = $total_saldo_pusat->fetch_assoc();

$count_saldo_pusat = mysqli_num_rows($conn->query("SELECT * FROM cek_akun"));

// Total Saldo Pusat Sosial Media
$total_saldo_pusat_sosmed = $conn->query("SELECT SUM(saldo) AS total FROM cek_akun WHERE tipe = 'SOSIAL MEDIA'");
$data_saldo_pusat_sosmed = $total_saldo_pusat_sosmed->fetch_assoc();

$count_saldo_pusat_sosmed = mysqli_num_rows($conn->query("SELECT * FROM cek_akun WHERE tipe = 'SOSIAL MEDIA'"));

// Total Saldo Pusat Top Up
$total_saldo_pusat_pulsa = $conn->query("SELECT SUM(saldo) AS total FROM cek_akun WHERE tipe = 'TOP UP'");
$data_saldo_pusat_pulsa = $total_saldo_pusat_pulsa->fetch_assoc();

$count_saldo_pusat_pulsa = mysqli_num_rows($conn->query("SELECT * FROM cek_akun WHERE tipe = 'TOP UP'"));

// ===== Data Tiket ===== //
$AllTiketUsers = $conn->query("SELECT * FROM tiket WHERE status = 'Pending'");
// ======================== //

// ===== ============ ===== //

// ===== Halaman Pengguna ===== //
// Data User
    $jumlah_order_sosmed = mysqli_num_rows($conn->query("SELECT * FROM pembelian_sosmed WHERE user = '$sess_username'"));
    $jumlah_order_pulsa = mysqli_num_rows($conn->query("SELECT * FROM pembelian_pulsa WHERE user = '$sess_username'"));

    $cek_order_sosmed = $conn->query("SELECT SUM(harga) AS total FROM pembelian_sosmed WHERE user = '$sess_username'");
    $data_order_sosmed = $cek_order_sosmed->fetch_assoc();
    $cek_order_pulsa = $conn->query("SELECT SUM(harga) AS total FROM pembelian_pulsa WHERE user = '$sess_username'");
    $data_order_pulsa = $cek_order_pulsa->fetch_assoc();
// ======================== //

// ===== Data Tiket ===== //
    $CallDBTiket = $conn->query("SELECT * FROM tiket WHERE status = 'Responded' AND user = '$sess_username'");
    $TiketAdmin = $conn->query("SELECT * FROM tiket WHERE status = 'Pending'");
// ======================== //

// ===== Data Website ===== //
    $panggil = $conn->query("SELECT * FROM setting_web WHERE id = '1'");
    $data = $panggil->fetch_assoc();
// ======================== //
?>