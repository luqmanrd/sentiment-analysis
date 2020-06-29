<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('training_model');
		$this->load->model('testing_model');		
		$this->load->library('session');
	}
	public function index(){
		
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