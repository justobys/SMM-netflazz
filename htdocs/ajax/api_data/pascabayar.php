<?php
$config['web']['url'] = $config['web']['url'];
?>
        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page API Pascabayar -->
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
			                <span class="d-none d-sm-block">Cek Tagihan</span>
			                </a>
			            </li>
			            <li class="nav-item">
			                <a href="#pay" data-toggle="tab" aria-expanded="false" class="nav-link">
			                <span class="d-block d-sm-none"><i class="fa fa-cart-arrow-down text-primary"></i></span>
			                <span class="d-none d-sm-block">Bayar Tagihan</span>
			                </a>
			            </li>
			            <li class="nav-item">
			                <a href="#cancel" data-toggle="tab" aria-expanded="false" class="nav-link">
			                <span class="d-block d-sm-none"><i class="fa fa-times text-primary"></i></span>
			                <span class="d-none d-sm-block">Batalkan</span>
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
            <?php echo $config['web']['url'] ?>api/pascabayar
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
        			"sid": "PLN",
        			"kategori": "PLN",
        			"layanan": "PLN PASCABAYAR",
        			"tipe": "Pascabayar",
        			"status": "Normal"
        		},
        		{
        			"sid": "BPJS",
        			"kategori": "BPJS KESEHATAN",
        			"layanan": "BPJS KESEHATAN",
        			"tipe": "Pascabayar",
        			"status": "Normal"
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
        <h3>Mengecek Tagihan</h3>
        <b>URL Permintaan</b>
        <div class="alert alert-elevate alert-primary">
             <?php echo $config['web']['url'] ?>api/pascabayar
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
        			<td>cek-tagihan</td>
        		</tr>
        		<tr>
        			<td>layanan</td>
        			<td>ID Layanan</a></td>
        		</tr>
        		<tr>
        			<td>target</td>
        			<td>Target Yang Dibutuhkan Sesuai Layanan, Seperti Nomor Pelanggan</td>
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
        		"nama_pelanggan": "Reseller NetFlazz",
        		"admin": "2500"
        	}
        }
        </pre>
        			    </td>
        			    <td>
        <pre>
        {
        	"status": false,
        	"data": {
        		"pesan": "Layanan Tidak Tersedia"
        	}
        }
        </pre>
        <b>Kemungkinan Pesan Yang Ditampilkan:</b>
        <ul>
        	<li>Permintaan Tidak Sesuai</li>
        	<li>API Key Salah</li>
        	<li>Layanan Tidak Ditemukan</li>
        	<li>Saldo Kamu Tidak Mencukupi</li>
        	<li>Layanan Tidak Tersedia</li>
        </ul>
        			    </td>
        		    </tr>
        	    </table>
            </div>
        </div>
        
        <div role="tabpanel" class="tab-pane fade" id="pay">
        <p class="mb-0">
        <h3>Membayar Tagihan</h3>
        <b>URL Permintaan</b>
        <div class="alert alert-elevate alert-primary">
             <?php echo $config['web']['url'] ?>api/pascabayar
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
        			<td>bayar-tagihan</td>
        		</tr>
        		<tr>
        			<td>id</td>
        			<td>ID Pesanan Kamu</td>
        		</tr>
        		<tr>
        			<td>layanan</td>
        			<td>ID Layanan</td>
        		</tr>
        		<tr>
        			<td>target</td>
        			<td>Target Yang Dibutuhkan Sesuai Layanan, Seperti Nomor Pelanggan</td>
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
        		"status": "Success",
        		"catatan": "SN : 09220xxxxxxxx"
        	}
        }
        </pre>
        			    </td>
        			    <td>
        <pre>
        {
        	"status": false,
        	"data": {
        		"pesan": "Kode Pesanan Tidak Di Temukan"
        	}
        }
        </pre>
        <b>Kemungkinan Pesan Yang Ditampilkan:</b>
        <ul>
        	<li>Permintaan Tidak Sesuai</li>
        	<li>API Key Salah</li>
        	<li>Saldo Kamu Tidak Mencukupi</li>
        	<li>Kode Pesanan Tidak Di Temukan</li>
        </ul>
        			    </td>
        		    </tr>
        	    </table>
            </div>
        </div>
        
        <div role="tabpanel" class="tab-pane fade" id="cancel">
        <p class="mb-0">
        <h3>Mengecek Tagihan</h3>
        <b>URL Permintaan</b>
        <div class="alert alert-elevate alert-primary">
             <?php echo $config['web']['url'] ?>api/pascabayar
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
        			<td>batalkan</td>
        		</tr>
        		<tr>
        			<td>id</td>
        			<td>ID Pesanan Kamu</a></td>
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
        		"status": "Error"
        	}
        }
        </pre>
        			    </td>
        			    <td>
        <pre>
        {
        	"status": false,
        	"data": {
        		"pesan": "Kode Pesanan Tidak Di Temukan"
        	}
        }
        </pre>
        <b>Kemungkinan Pesan Yang Ditampilkan:</b>
        <ul>
        	<li>Permintaan Tidak Sesuai</li>
        	<li>API Key Salah</li>
        	<li>Kode Pesanan Tidak Di Temukan</li>
        </ul>
        			    </td>
        		    </tr>
        	    </table>
            </div>
        </div>
        <!-- End Page API Pascabayar -->

        <!-- End Tab Content -->

        <!-- End Content -->