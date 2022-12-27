<?php
require("../config.php");

if (isset($_POST['layanan'])) {
	$post_layanan = $conn->real_escape_string(filter($_POST['layanan']));
	$cek_layanan = $conn->query("SELECT * FROM layanan_pulsa WHERE service_id = '$post_layanan' AND status = 'Normal'");
	if (mysqli_num_rows($cek_layanan) == 1) {
		$data_layanan = mysqli_fetch_assoc($cek_layanan);
	?>

							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Deskripsi</label>
								<div class="col-lg-9 col-xl-6">
								    <div class="alert alert-primary alert-dismissible" role="alert" type="text" class="form-control" placeholder="" value="Keterangan" readonly=""><?php echo $data_layanan['deskripsi']; ?></div>
							    </div>
							</div>
<?php
} else {
?>
							<div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
								</button>
								<i class="mdi mdi-block-helper"></i>
								<b>Gagal :</b> Layanan Tidak Ditemukan
							</div>
<?php
}
} else {
?>
							<div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
								</button>
								<i class="mdi mdi-block-helper"></i>
								<b>Gagal : </b> Terjadi Kesalahan, Silahkan Hubungi Admin.
							</div>
<?php
}