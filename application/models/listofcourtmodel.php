<?php 
class Listofcourtmodel extends CI_Model {

	public function fetchListOfCourt()
	{
		$str = "select * from law_list_of_courts";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function courtNameAvailable($courtName){
				
		$query = $this->db->query("select count(name) as cntname from law_list_of_courts  where (UPPER(name) = '".strtoupper($courtName)."')");
		
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

	public function courtListDetails($courtid)
	{
		$str = "select * from law_list_of_courts where disable='N' and CNID='".$courtid."'";
		$query = $this->db->query($str);
		$result = $query->result_array();

		$data = array();
		foreach($result as $row)
		{
			$cnid = $row['CNID'];
			array_push($data, $cnid);
			$name = $row['NAME'];//i am not want item code i,eeeeeeeeeeee
			array_push($data, $name);
			$court_type = $row['COURT_TYPE'];
			array_push($data, $court_type);
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

	public function insertCourtList($courtName, $court_type){

		$data = array();
		$data['NAME'] = $courtName;
		$data['COURT_TYPE'] = $court_type;
		$data['DISABLE'] = 'N';		

		$this->db->insert('law_list_of_courts', $data); 
		$autoid = $this->db->insert_id();
		
		$this->db->where('id', $autoid);
		$ctid = 'CN'.$autoid;
		
		$this->db->set('CNID', $ctid);
			
		$this->db->update('law_list_of_courts');

		$dArray = array();
		array_push($dArray, true);
		return $dArray;

	}

	public function updateCourtList($courtName, $court_type, $cnid){
	
		$this->db->where('CNID', $cnid);

		$this->db->set('NAME', $courtName);
		$this->db->set('COURT_TYPE', $court_type);
		$this->db->set('DISABLE', 'N');

		$this->db->update('law_list_of_courts');

		$dArray = array();
		array_push($dArray, true);
		return $dArray;

	}
	
	public function fetchTypeOfCitation()
	{
		$str = "select * from law_type_of_citation where disable='N'";
		$query = $this->db->query($str);
		return $query->result_array();
	}	

	public function ajaxcall()
	{
		
		$type = $this->input->post('type');
		$name = $this->input->post('name_startsWith');
		$court_type = $this->input->post('court_type');		
		
		$query = $this->db->query("select NAME from law_list_of_courts where court_type='$court_type' and (UPPER(name) LIKE '%".strtoupper($name)."%')");
		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['NAME'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
			}
		}
		return $data;
		
	}

	public function ajaxStatuate()
	{
		
		$type = $this->input->post('type');
		$name = $this->input->post('name_startsWith');
		$userid = $this->session->userdata('userid');
				
		$query = $this->db->query("select ls.NAME as sname, lsss.NAME as subname from law_statuate ls inner join law_statuate_sub_section lsss  on ls.STID=lsss.STID where userid='$userid' and (UPPER(ls.name) LIKE '%".strtoupper($name)."%')");
		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['sname'].'|'.$row['subname'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
			}
		}
		return $data;
	}
	
	public function ajaxConcept()
	{
		
		$type = $this->input->post('type');
		$name = $this->input->post('name_startsWith');
		$userid = $this->session->userdata('userid');
				
		$query = $this->db->query("select name from law_concepts  where userid='$userid' and (UPPER(name) LIKE '%".strtoupper($name)."%')");
		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['name'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
			}
		}
		return $data;
	}

	public function citationTypeAjax()
	{
		
		$type = $this->input->post('type');
		$name = $this->input->post('name_startsWith');
						
		$query = $this->db->query("select citation from law_citation_notation_link where (UPPER(citation) LIKE '%".strtoupper($name)."%')");
		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['name'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
			}
		}
		return $data;
	}

	public function ajaxCaseName()
	{
		$casename = $this->input->post('casename');
				
		$query = $this->db->query("select count(casename) as casename from law_notation  where (UPPER(casename) = '".strtoupper($casename)."')");
		
		$data = array();
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['casename'];//i am not want item code i,eeeeeeeeeeee
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

	public function ajaxCitation()
	{
		$citation = $this->input->post('citation');
				
		$query = $this->db->query("select count(citation) as citation from law_notation  where (UPPER(citation) = '".strtoupper($citation)."')");
		
		$data = array();
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['citation'];//i am not want item code i,eeeeeeeeeeee
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

	public function disableCourtList($courtID)
	{
		$query = $this->db->query("select disable from law_list_of_courts where (UPPER(CNID) = '".strtoupper($courtID)."')");
		
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

		$this->db->where('CNID', $courtID);
		$this->db->set('DISABLE', $disable);

		$this->db->update('law_list_of_courts');

		$dArray = array();
		array_push($dArray, true);
		return $dArray;
	}
}

/* End of file Configurationmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */