<?php 
class Listofstatuatesubsectionmodel extends CI_Model {

	public function fetchListOfStatuateSubSection()
	{
		$str = "select * from law_statuate_sub_section";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchUserListOfStatuateSubSection()
	{
		$userid = $this->session->userdata('userid');
		$query = $this->db->query("select ls.NAME as sname, ls.STID as sstid from law_statuate ls left join law_statuate_sub_section lsss  on ls.STID=lsss.STID where (ls.userid='$userid' or ls.role='Admin') ");

		$data = array();
		$result = $query->result_array();
		foreach($result as $row)
		{
			$data[$row['sstid']] = $row['sname'];
			
		}
		return $data;
	}

	public function subsectionNameAvailable($statuateid, $subsectionname){
		
		$userid = $this->session->userdata('userid');			
		$query = $this->db->query("select count(name) as cntname from law_statuate_sub_section  where (UPPER(stid) = '".strtoupper($statuateid)."') AND (UPPER(name) = '".strtoupper($subsectionname)."') AND (userid='$userid' or role='Admin')");
		
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

	public function insertSubSection($statuateid, $subsectionname){

		$role = $this->session->userdata('role');

		$subsectionexplore = explode(',', $subsectionname);
		foreach ($subsectionexplore as $subval) {
			$data = array();

			$data['STID'] = $statuateid;
			$data['DESCRIPTION'] = $subval;
			$data['NAME'] = $subval;
			
			if($role == 'Admin')
				$data['ROLE'] = 'Admin';
			else
				$data['ROLE'] = 'User';

			$data['USERID'] = $this->session->userdata('userid');

			$data['DISABLE'] = 'N';		

			$this->db->insert('law_statuate_sub_section', $data); 
			$autoid = $this->db->insert_id();
			
			$this->db->where('id', $autoid);
			$ctid = 'SS'.$autoid;
			
			$this->db->set('SSID', $ctid);
				
			$this->db->update('law_statuate_sub_section');
		}

		$dArray = array();
		array_push($dArray, true);
		return $dArray;
	}

	public function subsectionDetails($ssid)
	{
		$str = "select * from law_statuate_sub_section where disable='N' and SSID='".$ssid."'";
		$query = $this->db->query($str);
		$result = $query->result_array();

		$data = array();
		foreach($result as $row)
		{
			$ssid = $row['SSID'];
			array_push($data, $ssid);
			$stid = $row['STID'];
			array_push($data, $stid);
			$name = $row['NAME'];//i am not want item code i,eeeeeeeeeeee
			array_push($data, $name);
			$description = $row['DESCRIPTION'];
			array_push($data, $description);
		}

		return $data;
	}

	public function updateSubsection($statuateid, $name, $description, $stid){

		$role = $this->session->userdata('role');

		if($role == 'Admin')
			$role = 'Admin';
		else
			$role = 'User';

		$this->db->where('SSID', $stid);

		$this->db->set('STID', $statuateid);
		$this->db->set('NAME', $name);
		$this->db->set('DESCRIPTION', $description);
		$this->db->set('USERID', $this->session->userdata('userid'));
		$this->db->set('DISABLE', 'N');
		$this->db->set('ROLE', $role);

		$this->db->update('law_statuate_sub_section');

		$dArray = array();
		array_push($dArray, true);
		return $dArray;

	}

	public function disableSubSection($subsectionid)
	{
		$query = $this->db->query("select disable from law_statuate_sub_section where (UPPER(SSID) = '".strtoupper($subsectionid)."')");
		
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

		$this->db->where('SSID', $subsectionid);
		$this->db->set('DISABLE', $disable);

		$this->db->update('law_statuate_sub_section');

		$dArray = array();
		array_push($dArray, true);
		return $dArray;
	}

	public function fetchStatuateName($stid)
	{
		$query = $this->db->query("select * from law_statuate where STID  = '".$stid."'");
		$result = $query->result_array();
		$username = '';
		foreach($result as $r)
		{
			$username = $r['NAME'];
		}

		return $username;
	}
}

/* End of file Configurationmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */