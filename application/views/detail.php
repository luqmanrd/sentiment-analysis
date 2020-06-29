<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// echo $testing[0]->tweet;
// echo $nilai[0]['term'];
// echo $nilai[0]['term_frq_log']['0'];
// echo $jumlah_term;
$i = 1;
arsort($cossim);
$pointer = 0;
$vote = array();
foreach ($cossim as $key) {
	if($pointer==$nilai_k){
		break;
	}else{
		array_push($vote,$key[1]);
		$pointer++;
	}

}
unset($table1);
		// echo json_encode($vote);
$vote = array_count_values($vote);
if(isset($vote["1"])){
	$vote_positif = $vote["1"];	
}else{
	$vote_positif = 0;
}
if(isset($vote["2"])){
	$vote_negatif = $vote["2"];	
}else{
	$vote_negatif = 0;
}
if ($vote_positif > $vote_negatif) {
	$hasil_klasifikasi = 1;
}elseif ($vote_negatif > $vote_positif) {
	$hasil_klasifikasi = 2;
}
if($testing[0]->sentimen==$hasil_klasifikasi){
	$akurasi = "Benar";
}else{
	$akurasi = "Salah";
}
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
							<h3 class="page-title">Klasifikasi K-NN - Detail</h3>
						</div>
					</div>
					<!-- End Page Header -->
					<div class="row">
						<div class="col-lg-8 mb-4">
							<!-- Quick Post -->
							<div class="card card-small h-100">
								<div class="card-header border-bottom">
									<?php
										if($testing[0]->sentimen == 1){
											$testing[0]->sentimen == "Positif";
										}elseif($testing[0]->sentimen == 2){
											$testing[0]->sentimen == "Negatif";
										}
									?>
									<h6 class="m-0">Data Uji - U<?php echo $testing[0]->id; ?> - <?php echo $testing[0]->sentimen;?></h6>
								</div>
								<div class="card-body d-flex flex-column">
									<div>
										<h6><?php echo $testing[0]->tweet; ?></h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-2 mb-4">
							<!-- Quick Post -->
							<div class="card card-small h-100">
								<div class="card-header border-bottom">
									<h6 class="m-0 text-center">Hasil Klasifikasi</h6>
								</div>
								<div class="card-body d-flex flex-column text-center">
									<div>
										<?php 
										if($hasil_klasifikasi==1){
											$hasil_klasifikasi="Positif";
										}elseif ($hasil_klasifikasi==2) {
											$hasil_klasifikasi="Negatif";
										}
										?>
										<h4><strong><?php echo $hasil_klasifikasi; ?></strong></h6>
										</div>
										<?php
										if($akurasi == "Benar"){
											?>
											<div>
												<span class="text-success">
													<i class="material-icons">check</i>
												</span> Benar
											</div>
											<?php
										}else{
											?>
											<div>
												<span class="text-danger">
													<i class="material-icons">clear</i>
												</span> Salah
											</div>
											<?php
										}
										?>
										
									</div>
								</div>
							</div>
						</div>



						<div class="row">
							<div class="col">
								<div class="card card-small mb-4">
									<div class="card-header border-bottom">
										<h6 class="m-0">Cosine Similarity</h6>
									</div>
									<div class="card-body p-0 pb-3 text-center">
										<table class="table mb-0">
											<thead>
												<tr>
													<th scope="col" class="border-0">No</th>
													<th scope="col" class="border-0">ID</th>
													<th scope="col" class="border-0">Cossine Similarity</th>
													<th scope="col" class="border-0">Sentimen</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i=1;
												foreach ($cossim as $key => $value) {
													if($value['1']==1){
														$value['1']="Positif";
													}else{
														$value['1']="Negatif";
													}
													echo "<tr><td>".$i."</td><td>L ".$key."</td><td>".number_format($value['0'],6)."</td><td>".$value['1']."</td></tr>";
													$i++;
												}?>
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
	</body>
	</html>