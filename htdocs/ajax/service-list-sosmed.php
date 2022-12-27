<?php
require("../config.php");

if (isset($_POST['kategori'])) {
	$post_kategori = $conn->real_escape_string(filter($_POST['kategori']));
	$cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE kategori = '$post_kategori'");
	if (mysqli_num_rows($cek_layanan) != 0) {
	?>

                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                            <thead>
                                <tr>
                                    <th>ID Layanan</th>
                                    <th>Kategori</th>
                                    <th>Nama Layanan</th>
                                    <th>Harga WEB/1000</th>
                                    <th>Harga API/1000</th>
                                    <th>Min</th>
                                    <th>Max</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($data_layanan = mysqli_fetch_assoc($cek_layanan)) {
                            if($data_layanan['status'] == "Aktif") {
                                $label = "success";
                            } else if($data_layanan['status'] == "Tidak Aktif") {
                                $label = "danger";
                            }
                            ?>
                                <tr>
                                    <th scope="row"><span class="badge badge-primary"><?php echo $data_layanan['service_id']; ?></span></th>
                                    <td><?php echo $data_layanan['kategori']; ?></td>
                                    <td><?php echo $data_layanan['layanan']; ?></td>
                                    <td><span class="badge badge-success">Rp <?php echo number_format($data_layanan['harga'],0,',','.'); ?></span></td>
                                    <td><span class="badge badge-warning">Rp <?php echo number_format($data_layanan['harga_api'],0,',','.'); ?></span></td>
                                    <td><span class="badge badge-danger"><?php echo number_format($data_layanan['min'],0,',','.'); ?></span></td>
                                    <td><span class="badge badge-dark"><?php echo number_format($data_layanan['max'],0,',','.'); ?></span></td>
                                    <td><label class="btn btn-sm btn-<?php echo $label; ?>"><?php echo $data_layanan['status']; ?></label></td>
                                </tr>
                            <?php
                            } 
                            ?>
                            </tbody>
                        </table>
                    </div>
<?php
} else {
?>
<div class="text-center">
<div class="alert alert-primary">Maaf, Layanan Belum Tersedia</div>
</div>
<?php
}
}