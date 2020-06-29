<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testing extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->tweet = array();
		$this->load->helper('url');
		$this->load->model('training_model');
		$this->load->model('testing_model');		
	}

	public function index()
	{
		$data['testing']=$this->testing_model->get_data_testing()->result();
		$this->load->view('testing', $data);
	}
	public function insert_data_testing(){
		$data['tweet']=htmlspecialchars($_POST['tweet']);
		$data['sentimen']=htmlspecialchars($_POST['sentimen']);

		$dokumen=array_filter(explode(" ", $data['tweet']), function ($value) {
			return $value !== '';
		});

		$kalimat = array();
		for ($i=0; $i < sizeof($dokumen); $i++) { 
			$kata = $this->training_model->replace_tidak_baku($dokumen[$i]);
			if ($kata=="0") {
				// echo $dokumen[$i];
				array_push($kalimat, $dokumen[$i]);

			}else{
				// echo $kata;
				array_push($kalimat, $kata);
			}

		}
		$data['tweet'] = implode(" ", $kalimat);
		$data['hasil_preprocessing'] = $this->stopword($this->stem($this->tokenization($this->transform_case($data['tweet']))));
		
		// end pembakuan kata
		// echo $kalimat1;
		$this->testing_model->insert_data_testing($data);
		redirect(base_url('/testing')); 
	}
	public function delete_data_testing($id){
		$this->testing_model->delete_data_testing($id);
		redirect(base_url('/testing'));
	}

	public function transform_case($kalimat){
		return strtolower($kalimat);
	}

	public function tokenization($kalimat){
		$kalimat = preg_replace('/@\w+\s*/', ' ', $kalimat);
		$kalimat = preg_replace('/#\w+\s*/', ' ', $kalimat);
		$kalimat = str_replace(",", ' ', $kalimat);
        $kalimat = str_replace('"', ' ', $kalimat);
        $kalimat = str_replace('.', ' ', $kalimat);
        $kalimat = str_replace("'", ' ', $kalimat);
		$kalimat = preg_replace('/[^A-Za-z]/', ' ', $kalimat);
		return $kalimat;
	}

	public function stem($kalimat){
		// require_once __DIR__ . '\vendor\autoload.php';
		// create stemmer
		// cukup dijalankan sekali saja, biasanya didaftarkan di service container
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();


 		$kalimat = preg_replace('/@\w+\s*/', '', $kalimat);
		$kalimat = preg_replace('/#\w+\s*/', '', $kalimat);

		// stem
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

	public function test(){
		$this->term = array();
		$data=$this->training_model->get_data_training()->result();
		foreach ($data as $key) {
			$a = explode(" ", $key->hasil_preprocessing);
			for ($i=0; $i < sizeof($a) ; $i++) { 
				array_push($this->term, $a[$i]);
			}
			
		}
		echo json_encode($this->term);
	}
}