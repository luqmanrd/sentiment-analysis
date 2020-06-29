<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html class="no-js h-100" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Analisis Sentimen - SIAM Universitas Brawijaya</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="<?php echo base_url('/assets/images/ub-logo.png')?>">
	<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="<?php echo base_url('/assets/styles/shards-dashboards.1.1.0.min.css')?>">
	<link rel="stylesheet" href="<?php echo base_url('/assets/styles/extras.1.1.0.min.css')?>">
	<script async defer src="https://buttons.github.io/buttons.js"></script>
	<style type="text/css">
	.btn-circle {
		width: 30px;
		height: 30px;
		padding: 6px 0px;
		border-radius: 50%;
		text-align: center;
		font-size: 12px;
		line-height: 1.42857;
	}
</style>
</head>
<body class="h-100">

	<div class="container-fluid">
		<div class="row">
			<!-- Main Sidebar -->
			<aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
				<div class="main-navbar">
					<nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
						<a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
							<div class="d-table m-auto">
								<img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="<?php echo base_url('/assets/images/ub-logo.png')?>">
								<span class="d-none d-md-inline ml-1">Analisis Sentimen</span>
							</div>
						</a>
						<a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
							<i class="material-icons">&#xE5C4;</i>
						</a>
					</nav>
				</div>
				<div class="nav-wrapper">
					<ul class="nav flex-column">
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url('')?>">
								<i class="material-icons">folder</i>
								<span>Data Latih</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " href="<?php echo base_url('/testing')?>">
								<i class="material-icons">vertical_split</i>
								<span>Data Uji</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" href="<?php echo base_url('/classify')?>">
								<i class="material-icons">fast_forward</i>
								<span>Klasifikasi</span>
							</a>
						</li>
					</ul>
				</div>
			</aside>
			<!-- End Main Sidebar -->
			<main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
				<div class="main-navbar sticky-top bg-white">
					<!-- Main Navbar -->
				</div>
				<!-- / .main-navbar -->
				<div class="main-content-container container-fluid px-4">
					<!-- Page Header -->
					<div class="page-header row no-gutters py-4">
						<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
							<span class="text-uppercase page-subtitle">Dashboard</span>
							<h3 class="page-title">Klasifikasi K-NN</h3>
						</div>
					</div>
					<!-- End Page Header -->

					<div class="row">
						<div class="col-lg col-md-6 col-sm-6 mb-4">
							<div class="stats-small stats-small--1 card card-small">
								<div class="card-body p-0 d-flex">
									<div class="d-flex flex-column m-auto">
										<div class="stats-small__data text-center">
											<span class="stats-small__label text-uppercase">Data Uji</span>
											<h6 class="stats-small__value count my-3"><?php echo $jumlah_data_uji[0]->jumlah;?></h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg col-md-6 col-sm-6 mb-4">
							<div class="stats-small stats-small--1 card card-small">
								<div class="card-body p-0 d-flex">
									<div class="d-flex flex-column m-auto">
										<div class="stats-small__data text-center">
											<span class="stats-small__label text-uppercase">Data Latih</span>
											<h6 class="stats-small__value count my-3"><?php echo $jumlah_data_latih[0]->jumlah;?></h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg col-md-4 col-sm-6 mb-4">
							<div class="stats-small stats-small--1 card card-small">
								<div class="card-body p-0 d-flex">
									<div class="d-flex flex-column m-auto">
										<div class="stats-small__data text-center">
											<span class="stats-small__label text-uppercase">Nilai K</span>
											<h6 class="stats-small__value count my-3"><?php echo $nilai_k;?></h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg- col-md-4 col-sm-12 mb-4">
							<div class="stats-small stats-small--1 card card-small">
								<div class="card-body p-0 d-flex">
									<div class="d-flex flex-column m-auto">
										<div class="stats-small__data text-center">
											<span class="stats-small__label text-uppercase">Akurasi</span>
											<h6 class="stats-small__value count my-3"><?php echo (int) $akurasi;?>%</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="card card-small mb-4">
								<div class="card-header border-bottom">
									<h6 class="m-0">Hasil Klasifikasi</h6>
								</div>
								<div class="card-body p-0 pb-3 text-center">
									<table class="table mb-0">
										<thead class="bg-light">
											<tr>
												<th scope="col" class="border-0">ID</th>
												<th scope="col" class="border-0">Tweet</th>
												<th scope="col" class="border-0">Sentimen</th>
												<th scope="col" class="border-0">Hasil Klasifikasi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											for($i = 0; $i < sizeof($hasil_klasifikasi); $i++){ 
												if ($hasil_klasifikasi[$i]['sentimen'] == 2) {
													$hasil_klasifikasi[$i]['sentimen'] = "Negatif";
												}else{
													$hasil_klasifikasi[$i]['sentimen'] = "Positif";
												}
												if ($hasil_klasifikasi[$i]['sentimen_knn'] == 2) {
													$hasil_klasifikasi[$i]['sentimen_knn'] = "Negatif";
												}else{
													$hasil_klasifikasi[$i]['sentimen_knn'] = "Positif";
												}
												?>
												<tr>
													<td>T<?php echo $hasil_klasifikasi[$i]['id']?></td>
													<td style="text-align: left;"><?php echo $hasil_klasifikasi[$i]['tweet']?></td>
													<td><?php echo $hasil_klasifikasi[$i]['sentimen']?></td>
													<td><?php echo $hasil_klasifikasi[$i]['sentimen_knn']?></td>
													<td>
														<button onclick="window.location.href = '<?php echo base_url('/classify/detail/'.$hasil_klasifikasi[$i]['id']) ?>';" class="btn btn-primary btn-sm btn-circle">
															<i class="material-icons">more_horiz</i>  
														</button>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Small Stats Blocks -->


				<footer class="main-footer d-flex p-2 px-3 bg-white border-top">
					<span class="copyright ml-auto my-auto mr-2">Made with &hearts; by
						<a href="http://twitter.com/luqman_rd" rel="nofollow"> luqmanrd</a>
					</span>
				</footer>
			</main>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
	<script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
	<script src="<?php echo base_url('/assets/scripts/extras.1.1.0.min.js')?>"></script>
	<script src="<?php echo base_url('/assets/scripts/shards-dashboards.1.1.0.min.js')?>"></script>
	<script src="<?php echo base_url('/assets/scripts/app/app-blog-overview.1.1.0.js')?>"></script>
	<script type="text/javascript">
		var ctx = document.getElementById("data-training-statistics").getContext("2d");
    // tampilan chart
    var piechart = new Chart(ctx,{type: 'pie',
    	data : {
        // label nama setiap Value
        labels:[
        'Positif',
        'Negatif'
        ],
        datasets: [{
          // Jumlah Value yang ditampilkan
          data:[<?php echo $jumlah_positif[0]->jumlah_positif;?>,<?php echo $jumlah_negatif[0]->jumlah_negatif;?>],
          backgroundColor:[
          'rgba(0, 100, 230, 0.75)',
          'rgba(230, 134, 0, 0.75)'
          ]
      }],
  }
});

</script>
</body>
</html>
<?php 
$t=time(); 
echo($t . "<br>");
?>