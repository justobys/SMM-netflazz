<?php
require '../config.php';
   
   $cek_provider = $conn->query("SELECT * FROM provider_pulsa WHERE code = 'NETFLAZZ-PPOB'");
   $data_provider = $cek_provider->fetch_assoc();
   
   $cek_harga_website = $conn->query("SELECT * FROM setting_harga_untung WHERE kategori = 'WEBSITE' AND tipe = 'Top Up'");
   $data_harga_web = mysqli_fetch_assoc($cek_harga_website);

   $cek_harga_api = $conn->query("SELECT * FROM setting_harga_untung WHERE kategori = 'API' AND tipe = 'Top Up'");
   $data_harga_api = mysqli_fetch_assoc($cek_harga_api);
   
   $p_apikey = $data_provider['api_key'];
   $p_link = $data_provider['link'];
   
   $harga_web = $data_harga_web['harga'];
   $harga_api = $data_harga_api['harga'];
   
   $postdata = "api_key=ing2K68EpR0DR61r7K7InAefpG0SxiuX&action=layanan";
   
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

      $i = 0;
      $data = $json_result['data'];
      while ( $i < count($json_result['data']) ) {
         $sid = $data[$i]['sid'];
         $kategori = $data[$i]['operator'];
         $layanan = $data[$i]['layanan'];
         $tipe = $data[$i]['tipe'];
         $status = $data[$i]['status'];
         $harga = $data[$i]['harga'];
         $catatan = $data[$i]['catatan'];
         $i++;
         
         $price = $harga + $harga_web;
         $price_api = $harga + $harga_api;
         
         $cek_layanan = $conn->query("SELECT * FROM layanan_pulsa WHERE layanan = '$layanan'");
         $data_layanan = $cek_layanan->fetch_assoc();
         
         if ( $cek_kategori->num_rows > 0 ) {
            echo "Data Sudah ada di Database<br><br>";
         } else {
            $insert = $conn->query("INSERT INTO layanan_pulsa VALUES ('', '$sid', '$sid', '$kategori', '$layanan', '$catatan', '$price', '$price_api', 'Ya', '$status', 'NETFLAZZ-PPOB', '$tipe', 'Top Up')");
            if ( $insert == TRUE ) {
            
               echo "<font color='green'>Success Insert Layanan</font><br>PID : $sid <br>KATEGORI : $kategori <br>LAYANAN : $layanan <br>MIN / MAX : $min / $max <br>Harga Asli : $harga <br> Harga Web / API : Rp $price / Rp $price_api <br>Catatan : $catatan <br><br>";
               
            } else {
               echo "Gagal memasukan data";
            }
         }
      }
      ?>