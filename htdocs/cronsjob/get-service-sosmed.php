<?php
require '../config.php';
   
   $cek_provider = $conn->query("SELECT * FROM provider WHERE code = 'NETFLAZZ-SMM'");
   $data_provider = $cek_provider->fetch_assoc();
   
   $cek_harga_website = $conn->query("SELECT * FROM setting_harga_untung WHERE kategori = 'WEBSITE' AND tipe = 'Sosial Media'");
   $data_harga_web = mysqli_fetch_assoc($cek_harga_website);

   $cek_harga_api = $conn->query("SELECT * FROM setting_harga_untung WHERE kategori = 'API' AND tipe = 'Sosial Media'");
   $data_harga_api = mysqli_fetch_assoc($cek_harga_api);
   
   $p_apikey = $data_provider['api_key'];
   $p_link = $data_provider['link'];
   
   $harga_web = $data_harga_web['harga'];
   $harga_api = $data_harga_api['harga'];
   
   $postdata = "api_key=$p_apikey&action=layanan";
   
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
   print_r ($json_result);
   if ($json_result['status'] == false ) {
      echo $json_result['data']['pesan'];
   } else {
   
      $i = 0;
      $data = $json_result['data'];
      while ( $i < count($json_result['data']) ) {
         $sid = $data[$i]['sid'];
         $kategori = $data[$i]['kategori'];
         $layanan = $data[$i]['layanan'];
         $min = $data[$i]['min'];
         $max = $data[$i]['max'];
         $harga = $data[$i]['harga'];
         $catatan = $data[$i]['catatan'];
         $i++;
         
         $price = $harga + $harga_web;
         $price_api = $harga + $harga_api;
         
         $cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE layanan = '$layanan' AND server = 's1'");
         $data_layanan = $cek_layanan->fetch_assoc();
         
         if ( $cek_kategori->num_rows > 0 ) {
            echo "Data Sudah ada di Database<br><br>";
         } else {
            $insert = $conn->query("INSERT INTO layanan_sosmed VALUES ('', '$sid', '$kategori', '$layanan', '$catatan', '$min', '$max', '$price', '$price_api', 'Aktif', '$sid', 'NETFLAZZ-SMM', 'Sosial Media', 's1')");
            if ( $insert == TRUE ) {
            
               echo "<font color='green'>Success Insert Layanan</font><br>PID : $sid <br>KATEGORI : $kategori <br>LAYANAN : $layanan <br>MIN / MAX : $min / $max <br>Harga Asli : $harga <br> Harga Web / API : Rp $price / Rp $price_api <br>Catatan : $catatan <br><br>";
               
            } else {
               echo "Gagal memasukan data";
            }
         }
      }
      
   }