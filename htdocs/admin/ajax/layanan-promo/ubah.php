<?php
session_start();
require '../../../config.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	if (!isset($_SESSION['user'])) {
			exit("Anda Tidak Memiliki Akses!");
	}
	if (!isset($_GET['id'])) {
		exit("Anda Tidak Memiliki Akses!");
	} 		
$get_idlayanan = $conn->real_escape_string(filter($_GET['id']));
$cek_layanan = $conn->query("SELECT * FROM promo_layanan WHERE id = '$get_idlayanan'");
$data_layanan = $cek_layanan->fetch_assoc();
	if (mysqli_num_rows($cek_layanan) == 0) {
		exit("Data Tidak Ditemukan");
	} else {
?>
		    			<div class="row">
		    				<div class="col-md-12">
								<div class="form-group">
									<label class="col-md-12 control-label">ID Layanan</label>
									<div class="col-md-12">
                                        <input type="number" name="id" class="form-control" value="<?php echo $data_layanan['id']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Kategori</label>
                                    <div class="col-md-12">
                                        <input type="text" name="kategori" class="form-control" value="<?php echo $data_layanan['kategori']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Nama Layanan</label>
                                    <div class="col-md-12">
                                        <input type="text" name="layanan" class="form-control" value="<?php echo $data_layanan['layanan']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Harga Normal</label>
                                    <div class="col-md-12">
                                        <input type="number" name="harga_normal" class="form-control" value="<?php echo $data_layanan['harga_normal']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Harga Promo</label>
                                    <div class="col-md-12">
                                        <input type="number" name="harga_promo" class="form-control" value="<?php echo $data_layanan['harga_promo']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Tipe</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="tipe">
                                            <option value="<?php echo $data_layanan['tipe']; ?>"><?php echo $data_layanan['tipe']; ?></option>
                                            <option value="Sosial Media">Sosial Media</option>
                                            <option value="Top Up">Top Up</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning" name="ubah"><i class="fa fa-pencil-alt"></i> Ubah</button>
                                </div>
                            </div>
                    	</div>
<?php 
}
} else {
exit("Anda Tidak Memiliki Akses!");
}