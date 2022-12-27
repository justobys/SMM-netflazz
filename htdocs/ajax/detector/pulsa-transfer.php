<?php
require("../../config.php");

$operator = $conn->real_escape_string(filter($_POST['target']));
$link2=	substr($operator,0,4);
	if(($link2 == '0811') OR ($link2 == '0812') OR ($link2 == '0813') OR ($link2 == '0821') OR ($link2 == '0822') OR ($link2 == '0823') OR ($link2 == '0851') OR ($link2 == '0852') OR ($link2 == '0853')){
    $jenis_nomor = 'Pulsa Transfer TELKOMSEL';
     $jenis_nomor2 = 'TSEL';
} else if(($link2 == '0817') OR ($link2 == '0818') OR ($link2 == '0819') OR ($link2 == '0859') OR ($link2 == '0877') OR ($link2 == '0878')){
    $jenis_nomor = 'Pulsa Transfer XL';
    $jenis_nomor2 = 'XL';
} else if(($link2 == '0896') OR ($link2 == '0897') OR ($link2 == '0898') OR ($link2 == '0899') OR ($link2 == '0895')){
    $jenis_nomor = 'Pulsa Transfer TRI';
     $jenis_nomor2 = 'THREE';
} else if(($link2 == '0881') OR ($link2 == '0882') OR ($link2 == '0883') OR ($link2 == '0884') OR ($link2 == '0885') OR ($link2 == '0886') OR ($link2 == '0887') OR ($link2 == '0888') OR ($link2 == '0889') OR ($link2 == '0895') OR ($link2 == '0896') OR ($link2 == '0897') OR ($link2 == '0898') OR ($link2 == '0899')){
    $jenis_nomor = 'SMARTFREN';
    $jenis_nomor2 = 'Pulsa Transfer SMART';
} else if(($link2 == '0998') OR ($link2 == '0999')){
    $jenis_nomor = 'BOLT';
} else if(($link2 == '0828')){
    $jenis_nomor = 'CERIA';
} else if(($link2 == '0838') OR ($link2 == '0831') OR ($link2 == '0832') OR ($link2 == '0833')){
    $jenis_nomor = 'Pulsa Transfer AXIS';
    $jenis_nomor2 = 'AXIS';
} else if(($link2 == '0855') OR ($link2 == '0856') OR ($link2 == '0857') OR ($link2 == '0858') OR ($link2 == '0814') OR ($link2 == '0815') OR ($link2 == '0816')){
    $jenis_nomor = 'Pulsa Transfer INDOSAT';
     $jenis_nomor2 = 'ISAT';
}else{
    $jenis_nomor="tidak ada";$jenis_nomor2 = 'tidak ada';
}

$check_service = $conn->query("SELECT * FROM layanan_Pulsa Transfer WHERE operator = '$jenis_nomor' AND status = 'Normal' ORDER BY harga ASC");
?>
	<?php
	while ($data_service = mysqli_fetch_assoc($check_service)) {
	    ?>
	    <label class="col-12 alert alert-primary bd bd-primary" style="cursor: pointer;">
		<div class="rdiobox">
			<input type="radio" name="service" value="<?php echo $data_service['service_id'];?>"><span><b> <?= $data_service['layanan']  ?></b></span>
		</div>
		<div class="mg-t-10 bd bd-primary pd-10">
			<br><span><b> Harga :</b> Rp <?= number_format($data_service['harga'],0,',','.') ?></span>
		</div>
	</label>
<?php
}