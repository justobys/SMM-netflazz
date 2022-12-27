<?php 
session_start();
require("../config.php");
$tripay_merchant_ref = $_GET['tripay_merchant_ref'];
$tripay_status = $_GET['tripay_status'];
$tripay_reference = $_GET['tripay_reference'];
$tripay_signature = $_GET['tripay_signature'];
$q_transaksi = $conn->query("SELECT * FROM users u inner join deposit d on d.username = u.username WHERE d.id = '$tripay_merchant_ref'");
$transaksi = mysqli_fetch_assoc($q_transaksi);
if($tripay_merchant_ref != '' && $tripay_status != '' && $tripay_reference != '' && $tripay_signature != ''){
    if($tripay_status == 'PAID'){
       
        $saldo = $transaksi['get_saldo'];
        $tipe = $transaksi['metode_isi_saldo']; 
        $username = $transaksi['username'];
        $date = $transaksi['date'];
        $time = $transaksi['time'];
        $kode_deposit = $transaksi['kode_deposit']; 
         $conn->query("UPDATE deposit set status = 1 WHERE id = '$tripay_merchant_ref'");
        $conn->query("UPDATE users set $tipe = $tipe + $saldo WHERE username = '$username'");
        echo "INSERT INTO history_saldo VALUES ('', '$username', 'Saldo', 'Penambahan Saldo', '$saldo', 'Mendapatkan Saldo Isi Saldo Via ".$transaksi['tipe']." ".$transaksi['provider']." Dengan Kode Isi Saldo : $tripay_merchant_ref', '$date', '$time')";
       $conn->query("INSERT INTO history_saldo VALUES ('', '$username', 'Saldo', 'Penambahan Saldo', '$saldo', 'Mendapatkan Saldo Isi Saldo Via ".$transaksi['tipe']." ".$transaksi['provider']." Dengan Kode Isi Saldo : $tripay_merchant_ref', '$date', '$time')");
       $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Data Deposit Berhasil Di Update.');
        $conn->query("INSERT INTO tes values('','ariyozi')");  
         header("Location: " . $config['web']['url'] . "deposit-balance/invoice?kode_deposit=".$transaksi['kode_deposit']);
         die();
    }else{
          header("Location: " . $config['web']['url'] . "deposit-balance/invoice?kode_deposit=".$transaksi['kode_deposit']);
          die();
    }
}else{
     header("Location: " . $config['web']['url'] . "deposit-balance/invoice?kode_deposit=".$transaksi['kode_deposit']);
     die();
}
// echo "twentytwo.id";

