<?php
require_once "config.php";
require_once "EnvayaSMS.php";
require_once "../config.php";

    if($action->from == '858' AND preg_match("/Anda mendapatkan penambahan pulsa/i", $pesan_isi)) {
         $pesan_isi = $action->message;
         $CheckHistory = $conn->query("SELECT * FROM deposit WHERE tipe = 'Transfer Pulsa' AND provider = 'TELKOMSEL' AND status = 'Pending' AND date = '$date'");
         if (mysqli_num_rows($CheckHistory) == 0) {
                error_log("Riwayat Top Up Tidak Tersedia");
         } else {          
             while($DataDeposit = mysqli_fetch_assoc($CheckHistory)) {
                        $kode = $DataDeposit['kode_deposit'];
                        $no_pegirim = $DataDeposit['pengirim'];
                        $user = $DataDeposit['username'];
                        $saldo = $DataDeposit['get_saldo'];
                        $this_date = $DataDeposit['date'];
                        $jumlah_transfer = $DataDeposit['jumlah_transfer'];
                        $tipe = $DataDeposit['metode_isi_saldo'];
                        $cekpesan = preg_match("/Anda mendapatkan penambahan pulsa Rp $jumlah_transfer dari nomor $no_pegirim tgl $this_date/i", $pesan_isi);
         
                        if($cekpesan == true) {                              
                            $update_history_topup =   $conn->query("UPDATE mutasi SET status = 'Dana Sudah Masuk' WHERE kode_deposit = '$kode'");
       
                            if($update_history_topup == TRUE) {
                                error_log("Berhasil #$kode");
                            } else {
                                error_log("System Error");
                            }
                        } else {
                            error_log("Data Transfer Pulsa Tidak Ada");
                        }
                  }
            }
      }