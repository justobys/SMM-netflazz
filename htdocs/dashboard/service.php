<?php
require '../config.php';
require '../lib/database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="<?php echo $data['deskripsi_web']; ?>" name="description" />
        <meta content="MALING" name="author" />

        <title><?php echo $data['short_title']; ?></title>

        <!-- Start Favicon -->
        <link rel="icon" href="<?php echo $config['web']['url'] ?>assets/media/logos/favicon.png" type="image/png">
        <!-- End Favicon -->

        <!-- Start Bootstrap 4.1.3 -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- End Bootstrap 4.1.3 -->

        <!-- Start Animate Css -->
        <link rel="stylesheet" href="assets/css/plugins/animate.css">
        <!-- End Animate Css -->

        <!-- Start Google Fonts -->
        <link  href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
        <!-- End Google Fonts -->

        <!-- Start Fonts Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" rel="stylesheet">
        <!-- End Fonts Awesome -->

        <!-- Start Slick Slider -->
        <link rel="stylesheet" href="assets/css/plugins/slick.css">
        <link rel="stylesheet" href="assets/css/plugins/slick-theme.css">
        <!-- End Slick Slider -->

        <!-- Start Magnific Popup -->
        <link rel="stylesheet" href="assets/css/plugins/magnific-popup.css">
        <!-- End Magnific Popup -->

        <!-- Start Main Style -->
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/custom.css">
        <!-- End Main Style -->

</head>

<body>

        <!-- Start Page Loading -->
        <div class="se-pre-con"></div>
        <div id="app">
        <!-- End Page Loading -->

        <!-- Start Navbar -->
        <header class="header-global">
            <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                <div class="container">
                    <a class="navbar-brand" href="index.php"><img src="<?php echo $config['web']['url'] ?>assets/media/logos/netflazz.png" alt="logo" height="55" width="170"></a>
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-toggle="collapse"
                        data-target="#navbarNavDropdown"
                        aria-controls="navbarNavDropdown"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $config['web']['url'] ?>">Halaman Utama</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $config['web']['url'] ?>">Fitur Kami</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $config['web']['url'] ?>">Testimonial</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $config['web']['url'] ?>dashboard/service">Daftar Layanan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $config['web']['url'] ?>">Kontak Kami</a>
                            </li>
                        </ul>
                        <a href="<?php echo $config['web']['url'] ?>auth/login" role="button" class="btn-1">Masuk</a>
                    </div>
                </div>
            </nav>
        </header>
        <!-- End Navbar -->

        <!-- Start Service -->
        <section class="features">
            <div class="container">
                <div class="heading text-center">
                    <h2>Daftar Harga</h2>
                    <div class="line"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
		                <div class="box">
                            <h4 class="m-t-0 header-title text-center"><b>Daftar Harga Layanan Sosial Media</b></h4>
                                <form class="form-horizontal" role="form" method="POST">
							        <div class="form-group">
								        <label>Kategori</label>
								        <select class="form-control" id="kategori" name="kategori">
									        <option value="0">Pilih Salah Satu</option>
									        <?php
									        $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE tipe = 'Sosial Media' ORDER BY nama ASC");
									        while ($data_kategori = mysqli_fetch_assoc($cek_kategori)) {
									        ?>
									        <option value="<?php echo $data_kategori['kode']; ?>"><?php echo $data_kategori['nama']; ?></option>
									        <?php
									        }
									        ?>
								        </select>
							        </div>
                                </form>
						    <div id="layanan"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
		                <div class="box">
                            <h4 class="m-t-0 header-title text-center"><b>Daftar Harga Layanan Top Up</b></h4>
                                <form class="form-horizontal" role="form" method="POST">
							        <div class="form-group">
								        <label>Tipe</label>
								        <select class="form-control" id="tipe" name="tipe">
									        <option value="">Pilih Salah Satu</option>
									        <option value="Pulsa">Pulsa</option>
									        <option value="E-Money">E-Money</option>
									        <option value="Data">Data</option>
									        <option value="Paket SMS & Telpon">Paket SMS & Telpon</option>
									        <option value="Games">Games</option>
									        <option value="PLN">PLN</option>
									        <option value="Pulsa Internasional">Pulsa Internasional</option>
									        <option value="Voucher">Voucher</option>
									        <option value="WIFI ID">WIFI ID</option>
								        </select>
							        </div>
							        <div class="form-group">
								        <label>Kategori</label>
								        <select class="form-control" id="operator" name="operator">
									        <option value="0">Pilih Tipe Dahulu</option>
								        </select>
							        </div>
                                </form>
						    <div id="layanan_top_up"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Service -->

        </div>
        <!-- End App -->

		<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#kategori").change(function() {
			    var kategori = $("#kategori").val();
			    $.ajax({
			        url: '<?php echo $config['web']['url']; ?>ajax/service-list-sosmed.php',
			        data: 'kategori=' + kategori,
			        type: 'POST',
			        dataType: 'html',
			        success: function(msg) {
				        $("#layanan").html(msg);
			        }
		        });
	        });
		    $("#tipe").change(function() {
			    var tipe = $("#tipe").val();
		        $.ajax({
			        url: '<?php echo $config['web']['url']; ?>ajax/type-top-up.php',
			        data: 'tipe=' + tipe,
			        type: 'POST',
			        dataType: 'html',
			        success: function(msg) {
				        $("#operator").html(msg);
			        }
		        });
	        });
			$("#operator").change(function() {
			    var tipe = $("#tipe").val();
			    var operator = $("#operator").val();
			    $.ajax({
			        url: '<?php echo $config['web']['url']; ?>ajax/service-list-top-up.php',
			        data  : 'tipe=' +tipe + '&operator=' + operator,
			        type: 'POST',
			        dataType: 'html',
			        success: function(msg) {
				        $("#layanan_top_up").html(msg);
			        }
		        });
	        });
		});
		</script>

        <!-- Start Footer -->
        <footer class="footer">
            <div class="container text-center">
                <img src="<?php echo $config['web']['url'] ?>assets/media/logos/netflazz.png" alt="" height="55" width="55">
                <p>Copyright © 2020 <?php echo $data['short_title']; ?>. All Rights Reserved.</p>
            </div>
        </footer>
        <!-- End Footer -->

        <!-- Start Java Script -->
        <script src="assets/js/plugins/jquery-3.3.1.min.js"></script>
        <!-- End Java Script -->

        <!-- Start Datatables -->
        <script src="assets/js/plugins/dataTables.bootstrap4.min.js"></script>
        <script src="assets/js/plugins/dataTables.buttons.min.js"></script>
        <script src="assets/js/plugins/dataTables.responsive.min.js"></script>
        <script src="assets/js/plugins/jquery.dataTables.min.js"></script>
        <!-- End Datatables -->

        <!-- Start Bootstrap 4.1.3 -->
        <script src="assets/js/plugins/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- End Bootstrap 4.1.3 -->

        <!-- Start Slick Slider -->
        <script src="assets/js/plugins/slick.min.js"></script>
        <!-- End Slick Slider -->

        <!-- Start Couner Up -->
        <script src="assets/js/plugins/jquery.waypoints.min.js"></script>
        <script src="assets/js/plugins/jquery.counterup.min.js"></script>
        <!-- End Couner Up -->

        <!-- Start Wow JS -->
        <script src="assets/js/plugins/wow.min.js"></script>
        <!-- End Wow JS -->

        <!-- Start Magnific Popup -->
        <script src="assets/js/plugins/magnific-popup.min.js"></script>
        <!-- End Magnific Popup -->

        <!-- Start Main Js -->
        <script src="assets/js/main.js"></script>
        <!-- End Main Js -->

</body>

        <script type='text/javascript'>
        //<![CDATA[
        function redirectCU(e) {
          if (e.ctrlKey && e.which == 85) {
            window.location.replace("<?php echo $config['web']['url'] ?>dashboard/service");
            return false;
          }
        }
        document.onkeydown = redirectCU;

        function redirectKK(e) {
          if (e.which == 3) {
            window.location.replace("<?php echo $config['web']['url'] ?>dashboard/service");
            return false;
          }
        }
        document.oncontextmenu = redirectKK;
        //]]>
        </script>