<?php
$config['web']['url'] = $config['web']['url'];
?>
        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page API Social Media -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet kt-portlet--height-fluid">
			        <div class="kt-portlet__body">
			        <ul class="nav nav-tabs">
			            <li class="nav-item">
			                <a href="#service" data-toggle="tab" aria-expanded="false" class="nav-link active">
			                <span class="d-block d-sm-none"><i class="fa fa-list text-primary"></i></span>
			                <span class="d-none d-sm-block">Layanan</span>
			                </a>
			            </li>
			            <li class="nav-item">
			                <a href="#order" data-toggle="tab" aria-expanded="false" class="nav-link">
			                <span class="d-block d-sm-none"><i class="fa fa-shopping-cart text-primary"></i></span>
			                <span class="d-none d-sm-block">Pesanan</span>
			                </a>
			            </li>
			            <li class="nav-item">
			                <a href="#status" data-toggle="tab" aria-expanded="false" class="nav-link">
			                <span class="d-block d-sm-none"><i class="fa fa-search text-primary"></i></span>
			                <span class="d-none d-sm-block">Status</span>
			                </a>
			            </li>
			        </ul>

        <!-- Start Tab Content -->
        <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade active show" id="service">
        <p class="mb-0">
        <h3>Menampilkan Daftar Layanan</h3>
        <b>URL Permintaan</b>
        <div class="alert alert-elevate alert-primary">
            <?php echo $config['web']['url'] ?>api/social-media
        </div>
        <div class="table-responsive">
        	<table class="table table-bordered">
        		<tr>
        			<th width="50%">Parameter</th>
        			<th>Keterangan</th>
        		</tr>
        		<tr>
        			<td>api_key</td>
        			<td>API Key Kamu</td>
        		</tr>
        		<tr>
        			<td>action</td>
        			<td>layanan</td>
        		</tr>
        	</table>
        </div>
        <h4>Contoh Respon Yang Ditampilkan</h4>
            <div class="table-responsive">
        	    <table class="table table-bordered">
        		    <tr>
        			    <th width="50%">Respon Sukses</th>
        			    <th>Respon Gagal</th>
        		    </tr>
        		    <tr>
        			    <td>
        <pre>
        {
        	"status": true,
        	"data": [
        		{
        			"sid": "1",
        			"kategori": "Instagram Followers",
        			"layanan": "Instagram Followers S1",
        			"harga": "10000",
        			"min": "100",
        			"max": "10000",
        			"catatan": "Masukan Username Tanpa @ Example : ryan_tedri"
        		},
        		{
        			"sid": "2",
        			"kategori": "Instagram Likes",
        			"layanan": "Instagram Likes S1",
        			"harga": "10000",
        			"min": "100",
        			"max": "10000",
        			"catatan": "Masukan Link Postingan"
        		},
        	]
        }
        </pre>
        			    </td>
        			    <td>
        <pre>
        {
        	"status": false,
        	"data": {
        		"pesan": "API Key Salah"
        	}
        }
        </pre>
        <b>Kemungkinan Pesan Yang Ditampilkan:</b>
        <ul>
        	<li>Permintaan Tidak Sesuai</li>
        	<li>API Key Salah</li>
        </ul>
        			    </td>
        		    </tr>
        	    </table>
            </div>
        </div>
        
        <div role="tabpanel" class="tab-pane fade" id="order">
        <p class="mb-0">
        <h3>Membuat Pesanan</h3>
        <b>URL Permintaan</b>
        <div class="alert alert-elevate alert-primary">
             <?php echo $config['web']['url'] ?>api/social-media
        </div>
        <div class="table-responsive">
        	<table class="table table-bordered">
        		<tr>
        			<th width="50%">Parameter</th>
        			<th>Keterangan</th>
        		</tr>
        		<tr>
        			<td>api_key</td>
        			<td>API Key Kamu</td>
        		</tr>
        		<tr>
        			<td>action</td>
        			<td>pemesanan</td>
        		</tr>
        		<tr>
        			<td>layanan</td>
        			<td>ID Layanan, Dapat Dilihat Di <a href="<?php echo $config['web']['url']; ?>price-list/social-media" target="blank">Daftar Layanan</a></td>
        		</tr>
        		<tr>
        			<td>target</td>
        			<td>Target Yang Dibutuhkan Sesuai Layanan, Seperti Username / Link Pesanan</td>
        		</tr>
        		<tr>
        			<td>jumlah</td>
        			<td>Jumlah Pemesanan</td>
        		</tr>
        	</table>
        </div>
        <h4>Contoh Respon Yang Ditampilkan</h4>
            <div class="table-responsive">
        	    <table class="table table-bordered">
        		    <tr>
        			    <th width="50%">Respon Sukses</th>
        			    <th>Respon Gagal</th>
        		    </tr>
        		    <tr>
        			    <td>
        <pre>
        {
        	"status": true,
        	"data": {
        		"id": "12345",
        		"start_count": "12345"
        	}
        }
        </pre>
        			    </td>
        			    <td>
        <pre>
        {
        	"status": false,
        	"data": {
        		"pesan": "Saldo Kamu Tidak Mencukupi"
        	}
        }
        </pre>
        <b>Kemungkinan Pesan Yang Ditampilkan:</b>
        <ul>
        	<li>Permintaan Tidak Sesuai</li>
        	<li>API Key Salah</li>
        	<li>Layanan Tidak Ditemukan</li>
        	<li>Jumlah Pesanan Tidak Sesuai</li>
        	<li>Saldo Kamu Tidak Mencukupi</li>
        	<li>Layanan Tidak Tersedia</li>
        </ul>
        			    </td>
        		    </tr>
        	    </table>
            </div>
        </div>
        
        <div role="tabpanel" class="tab-pane fade" id="status">
        <p class="mb-0">
        <h3>Mengecek Status Pesanan</h3>
        <b>URL Permintaan</b>
        <div class="alert alert-elevate alert-primary">
             <?php echo $config['web']['url'] ?>api/social-media
        </div>
        <div class="table-responsive">
        	<table class="table table-bordered">
        		<tr>
        			<th width="50%">Parameter</th>
        			<th>Keterangan</th>
        		</tr>
        		<tr>
        			<td>api_key</td>
        			<td>API Key Kamu</td>
        		</tr>
        		<tr>
        			<td>action</td>
        			<td>status</td>
        		</tr>
        		<tr>
        			<td>id</td>
        			<td>ID Pesanan Kamu</td>
        		</tr>
        	</table>
        </div>
        <h4>Contoh Respon Yang Ditampilkan</h4>
            <div class="table-responsive">
        	    <table class="table table-bordered">
        		    <tr>
        			    <th width="50%">Respon Sukses</th>
        			    <th>Respon Gagal</th>
        		    </tr>
        		    <tr>
        			    <td>
        <pre>
        {
        	"status": true,
        	"data": {
        		"status": "Processing",
        		"start_count": "12345",
        		"remains": "12345"
        	}
        }
        </pre>
        <b>Kemungkinan Status Yang Ditampilkan:</b>
        <ul>
        	<li>Pending</li>
        	<li>Processing</li>
        	<li>Partial</li>
        	<li>Error</li>
        	<li>Success</li>
        </ul>
        			    </td>
        			    <td>
        <pre>
        {
        	"status": false,
        	"data": {
        		"pesan": "ID Pesanan Tidak Di Temukan"
        	}
        }
        </pre>
        <b>Kemungkinan Pesan Yang Ditampilkan:</b>
        <ul>
        	<li>Permintaan Tidak Sesuai</li>
        	<li>API Key Salah</li>
        	<li>ID Pesanan Tidak Di Temukan</li>
        </ul>
        			    </td>
        		    </tr>
        	    </table>
            </div>
        </div>
        <!-- End Page API Social Media -->

        <!-- End Tab Content -->

        <!-- End Content -->