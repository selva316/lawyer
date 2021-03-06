<?php 
class Userdetailsmodel extends CI_Model {

	public function fetchListOfStatuate()
	{
		$str = "select * from law_statuate";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function courtNameAvailable($name){
				
		$query = $this->db->query("select count(name) as cntname from law_statuate  where (UPPER(name) = '".strtoupper($name)."')");
		
		$data = array();
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['cntname'];//i am not want item code i,eeeeeeeeeeee
		}

		if ($count == 0)
		{
			array_push($data, true);
		}
		else{
			array_push($data, false);
		}
		
		return $data;
	}

	public function statuateDetails($statuateid)
	{
		$str = "select * from law_statuate where disable='N' and STID='".$statuateid."'";
		$query = $this->db->query($str);
		$result = $query->result_array();

		$data = array();
		foreach($result as $row)
		{
			$stid = $row['STID'];
			array_push($data, $stid);
			$name = $row['NAME'];//i am not want item code i,eeeeeeeeeeee
			array_push($data, $name);
			$description = $row['DESCRIPTION'];
			array_push($data, $description);
		}

		return $data;
	}

	public function courtShortNameAvailable($shortname){
				
		$query = $this->db->query("select count(SHORTNAME) as cntname from law_courttype  where (UPPER(SHORTNAME) = '".strtoupper($shortname)."')");
		
		$data = array();
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['cntname'];//i am not want item code i,eeeeeeeeeeee
		}

		if ($count == 0)
		{
			array_push($data, true);
		}
		else{
			array_push($data, false);
		}
		
		return $data;
	}

	public function insertStatuate($courtName, $court_type){
		
		$role = $this->session->userdata('role');

		$data = array();
		$data['NAME'] = $courtName;
		$data['DESCRIPTION'] = $court_type;
		
		if($role == 'Admin')
			$data['ROLE'] = 'Admin';
		else
			$data['ROLE'] = 'User';

		$data['USERID'] = $this->session->userdata('userid');

		$data['DISABLE'] = 'N';		

		$this->db->insert('law_statuate', $data); 
		$autoid = $this->db->insert_id();
		
		$this->db->where('id', $autoid);
		$ctid = 'ST'.$autoid;
		
		$this->db->set('STID', $ctid);
			
		$this->db->update('law_statuate');

		$dArray = array();
		array_push($dArray, true);
		return $dArray;
		
	}

	public function updateUserDetails($name, $description, $stid){
	
		$role = $this->session->userdata('role');
		if($role == 'Admin')
			$roleval = 'Admin';
		else
			$roleval = 'User';

		$this->db->where('STID', $stid);

		$this->db->set('NAME', $name);
		$this->db->set('DESCRIPTION', $description);
		$this->db->set('USERID', $this->session->userdata('userid'));
		$this->db->set('DISABLE', 'N');
		$this->db->set('ROLE', $roleval);

		$this->db->update('law_statuate');

		$dArray = array();
		array_push($dArray, true);
		return $dArray;

	}
	
	public function disableUserDetails($userid)
	{
		$query = $this->db->query("select disable from law_login where (UPPER(USERID) = '".strtoupper($userid)."')");
		
		$data = array();
		
		$disable = 'N';
		$result = $query->result_array();
		foreach($result as $row)
		{
			$disable = $row['disable'];//i am not want item code i,eeeeeeeeeeee
		}

		if($disable == 'N')
			$disable = 'Y';
		else
			$disable = 'N';

		$this->db->where('USERID', $userid);
		$this->db->set('DISABLE', $disable);

		$this->db->update('law_login');

		$dArray = array();
		array_push($dArray, true);
		return $dArray;
	}

	public function userAvailable($username)
	{
		$query = $this->db->query("select count(username) as cntname from law_login  where (lower(username) = '".strtolower($username)."')");
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['cntname'];//i am not want item code i,eeeeeeeeeeee
		}

		if ($count == 0)
		{
			return 'true';
		}
		else{
			return 'false';
		}
		
	}

	public function insertUser($data)
	{
		$this->db->insert('law_login', $data); 
		$autoid = $this->db->insert_id();
		
		$this->db->where('id', $autoid);
		$userid = 'USR'.$autoid;
		$this->db->set('USERID', $userid);
		$this->db->update('law_login');
		return true;		
	}

	public function updateUser($data, $userid)
	{
		$this->db->where('USERID', $userid);
		$this->db->update('law_login',$data);
		return true;
	}

	public function fetchUserIdDetails($userid)
	{
		$str = "select * from law_login where userid='".$userid."'";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function findUsername($userid)
	{
		$query = $this->db->query("select username from law_login  where (lower(userid) = '".strtolower($userid)."')");
		
		$username = '';
		$result = $query->result_array();
		foreach($result as $row)
		{
			$username = $row['username'];//i am not want item code i,eeeeeeeeeeee
		}
		return $username;	
	}
}

/* End of file Configurationmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */