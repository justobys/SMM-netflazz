<?php 
session_start();
require '../config.php';
require '../lib/session_login.php';
require '../lib/session_user.php';

        if (isset($_POST['ganti_profil'])) {
            $nama_depan = $conn->real_escape_string(trim(filter($_POST['nama_depan'])));
            $nama_belakang = $conn->real_escape_string(trim(filter($_POST['nama_belakang'])));
            $email = $conn->real_escape_string(trim(filter($_POST['email'])));
            $no_hp = $conn->real_escape_string(trim(filter($_POST['no_hp'])));
            $pin = $conn->real_escape_string(trim(filter($_POST['pin1'])));

            $cek_email = $conn->query("SELECT * FROM users WHERE email = '$email'");
            $cek_email_ulang = mysqli_num_rows($cek_email);
            $data_email = mysqli_fetch_assoc($cek_email);

            $cek_no_hp = $conn->query("SELECT * FROM users WHERE no_hp = '$no_hp'");
            $cek_no_hp_ulang = mysqli_num_rows($cek_no_hp);
            $data_no_hp = mysqli_fetch_assoc($cek_no_hp);

            $error = array();
            if (empty($nama_depan)) {
		        $error ['nama_depan'] = '*Tidak Boleh Kosong.';
            }
            if (empty($nama_belakang)) {
		        $error ['nama_belakang'] = '*Tidak Boleh Kosong.';
            }
            if (empty($email)) {
		        $error ['email'] = '*Tidak Boleh Kosong.';
            } else if ($cek_email_ulang == 0) {
		        $error ['email'] = '*Email Sudah Terdaftar.';
            }
            if (empty($no_hp)) {
		        $error ['no_hp'] = '*Tidak Boleh Kosong.';
            } else if ($cek_no_hp_ulang == 0) {
		        $error ['no_hp'] = '*Nomor HP Sudah Terdaftar.';
            }
            if (empty($pin)) {
		        $error ['pin1'] = '*Tidak Boleh Kosong.';
            } else if ($pin <> $data_user['pin']) {
		        $error ['pin1'] = '*PIN Yang Kamu Masukkan Salah.';
            } else {

   		    if ($conn->query("UPDATE users SET nama_depan = '$nama_depan', nama_belakang = '$nama_belakang', email = '$email', no_hp = '$no_hp' WHERE username = '$sess_username'") == true) {
   			    $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil', 'pesan' => 'Yeah, Data Profil Kamu Berhasil Diubah.<script>swal("Berhasil!", "Data Profil Kamu Berhasil Diubah.", "success");</script>');
            } else {
   			    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
   		    }

        }

        } else if (isset($_POST['ganti_password'])) {
            $password = $conn->real_escape_string(trim(filter($_POST['password_lama'])));
            $password_baru = $conn->real_escape_string(trim(filter($_POST['password_baru'])));
            $konf_pass_baru = $conn->real_escape_string(trim(filter($_POST['konf_pass_baru'])));

            $cek_passwordnya = password_verify($password, $data_user['password']);
            $hash_passwordnya = password_hash($password_baru, PASSWORD_DEFAULT);

            $error = array();
            if (empty($password)) {
		        $error ['password_lama'] = '*Tidak Boleh Kosong.';
            }
            if (empty($password_baru)) {
		        $error ['password_baru'] = '*Tidak Boleh Kosong.';
            } else if (strlen($password_baru) < 6 ){
		        $error ['password_baru'] = '*Kata Sandi Minimal 6 Karakter.';
            }
            if (empty($konf_pass_baru)) {
		        $error ['konf_pass_baru'] = '*Tidak Boleh Kosong.';
            } else if (strlen($konf_pass_baru) < 6 ){
		        $error ['konf_pass_baru'] = '*Kata Sandi Minimal 6 Karakter.';
            } else if ($password_baru <> $konf_pass_baru){
		        $error ['konf_pass_baru'] = '*Konfirmasi Kata Sandi Baru Tidak Sesuai.';
            } else {

            if ($cek_passwordnya <> $data_user['password']) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Kata Sandi Lama Yang Kamu Masukkan Tidak Sesuai.<script>swal("Gagal!", "Kata Sandi Lama Yang Kamu Masukkan Tidak Sesuai.", "error");</script>');
            } else {

   		    if ($conn->query("UPDATE users SET password = '$hash_passwordnya' WHERE username = '$sess_username'") == true) {
   			    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip! Kata Sandi Kamu Berhasil Diubah.<script>swal("Berhasil!", "Kata Sandi Kamu Berhasil Diubah.", "success");</script>');
            } else {
   			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
   		    }

            }
        
        }

        } else if (isset($_POST['ganti_pin'])) {
            $pin = $conn->real_escape_string(trim(filter($_POST['pin_lama'])));
            $pin_baru = $conn->real_escape_string(trim(filter($_POST['pin_baru'])));
            $konfirmasi_pin_baru = $conn->real_escape_string(trim(filter($_POST['konfirmasi_pin_baru'])));

            $error = array();
            if (empty($pin)) {
		        $error ['pin_lama'] = '*Tidak Boleh Kosong.';
            }
            if (empty($pin_baru)) {
		        $error ['pin_baru'] = '*Tidak Boleh Kosong.';
            } else if (strlen($pin_baru) <> 6) {
		        $error ['pin_baru'] = '*PIN Harus 6 Digit.';
            }
            if (empty($konfirmasi_pin_baru)) {
		        $error ['konfirmasi_pin_baru'] = '*Tidak Boleh Kosong.';
            } else if (strlen($konfirmasi_pin_baru) <> 6 ){
		        $error ['konfirmasi_pin_baru'] = '*PIN Harus 6 Digit.';
            } else if ($pin_baru <> $konfirmasi_pin_baru){
		        $error ['konfirmasi_pin_baru'] = '*Konfirmasi PIN Baru Tidak Sesuai.';
            } else {

            if ($pin <> $data_user['pin']) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, PIN Lama Yang Kamu Masukkan Tidak Sesuai.<script>swal("Gagal!", "PIN Lama Yang Kamu Masukkan Tidak Sesuai.", "error");</script>');
            } else {

   		    if ($conn->query("UPDATE users SET pin = '$pin_baru' WHERE username = '$sess_username'") == true) {
   			    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip! PIN Kamu Berhasil Diubah.<script>swal("Berhasil!", "PIN Kamu Berhasil Diubah.", "success");</script>');
            } else {
   			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
   		    }

            }
        
        }

        } else if (isset($_POST['ganti_api_key'])) {
		    $api_barunya = acak(20);
		    if ($conn->query("UPDATE users SET api_key = '$api_barunya' WHERE username = '$sess_username'") == true) {
   		        $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Yeah, Api Key Kamu Berhasil Diubah.<script>swal("Berhasil!", "API Key Kamu Berhasil Diubah.", "success");</script>');
		    } else {
   		        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
		    }
        }

        require '../lib/header.php';

?>

        <!-- Start Sub Header -->
        <!--<div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">
		                <button class="kt-subheader__mobile-toggle kt-subheader__mobile-toggle--left" id="kt_subheader_mobile_toggle"><span></span></button>
		                Profile
		                </h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Profile</a>
	                </div>
	            </div>
	        </div>
        </div>-->
        <!-- End Sub Header -->

        <!-- Start Content -->
<div class="kt-container  kt-grid__item kt-grid__item--fluid">

	    <!-- Start App -->
	<div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

	    <!-- Start App Aside Mobile Toggle -->
	    <button class="kt-app__aside-close" id="kt_user_profile_aside_close">
	        <i class="la la-close"></i>
	    </button>
	    <!-- End App Aside Mobile Toggle -->

	    <!-- Start App Aside-->

        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">

         <!-- Start Tab Content -->


            <!-- Start Widgets/Applications/User/Profile -->
            <br>
            <div class="kt-portlet ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title"> <i class="flaticon2-user"></i> Akun</h3>
                    </div>
                </div>

                <div class="kt-portlet__body">

                    <!-- Start Widget -->
                    <div class="kt-widget kt-widget--user-profile-1">
                        <div class="kt-widget__head">
                            <div class="kt-widget__media">
                                <img src="<?php echo $config['web']['url'] ?>assets/media/icon/user4.png" alt="image">
                            </div>
                            <div class="kt-widget__content">
                                <div class="kt-widget__section">
                                    <a href="#" class="kt-widget__username">
                                        <?php echo $data_user['nama']; ?>
                                        <i class="flaticon2-correct kt-font-warning"></i>
                                    </a>
                                    <span class="kt-widget__subtitle">
                                        <?php echo $data_user['level']; ?>
                                    </span>
                                </div>
                                </div>
                        </div>

                        <div class="kt-widget__body">
                            <div class="kt-widget__content">
                                <div class="kt-widget__info">
                                    <span class="kt-widget__label">Email :</span>
                                    <span class="kt-widget__data"><?php echo $data_user['email']; ?></span>
                                </div>
                                <div class="kt-widget__info">
                                    <span class="kt-widget__label">Total Pemakaian Saldo :</span>
                                    <span class="kt-widget__data">Rp <?php echo number_format($data_user['pemakaian_saldo'],0,',','.'); ?></a>
                                </div>
                                <div class="kt-widget__info">
                                    <span class="kt-widget__label">Terdaftar Sejak :</span>
                                    <span class="kt-widget__data"><?php echo tanggal_indo($data_user['date']); ?></span>
                                </div>
                                <div class="kt-widget__info">
                                    <span class="kt-widget__label">Kode Refferal Anda :</span>
                                    <span class="kt-widget__data"><b><?php echo $data_user['kode_referral']; ?></b></span>
                                </div>
                            </div>

                            <!-- Start tab -->

                            <div class="kt-widget__items" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a id="account-tab" href="#account" data-toggle="pill" aria-selected="true" aria-controls="account" class="nav-link kt-widget__item active">
                                    <span class="kt-widget__section">
                                        <span class="kt-widget__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                                </g>
                                            </svg>
                                        </span>
                                        <span class="kt-widget__desc">
                                            Pengaturan Akun
                                        </span>
                                    </span>
                                </a>
                                <a id="change-password-tab" href="#change-password" data-toggle="pill" aria-selected="false" aria-controls="change-password" class="nav-link kt-widget__item">
                                    <span class="kt-widget__section">
                                        <span class="kt-widget__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <mask fill="white">
                                                        <use xlink:href="#path-1"/>
                                                    </mask>
                                                    <g/>
                                                    <path d="M7,10 L7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 L17,10 L18,10 C19.1045695,10 20,10.8954305 20,12 L20,18 C20,19.1045695 19.1045695,20 18,20 L6,20 C4.8954305,20 4,19.1045695 4,18 L4,12 C4,10.8954305 4.8954305,10 6,10 L7,10 Z M12,5 C10.3431458,5 9,6.34314575 9,8 L9,10 L15,10 L15,8 C15,6.34314575 13.6568542,5 12,5 Z" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </span>
                                        <span  class="kt-widget__desc">
                                            Ganti Kata Sandi
                                        </span>
                                    </span>
                                </a>
                                <a id="change-pin-tab" href="#change-pin" data-toggle="pill" aria-selected="false" aria-controls="change-pin" class="nav-link kt-widget__item">
                                    <span class="kt-widget__section">
                                        <span class="kt-widget__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <polygon fill="#000000" opacity="0.3" transform="translate(8.885842, 16.114158) rotate(-315.000000) translate(-8.885842, -16.114158) " points="6.89784488 10.6187476 6.76452164 19.4882481 8.88584198 21.6095684 11.0071623 19.4882481 9.59294876 18.0740345 10.9659914 16.7009919 9.55177787 15.2867783 11.0071623 13.8313939 10.8837471 10.6187476"/>
                                                    <path d="M15.9852814,14.9852814 C12.6715729,14.9852814 9.98528137,12.2989899 9.98528137,8.98528137 C9.98528137,5.67157288 12.6715729,2.98528137 15.9852814,2.98528137 C19.2989899,2.98528137 21.9852814,5.67157288 21.9852814,8.98528137 C21.9852814,12.2989899 19.2989899,14.9852814 15.9852814,14.9852814 Z M16.1776695,9.07106781 C17.0060967,9.07106781 17.6776695,8.39949494 17.6776695,7.57106781 C17.6776695,6.74264069 17.0060967,6.07106781 16.1776695,6.07106781 C15.3492424,6.07106781 14.6776695,6.74264069 14.6776695,7.57106781 C14.6776695,8.39949494 15.3492424,9.07106781 16.1776695,9.07106781 Z" fill="#000000" transform="translate(15.985281, 8.985281) rotate(-315.000000) translate(-15.985281, -8.985281) "/>
                                                </g>
                                            </svg>
                                        </span>
                                        <span class="kt-widget__desc">
                                            Ganti PIN
                                        </span>
                                    </span>
                                </a>
                                <a id="setting-api-tab" href="#setting-api" data-toggle="pill" aria-selected="false" aria-controls="setting-api" class="nav-link kt-widget__item">
                                    <span class="kt-widget__section">
                                        <span class="kt-widget__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path d="M15.2718029,8.68536757 C14.8932864,8.28319382 14.9124644,7.65031935 15.3146382,7.27180288 C15.7168119,6.89328641 16.3496864,6.91246442 16.7282029,7.31463817 L20.7282029,11.5646382 C21.0906029,11.9496882 21.0906029,12.5503176 20.7282029,12.9353676 L16.7282029,17.1853676 C16.3496864,17.5875413 15.7168119,17.6067193 15.3146382,17.2282029 C14.9124644,16.8496864 14.8932864,16.2168119 15.2718029,15.8146382 L18.6267538,12.2500029 L15.2718029,8.68536757 Z M8.72819712,8.6853647 L5.37324625,12.25 L8.72819712,15.8146353 C9.10671359,16.2168091 9.08753558,16.8496835 8.68536183,17.2282 C8.28318808,17.6067165 7.65031361,17.5875384 7.27179713,17.1853647 L3.27179713,12.9353647 C2.90939712,12.5503147 2.90939712,11.9496853 3.27179713,11.5646353 L7.27179713,7.3146353 C7.65031361,6.91246155 8.28318808,6.89328354 8.68536183,7.27180001 C9.08753558,7.65031648 9.10671359,8.28319095 8.72819712,8.6853647 Z" fill="#000000" fill-rule="nonzero"/>
                                                </g>
                                            </svg>
                                        </span>
                                        <span class="kt-widget__desc">
                                            Pengaturan API
                                        </span>
                                    </span>
                                </a>
                            </div>
                        </div>

                    </div>
                    <!-- End Widget -->
                </div>
            </div>
            <!-- End Widgets/Applications/User/Profile -->

        </div>
        <!-- End App Aside -->



<!-- Start App Content -->
<div class="kt-grid__item kt-grid__item--fluid kt-app__content">

    <!-- Start Tab Content -->
    <div id="v-pills-tabContent" class="tab-content">

        <!-- Start Change Data Account -->
        <br>
        <div role="tabpanel" class="tab-pane fade active show" id="account" aria-labelledby="account-tab">
            <div class="row">
                <div class="col-xl-12">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title"><i class="flaticon2-gear"></i> Setting Akun</h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                                </div>
                            </div>
                        </div>
                        <form class="kt-form kt-form--label-right" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
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
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Nama Pengguna</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control bg-secondary" type="text" value="<?php echo $data_user['username']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Nama Depan</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control" type="text" name="nama_depan" value="<?php echo $data_user['nama_depan']; ?>">
                                                <span class="form-text text-muted"><?php echo ($error['nama_depan']) ? $error['nama_depan'] : '';?></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Nama Belakang</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control" type="text" name="nama_belakang" value="<?php echo $data_user['nama_belakang']; ?>">
                                                <span class="form-text text-muted"><?php echo ($error['nama_belakang']) ? $error['nama_belakang'] : '';?></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Alamat Email</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at text-primary"></i></span></div>
                                                    <input type="text" class="form-control" name="email" value="<?php echo $data_user['email']; ?>" placeholder="Email">
                                                </div>
                                                <span class="form-text text-muted"><?php echo ($error['email']) ? $error['email'] : '';?></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Nomer HP</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone text-primary"></i></span></div>
                                                    <input type="text" class="form-control" name="no_hp" value="<?php echo $data_user['no_hp']; ?>" placeholder="Contoh : 6281234567890">
                                                </div>
                                                <span class="form-text text-muted"><?php echo ($error['no_hp']) ? $error['no_hp'] : '';?></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Masukkan PIN Kamu Untuk Menyimpan Perubahan</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-lock text-primary"></i></span></div>
                                                    <input type="number" name="pin1" class="form-control" placeholder="Masukkan PIN Kamu">
                                                </div>
                                                <span class="form-text text-muted"><?php echo ($error['pin1']) ? $error['pin1'] : '';?></span>
                                            </div>
                                        </div>
                                        <div class="kt-portlet__foot">
                                            <div class="kt-form__actions">
                                                <div class="row">
                                                    <div class="col-lg-3 col-xl-3">
                                                    </div>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <button type="submit" name="ganti_profil" class="btn btn-primary btn-elevate btn-pill btn-elevate-air">Submit</button>
                                                        <button type="reset" class="btn btn-danger btn-elevate btn-pill btn-elevate-air">Ulangi</button>
                                                    </div>
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
        </div>
        <!-- End Change Data Account -->

        <!-- Start Change Password -->
        <div role="tabpanel" class="tab-pane fade" id="change-password" aria-labelledby="change-passsword-tab">
            <div class="row">
                <div class="col-xl-12">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title"><i class="flaticon-lock"></i> Ganti Kata Sandi</h3>
                            </div>
                            <div class="kt-portlet__head-toolbar kt-hidden">
                                <div class="kt-portlet__head-toolbar">
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="la la-sellsy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="kt-form kt-form--label-right" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                            <div class="kt-portlet__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Kata Sandi Lama</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-lock text-primary"></i></span></div>
                                                    <input type="password" name="password_lama" class="form-control" value="<?php echo $password; ?>" placeholder="Kata Sandi Lama Kamu">
                                                </div>
                                                <span class="form-text text-muted"><?php echo ($error['password_lama']) ? $error['password_lama'] : '';?></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Kata Sandi Baru</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-lock text-primary"></i></i></span></div>
                                                    <input type="password" name="password_baru" class="form-control" value="<?php echo $password_baru; ?>" placeholder="Kata Sandi Baru Yang Mau Kamu Ganti">
                                                </div>
                                                <span class="form-text text-muted"><?php echo ($error['password_baru']) ? $error['password_baru'] : '';?></span>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-last row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Konfirmasi Kata Sandi Baru</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-lock text-primary"></i></span></div>
                                                    <input type="password" name="konf_pass_baru" class="form-control" value="<?php echo $konf_pass_baru; ?>" placeholder="Konfirmasi Kata Sandi Baru Sebelumnya">
                                                </div>
                                                <span class="form-text text-muted"><?php echo ($error['konf_pass_baru']) ? $error['konf_pass_baru'] : '';?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-3 col-xl-3">
                                        </div>
                                        <div class="col-lg-9 col-xl-9">
                                            <button type="submit" name="ganti_password" class="btn btn-primary btn-elevate btn-pill btn-elevate-air">Submit</button>
                                            <button type="reset" class="btn btn-danger btn-elevate btn-pill btn-elevate-air">Ulangi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Change Password -->

        <!-- Start Change PIN -->
        <div role="tabpanel" class="tab-pane fade" id="change-pin" aria-labelledby="change-pin-tab">
            <div class="row">
                <div class="col-xl-12">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title"><i class="la la-key"></i> Ganti PIN</h3>
                            </div>
                            <div class="kt-portlet__head-toolbar kt-hidden">
                                <div class="kt-portlet__head-toolbar">
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="la la-sellsy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="kt-form kt-form--label-right" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                            <div class="kt-portlet__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">PIN Lama</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-key text-primary"></i></span></div>
                                                    <input type="number" name="pin_lama" class="form-control" value="<?php echo $pin; ?>" placeholder="Masukkan PIN Lama Kamu">
                                                </div>
                                                <span class="form-text text-muted"><?php echo ($error['pin_lama']) ? $error['pin_lama'] : '';?></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">PIN Baru</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-key text-primary"></i></span></div>
                                                    <input type="number" name="pin_baru" class="form-control" value="<?php echo $pin_baru; ?>" placeholder="PIN Baru Yang Mau Kamu Ganti">
                                                </div>
                                                <span class="form-text text-muted"><?php echo ($error['pin_baru']) ? $error['pin_baru'] : '';?></span>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-last row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Konfirmasi PIN Baru</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-key text-primary"></i></span></div>
                                                    <input type="number" name="konfirmasi_pin_baru" class="form-control" value="<?php echo $konfirmasi_pin_baru; ?>" placeholder="Konfirmasi PIN Baru Sebelumnya">
                                                </div>
                                                <span class="form-text text-muted"><?php echo ($error['konfirmasi_pin_baru']) ? $error['konfirmasi_pin_baru'] : '';?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-3 col-xl-3">
                                        </div>
                                        <div class="col-lg-9 col-xl-9">
                                            <button type="submit" name="ganti_pin" class="btn btn-primary btn-elevate btn-pill btn-elevate-air">Submit</button>
                                            <button type="reset" class="btn btn-danger btn-elevate btn-pill btn-elevate-air">Ulangi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Change PIN -->

        <!-- Start Pengaturan API -->
        <div role="tabpanel" class="tab-pane fade" id="setting-api" aria-labelledby="setting-api-tab">
            <div class="row">
                <div class="col-xl-12">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title"><i class="la la-code"></i> Pengaturan API</h3>
                            </div>
                            <div class="kt-portlet__head-toolbar kt-hidden">
                                <div class="kt-portlet__head-toolbar">
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="la la-sellsy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="kt-form kt-form--label-right" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                            <div class="kt-portlet__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">API Key</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-code text-primary"></i></span></div>
                                                    <input type="text" name="ip_statis" class="form-control" value="<?php echo $data_user['api_key']; ?>" readonly>
                                                    <div class="input-group-append">
                                                        <button type="submit" name="ganti_api_key" class="btn btn-primary">Ganti API Key</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <a href="<?php echo $config['web']['url'] ?>page/api-documentation" type="button" class="btn btn-primary btn-pill center active">
                                            Dokumentasi API
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Pengaturan API -->

    </div>
    <!-- End Tab Content -->

</div>
<!-- End App Content -->

        <!-- Start Scrolltop -->
		
		<!-- End Scrolltop -->

<?php
require '../lib/footer.php';
?>