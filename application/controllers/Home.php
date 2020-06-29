<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('training_model');		
	}

	public function index()
	{
		$data['training']=$this->training_model->get_data_training()->result();
		$data['jumlah_positif']=$this->training_model->count_positif();
		$data['jumlah_negatif']=$this->training_model->count_negatif();
		$this->load->view('home', $data);
	}
	public function insert_data_training(){
		$data['tweet']=htmlspecialchars($_POST['tweet']);
		$data['sentimen']=htmlspecialchars($_POST['sentimen']);
		
		// start pembakuan kata
		// $dokumen=array_filter(explode(" ", $data['tweet']), function ($value) {
		// 	return $value !== '';
		// });

		// $kalimat = array();
		// for ($i=0; $i < sizeof($dokumen); $i++) { 
		// 	$kata = $this->training_model->replace_tidak_baku($dokumen[$i]);
		// 	if ($kata=="0") {
		// 		// echo $dokumen[$i];
		// 		array_push($kalimat, $dokumen[$i]);

		// 	}else{
		// 		// echo $kata;
		// 		array_push($kalimat, $kata);
		// 	}
		// }

		// $data['tweet'] = implode(" ", $kalimat);
		$tweet = $this->stem($data['tweet']);
		echo $tweet;
		// $data['hasil_preprocessing'] = $this->stopword($this->stem($this->tokenization($this->transform_case($data['tweet']))));
		
		// end pembakuan kata
		// echo $kalimat1;
		// $this->training_model->insert_data_training($data);
		// redirect(base_url()); 
	}
	public function delete_data_training($id){
		$this->training_model->delete_data_training($id);
		redirect(base_url());
	}


	public function transform_case($kalimat){
		return strtolower($kalimat);
	}

	public function tokenization($kalimat){
		$kalimat = preg_replace('/@\w+\s*/', ' ', $kalimat);
		$kalimat = preg_replace('/#\w+\s*/', ' ', $kalimat);
		$kalimat = preg_replace('/\b((https?|ftp|file):\/\/|www\.)[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', ' ', $kalimat);
		$kalimat = str_replace(",", ' ', $kalimat);
        $kalimat = str_replace('"', ' ', $kalimat);
        $kalimat = str_replace('.', ' ', $kalimat);
        $kalimat = str_replace("'", ' ', $kalimat);
		$kalimat = preg_replace('/[^A-Za-z]/', ' ', $kalimat);
		return $kalimat;
	}

	public function stem($kalimat){
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();
		$output   = $stemmer->stem($kalimat);
		return $output;
		// ekonomi indonesia sedang dalam tumbuh yang bangga

		// echo $stemmer->stem('Mereka meniru-nirukannya') . "\n";
		// // mereka tiru
	}

	public function stopword($kalimat){
		//stopword
		$stopWordRemoverFactory = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
		$stopword = $stopWordRemoverFactory->createStopWordRemover();
		$outputstopword = $stopword->remove($kalimat);
		return $outputstopword;
		// Perekonomian Indonesia sedang pertumbuhan membanggakan
	}
	

}
