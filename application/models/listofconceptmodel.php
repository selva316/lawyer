<?php 
class Listofconceptmodel extends CI_Model {

	public function fetchListOfConcept()
	{
		$str = "select * from law_concepts";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function conceptNameAvailable($name){
				
		$query = $this->db->query("select count(name) as cntname from law_concepts  where (UPPER(name) = '".strtoupper($name)."')");
		
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

	public function conceptDetails($conceptid)
	{
		$str = "select * from law_concepts where disable='N' and CID='".$conceptid."'";
		$query = $this->db->query($str);
		$result = $query->result_array();

		$data = array();
		foreach($result as $row)
		{
			$cid = $row['CID'];
			array_push($data, $cid);
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

	public function insertConcept($conceptname, $description, $statuate){

		$role = $this->session->userdata('role');

		$data = array();
		$data['NAME'] = $conceptname;
		$data['DESCRIPTION'] = $description;
		
		if($role == 'Admin')
			$data['ROLE'] = 'Admin';
		else
			$data['ROLE'] = 'User';

		$data['USERID'] = $this->session->userdata('userid');

		$data['DISABLE'] = 'N';		

		$this->db->insert('law_concepts', $data); 
		$autoid = $this->db->insert_id();
		
		$this->db->where('id', $autoid);
		$ctid = 'C'.$autoid;
		
		$this->db->set('CID', $ctid);
			
		$this->db->update('law_concepts');

		$statuateExplore = explode(',', $statuate);
		foreach ($statuateExplore as $subval) {
		
			$innerdata = array();
			$innerdata['STID'] = $subval;
			$innerdata['CID'] = $ctid;

			$innerdata['USERID'] = $this->session->userdata('userid');

			$innerdata['DISABLE'] = 'N';		

			$this->db->insert('law_statuate_concept_link', $innerdata); 
			$autoid = $this->db->insert_id();
			
			$this->db->where('id', $autoid);
			$stconid = 'STCON'.$autoid;
			
			$this->db->set('STCONID', $stconid);
				
			$this->db->update('law_statuate_concept_link');

		}

		$dArray = array();
		array_push($dArray, true);
		return $dArray;

	}

	public function updateConcept($name, $description, $cid){
		$role = $this->session->userdata('role');

		if($role == 'Admin')
			$roleval = 'Admin';
		else
			$roleval = 'User';
	
		$this->db->where('CID', $cid);

		$this->db->set('NAME', $name);
		$this->db->set('DESCRIPTION', $description);
		$this->db->set('USERID', $this->session->userdata('userid'));
		$this->db->set('DISABLE', 'N');
		$this->db->set('ROLE', $roleval);

		$this->db->update('law_concepts');

		$dArray = array();
		array_push($dArray, true);
		return $dArray;

	}
	
	
	public function disableConcept($conceptid)
	{
		$query = $this->db->query("select disable from law_concepts where (UPPER(CID) = '".strtoupper($conceptid)."')");
		
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

		$this->db->where('CID', $conceptid);
		$this->db->set('DISABLE', $disable);

		$this->db->update('law_concepts');

		$dArray = array();
		array_push($dArray, true);
		return $dArray;
	}
}

/* End of file Configurationmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */