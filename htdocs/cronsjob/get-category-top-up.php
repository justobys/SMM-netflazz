<?php
require '../config.php';
   
   $cek_provider = $conn->query("SELECT * FROM provider_pulsa WHERE code = 'NETFLAZZ-PPOB'");
   $data_provider = $cek_provider->fetch_assoc();
   
   $p_apikey = $data_provider['api_key'];
   $p_link = $data_provider['link'];
   
   $postdata = "api_key=".$p_apikey."&action=layanan";
   
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $p_link);
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   $chresult = curl_exec($ch);
   // echo $chresult;
   curl_close($ch);
   $json_result = json_decode($chresult, true);
   
   if ( $json_result['status'] == false ) {
      echo $json_result['data']['pesan'];
   } else {
   
      $i = 0;
      $data = $json_result['data'];
      while ( $i < count($json_result['data']) ) {
         $tipe = $data[$i]['tipe'];
         $kategori = $data[$i]['operator'];
         $i++;
      
         $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE kode = '$kategori' AND server = '$tipe'");
         $data_kategori = $cek_kategori->fetch_assoc();
         
         if ( $cek_kategori->num_rows > 0 ) {
            echo "Data Sudah ada di Database<br><br>";
         } else {
            $insert = $conn->query("INSERT INTO kategori_layanan VALUES ('', '$kategori', '$kategori', 'Top Up', '$tipe')");
            if ( $insert == TRUE ) {
               echo "<font color='green'>Success Insert Kategori</font><br> $tipe || $kategori <br><br>";
            } else {
               echo "Gagal memasukan data";
            }
         }
      }
      
   }