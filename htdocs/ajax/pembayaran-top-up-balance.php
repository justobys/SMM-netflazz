<?php
require("../config.php");

if (isset($_POST['provider'])) {
    if($_POST['provider'] == 'Payment Gateway'){
        $privatekey = 'Ws60b-r1Dr7-aWQro-xeu6U-g7FFM';
        $apiKey = 'X3cWTtFr60lecOjvBlfj4EFBdlYOFXexSKogfQmx';

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_FRESH_CONNECT     => true,
        CURLOPT_URL               => "https://tripay.co.id/api/merchant/payment-channel",
        CURLOPT_RETURNTRANSFER    => true,
        CURLOPT_HEADER            => false,
        CURLOPT_HTTPHEADER        => array("Authorization: Bearer ".$apiKey),
        CURLOPT_FAILONERROR       => false
        )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        
        $responseDecode = json_decode($response);
        
        if(!empty($err)){
            return "Data Tidak Tersedia";
        }else{
            
        ?>
            <option value="0">Pilih...</option>
        <?php
            foreach($responseDecode->data as $data){
        ?>
                <option value="<?=$data->code?>"><?=$data->name?></option>
        <?php
            }
        }
    }else{
        $post_provider = $conn->real_escape_string($_POST['provider']);
    	$cek_metode = $conn->query("SELECT * FROM metode_depo WHERE id = '$post_provider' ORDER BY id ASC");
    	?>
    	<option value="0">Pilih...</option>
    	<?php
    	while ($data_metode = $cek_metode->fetch_assoc()) {
    	?>
    	<option value="<?php echo $data_metode['id'];?>"><?php echo $data_metode['provider'];?> (<?php echo $data_metode['jenis'];?>)</option>
    	<?php
    	}
    }

} else {
?>
<option value="0">Error.</option>
<?php
}