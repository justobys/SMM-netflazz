<?php
   require_once("../config.php");
    
    $check_provider = $conn->query("SELECT * FROM provider_pulsa WHERE code = 'NETFLAZZ-PPOB'");
    $data_provider = mysqli_fetch_assoc($check_provider);
    $cek_api = $conn->query("SELECT * FROM api WHERE id_api='1'");
    $data_api = $cek_api->fetch_assoc();

    $p_apikey = $data_provider['api_key'];
    $p_apilink = $data_api['profile'];

    $api_postdata = "api_key=$p_apikey&action=profile";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $p_apilink);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $chresult = curl_exec($ch);
    curl_close($ch);
    $json_result = json_decode($chresult, true);

$indeks=0; 
$i = 1;
// get data service
while($indeks < count($json_result['data'])) {

$sisa_saldo = $json_result['data'][$indeks]['saldo'];
$indeks++; 
$i++;

        $cek_akun = $conn->query("SELECT * FROM cek_akun WHERE provider = 'NETFLAZZ-PPOB'");
        $data_akun = mysqli_fetch_assoc($cek_akun);
        if (mysqli_num_rows($cek_akun) > 0) {
        $update = $conn->query("UPDATE cek_akun SET saldo = '$sisa_saldo', date = '$date', time = '$time' WHERE provider = 'NETFLAZZ-PPOB'");
            echo "<br>Data Informasi Akun Top Up Sudah Ada Di Database.<br>";
            echo ($update == true) ? '<font color="green">Update Sukses!</font>' : '<font color="red">Update Gagal: '.mysqli_error($conn).'</font><br />';
        } else {
            
$insert = $conn->query("INSERT INTO cek_akun VALUES ('','$sisa_saldo','$date','$time','TOP UP','NETFLAZZ-PPOB')");//Memasukan Kepada Database (OPTIONAL)
if ($insert == TRUE) {
echo"===============<br>Berhasil Menampilkan Data Informasi Akun Top Up<br><br>Nama Pengguna : $nama_pengguna<br>Sisa Saldo : $sisa_saldo<br>Tipe : SALDO<br><br>===============<br>";
} else {
    echo "Gagal Menampilkan Data Informasi Akun Top Up.<br />";
    
}
}
}
?>