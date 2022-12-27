<?php
session_start();
require '../../../config.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	if (!isset($_SESSION['user'])) {
			exit("Anda Tidak Memiliki Akses!");
	}
	if (!isset($_GET['id_layanan'])) {
		exit("Anda Tidak Memiliki Akses!");
	} 		
$get_idlayanan = $conn->real_escape_string(filter($_GET['id_layanan']));
$cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE id = '$get_idlayanan'");
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
                                        <input type="number" name="sid" class="form-control" value="<?php echo $data_layanan['service_id']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">ID Provider</label>
                                    <div class="col-md-12">
                                        <input type="text" name="pid" class="form-control" value="<?php echo $data_layanan['provider_id']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Kategori</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="kategori">
                                            <option value="<?php echo $data_layanan['kategori']; ?>"><?php echo $data_layanan['kategori']; ?> (Terpilih)</option>
                                            <?php
                                            $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE tipe = 'Sosial Media' ORDER BY nama ASC");
                                            while ($data_kategori = $cek_kategori->fetch_assoc()) {
                                            ?>
                                            <option value="<?php echo $data_kategori['kode']; ?>"><?php echo $data_kategori['kode']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Nama Layanan</label>
                                    <div class="col-md-12">
                                        <input type="text" name="layanan" class="form-control" value="<?php echo $data_layanan['layanan']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Keterangan</label>
                                    <div class="col-md-12">
                                        <textarea name="catatan" class="form-control"><?php echo $data_layanan['catatan']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Minimal Pemesanan</label>
                                    <div class="col-md-12">
                                        <input type="number" name="min" class="form-control" value="<?php echo $data_layanan['min']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Maksimal Pemesanan</label>
                                    <div class="col-md-12">
                                        <input type="number" name="max" class="form-control" value="<?php echo $data_layanan['max']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Harga WEB/1000</label>
                                    <div class="col-md-12">
                                        <input type="number" name="harga" class="form-control" value="<?php echo $data_layanan['harga']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Harga API/1000</label>
                                    <div class="col-md-12">
                                        <input type="number" name="harga_api" class="form-control" value="<?php echo $data_layanan['harga_api']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Status</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="status">
                                            <option value="<?php echo $data_layanan['status']; ?>"><?php echo $data_layanan['status']; ?> (Terpilih)</option>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Provider</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="provider">
                                            <option value="<?php echo $data_layanan['provider']; ?>"><?php echo $data_layanan['provider']; ?> (Terpilih)</option>
                                            <?php
                                            $cek_provider = $conn->query("SELECT * FROM provider ORDER BY id ASC");
                                            while ($data_provider = $cek_provider->fetch_assoc()) {
                                            ?>
                                            <option value="<?php echo $data_provider['code']; ?>"><?php echo $data_provider['code']; ?></option>
                                            <?php } ?>
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