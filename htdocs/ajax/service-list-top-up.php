<?php
require("../config.php");

if (isset($_POST['operator'])) {
	$post_kategori = $conn->real_escape_string(filter($_POST['operator']));
	$cek_layanan = $conn->query("SELECT * FROM layanan_pulsa WHERE operator = '$post_kategori'");
	if (mysqli_num_rows($cek_layanan) != 0) {
	?>

                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                            <thead>
                                <tr>
                                    <th>ID Layanan</th>
                                    <!--<th>Kategori</th>-->
                                    <th>Nama Layanan</th>
                                    <th>Harga</th>
                                    <!--<th>Harga API</th>
                                    <th>Tipe</th>-->
                                    <th>Multi Order</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($data_layanan = mysqli_fetch_assoc($cek_layanan)) {
                            if($data_layanan['status'] == "Normal") {
                                $label_status = "success";
                            } else if($data_layanan['status'] == "Gangguan") {
                                $label_status = "danger";
                            }
                            if($data_layanan['multi'] == "Ya") {
                                $label_multi = "success";
                            } else if($data_layanan['multi'] == "Tidak") {
                                $label_multi = "danger";
                            }
                            ?>
                                <tr>
                                    <th scope="row"><span class="badge badge-primary"><?php echo $data_layanan['service_id']; ?></span></th>
                                    <!--<td><?php echo $data_layanan['operator']; ?></td>-->
                                    <td><?php echo $data_layanan['layanan']; ?></td>
                                    <td><span class="badge badge-success">Rp <?php echo number_format($data_layanan['harga'],0,',','.'); ?></span></td>
                                    <!--<td><span class="badge badge-warning">Rp <?php echo number_format($data_layanan['harga_api'],0,',','.'); ?></span></td>
                                    <td><span class="badge badge-dark"><?php echo $data_layanan['tipe']; ?></span></td>-->
                                    <td><label class="btn btn-sm btn-<?php echo $label_multi; ?>"><?php echo $data_layanan['multi']; ?></label></td>
                                    <td><label class="btn btn-sm btn-<?php echo $label_status; ?>"><?php echo $data_layanan['status']; ?></label></td>
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