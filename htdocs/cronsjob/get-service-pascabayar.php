<?php
require_once("../config.php");

    $check_provider = $conn->query("SELECT * FROM provider_pulsa WHERE code = 'NETWORK'");
    $data_provider = mysqli_fetch_assoc($check_provider);

    $p_apiid = $data_provider['api_id'];
    $p_apikey = $data_provider['api_key'];

    $url = "https://netflazz.com/api/pulsa";
    $sign = md5("$p_apiid+$p_apikey+pricelist");

    $data = array( 
        'cmd' => "pasca",
	    'username' => $p_apiid,
	    'sign' => $sign
    );
    $header = array(
    'Content-Type: application/json',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    // echo $response;
    // die;
    $result = json_decode($response);
    // print_r($result);

$indeks=0; 
$i = 1;
// get data service
foreach($result->data as $data) {

$sid = $data->buyer_sku_code;
$category = $data->brand;
$type = $data->category;
$service = $data->product_name;
$ht_status = $data->buyer_product_status;
$indeks++; 
$i++;
// end get data service 

		if ($ht_status == true) {
			$status = "Normal";
		} else if ($ht_status == false) {
			$status = "Gangguan";
		}

		$check_services = $conn->query("SELECT * FROM layanan_pascabayar WHERE service_id = '$sid' AND provider = 'NETWORK'");
        $data_services = mysqli_fetch_assoc($check_services);
        if (mysqli_num_rows($check_services) > 0) {
            echo "<br>Layanan Sudah Ada Di Database => $service | $sid \n <br />";
        } else {

		//INSERT KATEGORI
		$cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE kode = '$category' AND server = '$type'");
		if (mysqli_num_rows($cek_kategori) == 0) {
           $input_kategori = $conn->query("INSERT INTO kategori_layanan VALUES ('','$category','$category','Pascabayar','$type')");
            echo "<br>Kategori Sudah Ada Di Database => $category \n <br />";
		} else {

		}

$insert = $conn->query("INSERT INTO layanan_pascabayar VALUES ('', '$sid', '$sid', '$category', '$service', '$status', 'NETWORK', '$type', 'PASCABAYAR')");
if ($insert == TRUE) {
echo"===============<br>Layanan Pascabayar Berhasil Di Tambahkan<br><br>ID Layanan : $sid<br>Kategori : $category<br>Nama Layanan : $service<br>Tipe : $type<br>Status : $status<br>===============<br>";
} else {
    echo "Gagal Menampilkan Data Layanan Pascabayar.<br />";

}
}
}
?>