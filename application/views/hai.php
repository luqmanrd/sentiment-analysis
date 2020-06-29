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
	echo $pointer."<br>";

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

echo $vote_positif."<br>";
echo $vote_negatif."<br>";

if ($vote_positif > $vote_negatif) {
	$hasil_klasifikasi = 1;
}elseif ($vote_negatif > $vote_positif) {
	$hasil_klasifikasi = 2;
}

echo $hasil_klasifikasi."<br>";

if($testing[0]->sentimen==$hasil_klasifikasi){
	$akurasi = "Benar";
}else{
	$akurasi = "Salah";
}

echo $akurasi."<br>";

?>