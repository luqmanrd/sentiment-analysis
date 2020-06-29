<?php  
class testing_model extends CI_Model {  
	function __construct()  
	{  
	    parent::__construct();  
	    $this->load->database();  
	}  
	public function get_data_testing(){  
	    return $this->db->get('data_uji');
	}
	public function get_data_testing_by_id($id){  
		$this->db->where('id',$id);
	    return $this->db->get('data_uji');
	}
	public function insert_data_testing($data) {
		$this->db->insert('data_uji', $data);
	}
	public function delete_data_testing($id){
		$this->db->where('id',$id);
		$this->db->delete('data_uji');
	}
	public function count_data(){
		$q = $this->db->query("SELECT COUNT(*) as `jumlah` FROM `data_uji` ");
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