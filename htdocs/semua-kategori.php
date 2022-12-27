<?php 
session_start();
require("config.php");
    
    if(isset($_COOKIE['cookie_token'])) {
	$data = $conn->query("SELECT * FROM users WHERE cookie_token='".$_COOKIE['cookie_token']."'");
	if(mysqli_num_rows($data) > 0) {
	    $hasil = mysqli_fetch_assoc($data);
		$_SESSION['user'] = $hasil;
	}
}

    
    if (isset($_SESSION['user'])) {
        $sess_username = $_SESSION['user']['username'];
        $check_user = $conn->query("SELECT * FROM users WHERE username = '$sess_username'");
        $data_user = $check_user->fetch_assoc();
        $check_username = $check_user->num_rows;
        if ($check_username == 0) {
	        header("Location: ".$config['web']['url']."logout.php");
        } else if ($data_user['status'] == "Tidak Aktif") {
	        header("Location: ".$config['web']['url']."logout.php");
        }

        // Data Grafik Pesanan Sosial Media

        $check_order_today = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$date' and user = '$sess_username'");

        $oneday_ago = date('Y-m-d', strtotime("-1 day"));
        $check_order_oneday_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$oneday_ago' and user = '$sess_username'");

        $twodays_ago = date('Y-m-d', strtotime("-2 day"));
        $check_order_twodays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$twodays_ago' and user = '$sess_username'");

        $threedays_ago = date('Y-m-d', strtotime("-3 day"));
        $check_order_threedays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$threedays_ago' and user = '$sess_username'");

        $fourdays_ago = date('Y-m-d', strtotime("-4 day"));
        $check_order_fourdays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$fourdays_ago' and user = '$sess_username'");

        $fivedays_ago = date('Y-m-d', strtotime("-5 day"));
        $check_order_fivedays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$fivedays_ago' and user = '$sess_username'");

        $sixdays_ago = date('Y-m-d', strtotime("-6 day"));
        $check_order_sixdays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$sixdays_ago' and user = '$sess_username'");   

        // Data Selesai

        // Data Grafik Pesanan Top Up

        $check_order_pulsa_today = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$date' and user = '$sess_username'");

        $oneday_ago = date('Y-m-d', strtotime("-1 day"));
        $check_order_pulsa_oneday_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$oneday_ago' and user = '$sess_username'");

        $twodays_ago = date('Y-m-d', strtotime("-2 day"));
        $check_order_pulsa_twodays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$twodays_ago' and user = '$sess_username'");

        $threedays_ago = date('Y-m-d', strtotime("-3 day"));
        $check_order_pulsa_threedays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$threedays_ago' and user = '$sess_username'");

        $fourdays_ago = date('Y-m-d', strtotime("-4 day"));
        $check_order_pulsa_fourdays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$fourdays_ago' and user = '$sess_username'");

        $fivedays_ago = date('Y-m-d', strtotime("-5 day"));
        $check_order_pulsa_fivedays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$fivedays_ago' and user = '$sess_username'");

        $sixdays_ago = date('Y-m-d', strtotime("-6 day"));
        $check_order_pulsa_sixdays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$sixdays_ago' and user = '$sess_username'");

        // Data Selesai

        // Data Grafik Pesanan Pascabayar
        $check_order_pascabayar_today = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$date' and user = '$sess_username'");

        $oneday_ago = date('Y-m-d', strtotime("-1 day"));
        $check_order_pascabayar_oneday_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$oneday_ago' and user = '$sess_username'");

        $twodays_ago = date('Y-m-d', strtotime("-2 day"));
        $check_order_pascabayar_twodays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$twodays_ago' and user = '$sess_username'");

        $threedays_ago = date('Y-m-d', strtotime("-3 day"));
        $check_order_pascabayar_threedays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$threedays_ago' and user = '$sess_username'");

        $fourdays_ago = date('Y-m-d', strtotime("-4 day"));
        $check_order_pascabayar_fourdays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$fourdays_ago' and user = '$sess_username'");

        $fivedays_ago = date('Y-m-d', strtotime("-5 day"));
        $check_order_pascabayar_fivedays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$fivedays_ago' and user = '$sess_username'");

        $sixdays_ago = date('Y-m-d', strtotime("-6 day"));
        $check_order_pascabayar_sixdays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$sixdays_ago' and user = '$sess_username'");

        // Data Selesai

        } else {
	        $_SESSION['user'] = $data_user;
	        header("Location: ".$config['web']['url']."dashboard");
        }

include("lib/header-all-category.php");
if (isset($_SESSION['user'])) {
?>
    <body>
		<!-- Start Card Box Order -->
        <div class="kt-container" style="margin-top:10px">
            <div class="row">
            <div class="product-catagory-wrap col-lg-12">
                <div class="card shadow">
                <div class="row" style="margin-top: 20px;">
                    <div class="col-3">
                        <div class=" mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/social-media"><img src="<?php echo $config['web']['url'] ?>admin/kategori/cat_20210528085404.png" alt=""><span>Sosmed</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/pulsa-reguler"><img src="<?php echo $config['web']['url'] ?>admin/kategori/cat_20210603092501.png" alt=""><span>Pulsa</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/saldo-emoney"><img src="<?php echo $config['web']['url'] ?>admin/kategori/cat_20210603093117.png" alt=""><span>E-Money</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/paket-data-internet"><img src="<?php echo $config['web']['url'] ?>admin/kategori/cat_20210603092448.png" alt=""><span>Paket Data</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class=" mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/paket-sms-telepon"><img src="<?php echo $config['web']['url'] ?>admin/kategori/cat_20210603093929.png" alt=""><span>Telpon & SMS</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/voucher-game"><img src="<?php echo $config['web']['url'] ?>admin/kategori/cat_20210603093434.png" alt=""><span>Voucher Game</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/token-pln"><img src="<?php echo $config['web']['url'] ?>admin/kategori/cat_20210603092637.png" alt=""><span>Token Listrik</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/pulsa-internasional"><img src="<?php echo $config['web']['url'] ?>admin/kategori/cat_20210603093929.png" alt=""><span>Pulsa Inter</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/wifi-id"><img src="<?php echo $config['web']['url'] ?>assets/media/icon-pay/wifi-id.png" alt=""><span>Wifi ID</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/voucher"><img src="<?php echo $config['web']['url'] ?>admin/kategori/cat_20210603093852.png" alt=""><span>Voucher</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/streaming"><img src="<?php echo $config['web']['url'] ?>assets/media/icon-pay/streaming.png" alt=""><span>Streaming</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/pln-pascabayar"><img src="<?php echo $config['web']['url'] ?>admin/kategori/cat_20210603093415.png" alt="">
                            <span>Listrik</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/hp-pascabayar"><img src="<?php echo $config['web']['url'] ?>admin/kategori/cat_20210603093943.png" alt="">
                            <span>HP Pascabayar</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/bpjs-kesehatan"><img src="<?php echo $config['web']['url'] ?>admin/kategori/cat_20210603093216.png" alt="">
                            <span>BPJS Kesehatan</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="<?php echo $config['web']['url'] ?>order/internet-pascabayar"><img src="<?php echo $config['web']['url'] ?>admin/kategori/cat_20210603093245.png" alt="">
                            <span>Internet Pascabayar</span></a>
                        </div>
                    </div>
                </div>
                </div><br>
                <div class="card shadow">
                <div class="kt-portlet__head" style="padding: 5px 25px;border-bottom: 1px solid #ebedf2;">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Kategori Lainnya
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="https://netflazz.com"><img src="https://image.flaticon.com/icons/png/512/1632/1632602.png" alt=""><span>Pusat Smm Dan PPOB</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="https://weddingken.com/"><img src="https://image.flaticon.com/icons/png/512/1017/1017466.png" alt=""><span>Undangan Digital</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="https://twentytwo-aio.xyz"><img src="https://image.flaticon.com/icons/png/512/273/273177.png" alt=""><span>Shop22</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3 catagory-card">
                            <a href="https://admin.aiohost.xyz"><img src="https://image.flaticon.com/icons/png/512/893/893247.png" alt=""><span>Bio Admin</span></a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
		</div>
		<!-- End Body Content -->
		
		<!-- Global Config (global config for global JS sciprts) -->
		<script>
            var KTAppOptions = {"colors":{"state":{"brand":"#366cf3","light":"#ffffff","dark":"#282a3c","primary":"#5867dd","success":"#34bfa3","info":"#36a3f7","warning":"#ffb822","danger":"#fd3995"},"base":{"label":["#c5cbe3","#a1a8c3","#3d4465","#3e4466"],"shape":["#f0f3ff","#d9dffa","#afb4d4","#646c9a"]}}};
		</script>
		<!-- End Global Config -->

		<!-- Global Theme Bundle (used by all pages) -->
		<script src="<?php echo $config['web']['url'] ?>assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/js/scripts.bundle.js" type="text/javascript"></script>
		<!-- End Global Theme Bundle -->

		<!-- Page Vendors (used by this page) -->
		<script src="<?php echo $config['web']['url'] ?>assets/plugins/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/plugins/custom/gmaps/gmaps.js" type="text/javascript"></script>
		<!-- End Page Vendors -->

		<!-- Page Scripts (used by this page) -->
		<script src="<?php echo $config['web']['url'] ?>assets/js/pages/components/charts/line-chart/morris.min.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/js/pages/components/charts/raphael/raphael-min.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/js/pages/custom/chat/chat.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/js/pages/custom/voucher/theme.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/js/pages/custom/voucher/clipboard.min.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/js/pages/custom/wizard/wizard-4.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/js/pages/custom/contacts/list-columns.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/js/pages/crud/datatables/basic/basic.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/js/pages/components/extended/bootstrap-notify.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/js/pages/dashboard.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/js/pages/custom/user/profile.js" type="text/javascript"></script>
		<!-- End Page Scripts -->
	</body>

</html>

        <script>
            $('#news').modal('show');
            function read_news() {
              $.ajax({
                type: "GET",
                url: "<?php echo $config['web']['url'] ?>ajax/read-news.php"
              });
            }
        </script>

<?php 
}
?>
