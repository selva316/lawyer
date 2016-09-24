<?php 
class Logindetailsmodel extends CI_Model {

	
	public function useravailable()
	{
		$this->db->where('username', strtolower($this->input->post('j_username')));
		$this->db->where('password', md5($this->input->post('j_password')));
		$this->db->where('disable','N');
		$query = $this->db->get('law_login');
		
		if($query->num_rows == 1){
			return true;
		}
	}
	
	public function userrole($userid)
	{
		$str = "select role from law_login where username=?";
		$query = $this->db->query($str,array($userid));
		// return $query->result();
		$role='';
		foreach($query->result() as $row)
		{
			$role = $row->role;
		}
		return $role;
	}
	
	public function username($userid)
	{
		$str = "select firstname, lastname from law_login where username=?";
		$query = $this->db->query($str,array($userid));
		// return $query->result();
		$username='';
		foreach($query->result() as $row)
		{
			$username = ucfirst($row->firstname)." ".ucfirst($row->lastname);
		}
		return $username;
	}

	public function userid($userid)
	{
		$str = "select userid from law_login where username=?";
		$query = $this->db->query($str,array($userid));
		// return $query->result();
		$userid='';
		foreach($query->result() as $row)
		{
			$userid = $row->userid;
		}
		return $userid;
	}

	public function session_tracking($data)
	{
		$this->db->insert('law_sessions', $data); 
		$autoid = $this->db->insert_id();
	
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
}

/* End of file Logindetailsmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */