<?php
require("../config.php");
require("../lib/bca-class.php");

$cek_akun = $conn->query("SELECT * FROM bca");
$data_akun = mysqli_fetch_assoc($cek_akun);

$user_id = $data_akun['user_id'];
$password = $data_akun['password'];

$parser = new IbParser();

$bank   = "BCA";
$user   = "$user_id";
$pass   = "$password";
$res = [];

$transactions = $parser->getTransactions( $bank, $user, $pass );
$balance = $parser->getBalance( $bank, $user, $pass );

if( !$transactions ) {
  $res['result'] = true;
  $res['total_transaksi'] = 0;
  $res['saldo'] = number_format($balance,0,'','');
  $res['data'] = [];
} else if ( !$transactions ) {
  $res['result'] = true;
  $res['total_transaksi'] = count($transactions);
  $res['saldo'] = number_format($balance,0,'','');
}

foreach ($transactions as $val) {
$tanggal = $val[0];
$keterangan = $val[1];
$tipe = $val[2];
$total = number_format($val[3],0,'','');

    $cek_data = $conn->query("SELECT * FROM mutasi_bca WHERE keterangan = '$keterangan'");
    $data_bank = mysqli_fetch_assoc($cek_data);
    if($tipe == 'CR') {
    if (mysqli_num_rows($cek_data) > 0) {
        echo "<br>Data Mutasi BCA Sudah Ada Di Database<br>";
    } else {

    $insert = $conn->query("INSERT INTO mutasi_bca VALUES ('', '$tipe','$keterangan','$total','$tanggal','UNREAD','BCA')");
    $insert = $conn->query("UPDATE mutasi SET status = 'Dana Sudah Masuk', status_aksi = 'Belum Dikonfirmasi' WHERE jumlah = '$total'");
    if ($insert == TRUE) {
        echo "===============<br>Data Mutasi BCA Berhasil Di Tambahkan<br><br>Tipe : $tipe<br>Deskripsi : $keterangan<br>Jumlah : $total<br>Tanggal : $tanggal<br>===============<br>";
    } else {
        echo "Gagal Menampilkan Data Mutasi BCA.<br>";
    }
}
    } else {
        echo '<b><font color="red">GAGAL! -></font> MUTASI UANG KELUAR</b><br>';
    }
}
?>