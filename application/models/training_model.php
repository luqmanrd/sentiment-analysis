<?php  
class training_model extends CI_Model {  
	function __construct()  
	{  
	    parent::__construct();  
	    $this->load->database();  
	}  
	public function get_data_training(){  
		// $this->db->limit(10);
	    return $this->db->get('data_latih');
	}
	public function insert_data_training($data) {
		$this->db->insert('data_latih', $data);
	}
	public function delete_data_training($id){
		$this->db->where('id',$id);
		$this->db->delete('data_latih');
	}
	public function count_data(){
		$q = $this->db->query("SELECT COUNT(*) as `jumlah` FROM `data_latih` ");
		return $q->result();
	}
	public function count_positif(){
		$q = $this->db->query("SELECT COUNT(*) as `jumlah_positif` FROM `data_latih` WHERE `sentimen`=1");
		return $q->result();
	}
	public function count_negatif(){
		$q = $this->db->query("SELECT COUNT(*) as `jumlah_negatif` FROM `data_latih` WHERE `sentimen`=2");
		return $q->result();
	}
	public function replace_tidak_baku($kata){
		$q = $this->db->query("SELECT `baku` FROM `kata_baku` WHERE `tidak_baku` = '".$kata."'");
		$result = $q->row();
		if ($q->num_rows() == 1) {
			return $result->baku;
		}else{
			return 0;
		}
	}
}