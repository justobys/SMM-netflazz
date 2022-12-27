<?php
session_start();
require '../config.php';
require '../lib/session_user.php';

	    $post_idtarget = $conn->real_escape_string(filter($_GET['id']));
	    require '../lib/session_login.php';
	    $cek_tiket = $conn->query("SELECT * FROM tiket WHERE id = '$post_idtarget' AND user = '$sess_username'");
	    $data_tiket = $cek_tiket->fetch_assoc();

	    $cek_balasan = $conn->query("SELECT * FROM pesan_tiket WHERE id_tiket = '$post_idtarget' AND pengirim = 'Admin'");
	    if (mysqli_num_rows($cek_tiket) == 0) {
		    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Tiket Kamu Tidak Ditemukan.<script>swal("Ups Gagal!", "Tiket Kamu Tidak Ditemukan.", "error");</script>');
		    exit(header("Location: ".$config['web']['url']."page/help"));
	    } else {

		        $conn->query("UPDATE tiket SET this_user = '1' WHERE id = '$post_idtarget'");

	        if (isset($_POST['balas'])) {
		        $pesan = $conn->real_escape_string(filter($_POST['pesan']));

                $error = array();
                if (empty($pesan)) {
		            $error ['pesan'] = '*Tidak Boleh Kosong.<script>swal("Ups Gagal!", "Pesan Harus Diisi.", "error");</script>';
                } else if (strlen($pesan) > 500) {
		            $error ['pesan'] = '*Maksimal Pengisian Pesan Adalah 500 Karakter.<script>swal("Ups Gagal!", "Maksimal Pengisian Pesan Adalah 500 Karakter.", "error");</script>';
                } else {

		            if ($data_tiket['status'] == "Closed") {
			            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Status Tiket Kamu Sudah Ditutup Dikarenakan Ada Masalah, Harap Membuat Tiket Baru Ya.<script>swal("Ups Gagal!", "Status Tiket Kamu Sudah Ditutup.", "error");</script>');
				        exit(header("Location: ".$config['web']['url']."page/help"));
		            } else {

		                $update_terakhir = "$date $time";
		                $insert_tiket = $conn->query("INSERT INTO pesan_tiket VALUES ('', '$post_idtarget', 'Member', '$sess_username', '$pesan',  '$date', '$time','$update_terakhir')");
		                $update_tiket = $conn->query("UPDATE tiket SET update_terakhir = '$update_terakhir' WHERE id = '$post_idtarget'");
		                if (mysqli_num_rows($cek_balasan) > 0) {
			                $conn->query("UPDATE tiket SET status = 'Waiting', this_admin = '0' WHERE id = '$post_idtarget'");
		                }
		                if ($insert_tiket == TRUE) {
			                $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip! Balasan Baru Kamu Berhasil Dikirim.<script>swal("Berhasil!", "Balasan Pesanmu Berhasil Dikirim.", "success");</script>');
		                } else {
			                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
		                }
		            }
		        }
	        }
        }

        require '../lib/header.php';

?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Balas Tiket</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Tiket</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Balas Tiket</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Help Reply -->
        <div class="row">
	        <div class="offset-lg-2 col-lg-8">
                <div class="kt-grid__item kt-grid__item--fluid kt-app__content" id="kt_chat_content">
                    <div class="kt-chat">
                        <div class="kt-portlet kt-portlet--head-lg kt-portlet--last">
                            <div class="kt-portlet__head">
                                <div class="kt-chat__head ">
                                    <div class="kt-chat__left">
                                        <h5><i class="flaticon-reply text-primary"></i>
					                    <?php echo $data_tiket['subjek']; ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                            <?php
                            if (isset($_SESSION['hasil'])) {
                            ?>
                            <div class="alert alert-<?php echo $_SESSION['hasil']['alert'] ?> alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo $_SESSION['hasil']['pesan'] ?>
                            </div>
                            <?php
                            unset($_SESSION['hasil']);
                            }
                            ?>
                                <div style="max-height: 400px; overflow: auto;">
                                    <div class="kt-chat__messages">
                                        <div class="alert alert-warning text-right">
                                            <div class="alert-text">
                                                <div class="kt-chat__message kt-chat__message--right">
                                                    <div class="kt-chat__user">
                                                        <a href="#" class="kt-chat__username"><?php echo $data_tiket['user']; ?></span></a>
                                                        <span class="kt-media kt-media--circle kt-media--sm"> 
                                                            <img src="<?php echo $config['web']['url'] ?>assets/media/icon/user.svg" alt="image">
                                                        </span>
                                                    </div>
                                                    <div class="kt-chat__text kt-bg-light-brand">
                                                        <?php echo nl2br($data_tiket['pesan']); ?>
                                                    </div>
                                                    <p><i class="text-muted" style="font-size: 10px;"><span class="kt-chat__datetime"><?php echo tanggal_indo($data_tiket['date']); ?>, <?php echo $data_tiket['time']; ?></span></i></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $cek_pesan = $conn->query("SELECT * FROM pesan_tiket WHERE id_tiket = '$post_idtarget'");
                                        while ($data_pesan = $cek_pesan->fetch_assoc()) {
                                        if ($data_pesan['pengirim'] == "Admin") {
                                            $alert = "success";
                                            $text = "";
                                            $pengirim = "Admin";
                                            $gambar = "green.png";
                                        } else {
                                            $alert = "warning";
                                            $text = "right";
                                            $pengirim = $data_pesan['user'];
                                            $gambar = "user.svg";
                                        }
                                        ?>
                                        <div class="alert alert-<?php echo $alert; ?> text-<?php echo $text; ?>">
                                            <div class="alert-text">
                                                <div class="kt-chat__message kt-chat__message--<?php echo $text; ?>">
                                                    <div class="kt-chat__user">
                                                        <a href="#" class="kt-chat__username"><?php echo $pengirim; ?></span></a>
                                                        <span class="kt-media kt-media--circle kt-media--sm"> 
                                                            <img src="<?php echo $config['web']['url'] ?>assets/media/icon/<?php echo $gambar; ?>" alt="image">
                                                        </span>
                                                    </div>
                                                    <div class="kt-chat__text kt-bg-light-danger">
                                                        <?php echo nl2br($data_pesan['pesan']); ?>
                                                    </div>
                                                    <p><i class="text-muted" style="font-size: 10px;"><span class="kt-chat__datetime"><?php echo tanggal_indo($data_pesan['date']); ?>, <?php echo $data_pesan['time']; ?></span></i></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
							<form class="form-horizontal" role="form" method="POST">
							<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                            <div class="kt-portlet__foot">
                                <div class="kt-chat__input">
                                    <div class="kt-chat__editor">
                                        <textarea style="height: 50pxn" name="pesan" placeholder="Pesan" value="<?php echo $pesan; ?>"></textarea>
                                        <span class="form-text text-muted"><?php echo ($error['pesan']) ? $error['pesan'] : '';?></span>
                                    </div>
                                    <div class="kt-chat__toolbar">
                                        <div class="kt_chat__tools">
                                            <a href="<?php echo $config['web']['url']; ?>page/help" class="btn btn-warning btn-md btn-upper btn-bold"> Kembali</a>
                                        </div>
                                        <div class="kt_chat__actions">
                                            <button type="submit" class="btn btn-brand btn-md btn-upper btn-bold" name="balas">Balas</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Help Reply -->

        </div>
        <!-- End Content -->

        <br />

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

<?php 
require '../lib/footer.php';
?>