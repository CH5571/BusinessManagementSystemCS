<?php 
Class Table extends CI_Model {

	public function addCustomer(){

	}

	public function editCustomer(){

	}

	public function deleteCustomer(){

	}

	public function addMaterial(){

	}

	public function editMaterial(){

	}

	public function deleteMaterial(){

	}

	public function addJob(){

	}

	public function editJob(){

	}

	public function deleteJob(){

	}

	public function getUsers(){
		$this->db->select('username, email, created_on');
		$this->db->from('users');
		$query = $this->db->get();

		return $query->result();
	}

}
?>