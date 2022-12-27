<?php
session_start();
require '../../../config.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	if (!isset($_SESSION['user'])) {
			exit("Anda Tidak Memiliki Akses!");
	}
	if (!isset($_GET['data'])) {
		exit("Anda Tidak Memiliki Akses!");
	} 		
$get_id = $conn->real_escape_string(filter($_GET['data']));
$cek_depo = $conn->query("SELECT * FROM metode_depo WHERE id = '$get_id'");
$data_depo = $cek_depo->fetch_assoc();
	if (mysqli_num_rows($cek_depo) == 0) {
		exit("Data Tidak Ditemukan");
	} else {
?>
		    			<div class="row">
		    				<div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12 control-label">ID Pembayaran Isi Saldo</label>
                                    <div class="col-md-12">
                                        <input type="number" name="id" class="form-control" value="<?php echo $data_depo['id']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Tipe Pembayaran</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="tipe">
                                            <option value="<?php echo $data_depo['tipe']; ?>"><?php echo $data_depo['tipe']; ?> (Terpilih)</option>
                                            <option value="Transfer Pulsa">Transfer Pulsa</option>
                                            <option value="Transfer Bank">Transfer Bank</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Provider</label>
                                    <div class="col-md-12">
                                        <input type="text" name="provider" class="form-control" value="<?php echo $data_depo['provider']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Keterangan</label>
                                    <div class="col-md-12">
                                        <input type="text" name="catatan" class="form-control" value="<?php echo $data_depo['catatan']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Rate</label>
                                    <div class="col-md-12">
                                        <input type="text" name="rate" class="form-control" value="<?php echo $data_depo['rate']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Nama Penerima <small class="text-danger">*Kosongkan Jika Tipe Pembayaran Transfer Pulsa.</small></label>
                                    <div class="col-md-12">
                                        <input type="text" name="nama_penerima" class="form-control" value="<?php echo $data_depo['nama_penerima']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Tujuan Transfer</label>
                                    <div class="col-md-12">
                                        <input type="number" name="tujuan" class="form-control" value="<?php echo $data_depo['tujuan']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Jenis</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="jenis">
                                            <option value="<?php echo $data_depo['jenis']; ?>"><?php echo $data_depo['jenis']; ?> (Terpilih)</option>
                                            <option value="Otomatis">Otomatis</option>
                                            <option value="Manual">Manual</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Minimal Isi Saldo</label>
                                    <div class="col-md-12">
                                        <input type="number" name="minimal" class="form-control" value="<?php echo $data_depo['minimal']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Status</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="status">
                                            <option value="<?php echo $data_depo['status']; ?>"><?php echo $data_depo['status']; ?> (Terpilih)</option>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
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