<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classify extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('training_model');
		$this->load->model('testing_model');		
		$this->load->library('session');
	}

	public function index(){
		if(isset ($_POST['nilai_k'])){
			$k = htmlspecialchars($_POST['nilai_k']);
			$this->session->set_userdata('nilai_k', $k);
			$testing = $this->testing_model->get_data_testing()->result();
			$training = $this->training_model->get_data_training()->result();
			$data['jumlah_data_latih']=$this->training_model->count_data();
			$data['jumlah_data_uji']=$this->testing_model->count_data();
			$dokumen = array_merge($training,$testing);
			$array = array();
			$sentimen_benar = 0;
			$aba = array();
			foreach ($testing as $key) {
				$b = [$key];
				$array = array_merge($training,$b);
				unset($b);
				$a = $this->get_term($array);
				// echo $this->a($array);
				$b = $this->pembobotan_kata($a, $array,$k);
				array_push($aba, array('id' => $key->id, 'tweet'=>$key->tweet,'sentimen'=>$key->sentimen,'sentimen_knn' => $b));
				if($key->sentimen == $b){
					$sentimen_benar++;
				}
	 		}
	 		$akurasi = ($sentimen_benar/sizeof($testing))*100;
	 		$data['hasil_klasifikasi'] = $aba;
	 		$data['akurasi']=$akurasi;
	 		$data['nilai_k']=$k;
	 		$this->load->view('classify',$data);
		}else{
			$this->load->view('set_k');
		}

	}
	public function detail($id){
		$testing = $this->testing_model->get_data_testing_by_id($id)->result();
		$training = $this->training_model->get_data_training()->result();
		$data['nilai_k'] = 3;
		$data['testing'] = $testing;
		$data['training'] = $training;
		$dokumen = array_merge($training,$testing);
		$array = array();
		$sentimen_benar = 0;
		$aba = array();
		foreach ($testing as $key) {
			$b = [$key];
			$array = array_merge($training,$b);
			unset($b);
			$a = $this->get_term($array);
			// echo $this->a($array);
			$b = $this->detail_proses($a, $array, 3);
			$c = $this->cossim($array, $b);
			// $b = $this->pembobotan_kata($a, $array,$k);
			array_push($aba, array('id' => $key->id, 'tweet'=>$key->tweet,'sentimen'=>$key->sentimen,'sentimen_knn' => $b));
			if($key->sentimen == $b){
				$sentimen_benar++;
			}
	 	}
	 	$data['nilai']=$b;
	 	$data['cossim']=$c;
	 	arsort($data['cossim']);
	 	$data['jumlah_term']=$this->jumlah_term;
	 	// echo json_encode($data['cossim']);
	 	// echo $k;
	 	// $this->load->view('hai',$data);
	 	$this->load->view('detail',$data);
		// $this->detail_proses($);
	}

	public function get_term($dokumen){
		$term = array();
		foreach ($dokumen as $key) {
			$a = explode(" ", $key->hasil_preprocessing);
			for ($i=0; $i < sizeof($a) ; $i++) { 
				array_push($term, $a[$i]);
			}
			
		}
		return $term;
	}
	public function detail_proses($term, $dokumen, $k){
		$l=0;
		$table1=array();
		$search=array();
		foreach ($term as $key) {
			if (array_search($key, $search)===false) {
				$dok=0;
				$table1[$l]['term']=$key;
				$table1[$l]['term_frq']=array();
				$table1[$l]['term_frq_log']=array();

                //tf
				foreach ($dokumen as $key1) {
					array_push($table1[$l]['term_frq'], substr_count($key1->hasil_preprocessing, $key));


					++$dok;
				}

                //tf norm
				foreach ($dokumen as $key1) {
					$a = 0;
					if(substr_count($key1->hasil_preprocessing, $key)!=0){
						$a = round(1+log(substr_count($key1->hasil_preprocessing, $key),10),4);
					}
					array_push($table1[$l]['term_frq_log'], $a);


					++$dok;
				}

				$table1[$l]['df']=(int) array_sum($table1[$l]['term_frq']);
				$table1[$l]['idf']=array();

                //idf
				for ($i=0; $i < $l+1; $i++) { 
					$table1[$i]['idf'] = round(log(@(sizeof($dokumen)/json_encode($table1[$i]['df'])),10),4);                    
				}

                //wfidf
				$table1[$l]['wfidf']=array();
				for ($i=0; $i <$l+1 ; $i++) {
					for ($j=0; $j < sizeof($table1[$i]['term_frq_log']); $j++) { 
						$table1[$i]['wfidf'][$j] = round(json_encode($table1[$i]['term_frq_log'][$j])*json_encode($table1[$i]['idf']),4);
					} 
				}

				++$l;

			}
			array_push($search, trim(strtolower($key)));
		}

		$data = $table1;

		unset($table1);
		$this->jumlah_term = $l;
		return $data;
        
		
	}
	public function cossim($dokumen, $table1){
		$cossim = array();

        //cossim
        $i = 0;
        $l = $this->jumlah_term;
		foreach ($dokumen as $key ) {
        	# code...
        // index dokumen
			// for ($i=0; $i < sizeof($dokumen)-1 ; $i++) {
				
				$atas = 0;
				$bawah1 = 0;
				$bawah2 = 0;
            // index term
				for ($j=0; $j<$l ; $j++) { 
					$atas += round((json_encode(@((float)$table1[$j]['wfidf'][$i])*(float)json_encode($table1[$j]['wfidf'][sizeof($dokumen)-1]))),4);

					$bawah1 += round(pow(json_encode($table1[$j]['wfidf'][$i]), 2),4);
					$bawah2 += round(pow(json_encode($table1[$j]['wfidf'][sizeof($dokumen)-1]), 2),4);

				} 
            // echo $atas."<br>";
				$pembagi1 = round(sqrt($bawah1),4);
				$pembagi2 = round(sqrt($bawah2),4);
				$pembagifix = round($pembagi1*$pembagi2,4);
            // echo $pembagifix."<br>";
				
				if($i==sizeof($dokumen)-1){
					break;
				}else{
					$i++;
					$cossim += [$key->id => [round($atas/$pembagifix,4), $key->sentimen]];
				}
            // echo "dok".($i+1)." = ".$cossim."<br>";
				// echo $atas." ";
			}
		$data = $cossim;
		return $data;
	}
	public function pembobotan_kata($term, $dokumen,$k)
	{
		$l=0;
		$table1=array();
		$search=array();
		foreach ($term as $key) {
			if (array_search($key, $search)===false) {
				$dok=0;
				$table1[$l]['term']=$key;
				$table1[$l]['term_frq']=array();
				$table1[$l]['term_frq_log']=array();

                //tf
				foreach ($dokumen as $key1) {
					array_push($table1[$l]['term_frq'], substr_count($key1->hasil_preprocessing, $key));


					++$dok;
				}

                //tf norm
				foreach ($dokumen as $key1) {
					$a = 0;
					if(substr_count($key1->hasil_preprocessing, $key)!=0){
						$a = 1+log(substr_count($key1->hasil_preprocessing, $key),10);
					}
					array_push($table1[$l]['term_frq_log'], $a);


					++$dok;
				}

				$table1[$l]['df']=(int) array_sum($table1[$l]['term_frq']);
				$table1[$l]['idf']=array();

                //idf
				for ($i=0; $i < $l+1; $i++) { 
					$table1[$i]['idf'] = log(@(sizeof($dokumen)/json_encode($table1[$i]['df'])),10);                    
				}

                //wfidf
				$table1[$l]['wfidf']=array();
				for ($i=0; $i <$l+1 ; $i++) {
					for ($j=0; $j < sizeof($table1[$i]['term_frq_log']); $j++) { 
						$table1[$i]['wfidf'][$j] = json_encode($table1[$i]['term_frq_log'][$j])*json_encode($table1[$i]['idf']);
					} 
				}

				++$l;

			}
			array_push($search, trim(strtolower($key)));
		}

        // echo json_encode($table1[0]['term_frq_log'][9])*json_encode($table1[0]['idf']);

        // echo sizeof($table1[0]['wfidf']);        
        // echo json_encode($table1)."<br>";
		for ($j=0; $j<$l ; $j++) {
			unset($table1[$j]['term_frq']);
			unset($table1[$j]['term_frq_log']);
			unset($table1[$j]['df']);
			unset($table1[$j]['idf']);
		}
		$cossim = array();

        //cossim
        $i = 0;
		foreach ($dokumen as $key ) {
        	# code...
        // index dokumen
			// for ($i=0; $i < sizeof($dokumen)-1 ; $i++) {
				
				$atas = 0;
				$bawah1 = 0;
				$bawah2 = 0;
            // index term
				for ($j=0; $j<$l ; $j++) { 
					$atas += (json_encode(@((float)$table1[$j]['wfidf'][$i])*(float)json_encode($table1[$j]['wfidf'][sizeof($dokumen)-1])));
					$bawah1 += pow(json_encode($table1[$j]['wfidf'][$i]), 2);
					$bawah2 += pow(json_encode($table1[$j]['wfidf'][sizeof($dokumen)-1]), 2);

				} 
            // echo $atas."<br>";
				$pembagi1 = sqrt($bawah1);
				$pembagi2 = sqrt($bawah2);
				$pembagifix = $pembagi1*$pembagi2;
            // echo $pembagifix."<br>";
				$cossim += [$key->id => [$atas/$pembagifix, $key->sentimen]];
				if($i==sizeof($dokumen)-2){
					break;
				}else{
					$i++;
				}
            // echo "dok".($i+1)." = ".$cossim."<br>";

			}
		// }

        //endcossim
		unset($table1);
		arsort($cossim);
		$pointer = 0;
		$vote = array();
		foreach ($cossim as $key) {
			if($pointer==$k){
				break;
			}else{
				array_push($vote,$key[1]);
				$pointer++;
			}
			
		}
		
		unset($cossim);
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

		// echo json_encode($cossim);
		// return $vote_negatif;
		if ($vote_positif > $vote_negatif) {
			return 1;
		}else{
			return 2;
		}
		// $vote_negatif = $vote["2"];
		
		// echo json_encode($vote);

		// echo $vote_positif." ".$vote_negatif;
		// echo "<br><br>";
        // return json_encode($cossim);
		// echo json_encode($cossim);
		
        // echo json_encode($table1[0]['wfidf'][0])*json_encode($table1[0]['wfidf'][9]);
        // echo json_encode($table1[0]['wfidf'][8]);
	}

}
