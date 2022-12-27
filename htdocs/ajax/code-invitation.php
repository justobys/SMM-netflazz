<?php
require("../config.php");

if (isset($_POST['level'])) {
	$post_level = $conn->real_escape_string(filter($_POST['level']));
	$cek_pendaftaran = $conn->query("SELECT * FROM harga_kode_undangan WHERE level = '$post_level'");
	if (mysqli_num_rows($cek_pendaftaran) == 1) {
		$data_pendaftaran = mysqli_fetch_assoc($cek_pendaftaran);
	?>

							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Harga Kode Undangan</label>
								<div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text text-primary">Rp</span></div>
                                        <input type="number" class="form-control" placeholder="0" value="<?php echo number_format($data_pendaftaran['harga'],0,',','.'); ?>" readonly="">
                                    </div>
							    </div>
							</div>
							<!--<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Saldo Sosial Media</label>
								<div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text text-primary">Rp</span></div>
                                        <input type="number" class="form-control" placeholder="0" value="<?php echo number_format($data_pendaftaran['saldo_sosmed'],0,',','.'); ?>" readonly="">
                                    </div>
							    </div>
							</div>-->
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Saldo</label>
								<div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text text-primary">Rp</span></div>
                                        <input type="number" class="form-control" placeholder="0" value="<?php echo number_format($data_pendaftaran['saldo_top_up'],0,',','.'); ?>" readonly="">
                                    </div>
							    </div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Keterangan</label>
								<div class="col-lg-9 col-xl-6">
								    <textarea type="text" class="form-control" placeholder="Kode Undangan Baru Dengan Level <?php echo $data_pendaftaran['level']; ?> Akan Mengurangi Saldo Anda Sebesar Rp <?php echo number_format($data_pendaftaran['harga'],0,',','.'); ?>" value="Keterangan" readonly=""></textarea>
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