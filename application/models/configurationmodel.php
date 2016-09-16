<?php 
class Configurationmodel extends CI_Model {

	public function fetchListOfUser()
	{
		$str = "select * from law_login";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchListOfRole()
	{
		$str = "select * from law_role";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchCourtType()
	{
		$str = "select * from law_courttype";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchStatuate()
	{
		$str = "select * from law_statuate";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchClient()
	{
		$str = "select * from law_client_master";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchConcept()
	{
		$str = "select * from law_concepts";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchYear($year)
	{
		$query = $this->db->query("select year from law_year where (UPPER(year) LIKE '".strtoupper($year)."%')");
		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['year'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
			}
		}
		return $data;
		
	}

	public function fetchAllCitation($name){
		$userid = $this->session->userdata('userid');
		$str = "select distinct lc.citation from law_citation lc inner join law_notation ln on lc.notationid = ln.notationid where ln.citation is not null and (created_by='$userid' or updated_by='$userid') and (UPPER(ln.citation) LIKE '%".strtoupper($name)."%')";

		//$str = "select distinct lc.citation from law_citation lc inner join law_notation ln on lc.notationid = ln.notationid where ln.citation is not null and (created_by='$userid' or updated_by='$userid') and (type='public' or type='dbversion') and (UPPER(ln.citation) LIKE '%".strtoupper($name)."%')";
		
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchAllCasenumber($name){
		$userid = $this->session->userdata('userid');
		$str = "select distinct lc.casenumber from law_casenumber lc inner join law_notation ln on lc.notationid = ln.notationid where ln.casenumber is not null and (created_by='$userid' or updated_by='$userid') and (UPPER(lc.casenumber) LIKE '%".strtoupper($name)."%')";

		//$str = "select distinct lc.citation from law_citation lc inner join law_notation ln on lc.notationid = ln.notationid where ln.citation is not null and (created_by='$userid' or updated_by='$userid') and (type='public' or type='dbversion') and (UPPER(ln.citation) LIKE '%".strtoupper($name)."%')";
		
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function courtNameAvailable($courtName){
				
		$query = $this->db->query("select count(name) as cntname from law_courttype  where (UPPER(name) = '".strtoupper($courtName)."')");
		
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

	public function courtTypeDetails($courtid)
	{
		$str = "select * from law_courttype where disable='N' and CTID='".$courtid."'";
		$query = $this->db->query($str);
		$result = $query->result_array();

		$data = array();
		foreach($result as $row)
		{
			$ctid = $row['CTID'];
			array_push($data, $ctid);
			$name = $row['NAME'];//i am not want item code i,eeeeeeeeeeee
			array_push($data, $name);
			$shortname = $row['SHORTNAME'];
			array_push($data, $shortname);
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

	public function insertCourtType($courtName, $shortName){

		$data = array();
		$data['NAME'] = $courtName;
		$data['SHORTNAME'] = $shortName;
		$data['DISABLE'] = 'N';		

		$this->db->insert('law_courttype', $data); 
		$autoid = $this->db->insert_id();
		
		$this->db->where('id', $autoid);
		$ctid = 'CT'.$autoid;
		
		$this->db->set('CTID', $ctid);
			
		$this->db->update('law_courttype');

		$dArray = array();
		array_push($dArray, true);
		return $dArray;

	}

	public function updateCourtType($courtName, $shortName, $ctid){
	
		$this->db->where('CTID', $ctid);

		$this->db->set('NAME', $courtName);
		$this->db->set('SHORTNAME', $shortName);
		$this->db->set('DISABLE', 'N');

		$this->db->update('law_courttype');

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
		$userid = $this->session->userdata('userid');	
		$name = $this->input->post('name_startsWith');
		$court_type = $this->input->post('court_type');		
		
		$query = $this->db->query("select NAME from law_list_of_courts where (userid='$userid' or role='Admin') and (UPPER(name) LIKE '%".strtoupper($name)."%') and disable='N' order by name");
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

	public function fetchAllJudges()
	{
		$userid = $this->session->userdata('userid');
		$name = $this->input->post('name_startsWith');
		$str = "select distinct judge_name from law_judgename where (UPPER(judge_name) LIKE '%".strtoupper($name)."%')order by judge_name";
		//$str = "select distinct lj.judge_name from law_judgename lj inner join law_notation ln on lj.notationid = ln.notationid where ln.citation is not null and (created_by='$userid' or updated_by='$userid') and (type='public' or type='dbversion') and (UPPER(ln.judge_name) LIKE '%".strtoupper($name)."%')";
		

		//$str = "select distinct judge_name from law_notation where (( CREATED_BY='$userid' or  	UPDATED_BY='$userid') or (type='public' or type='dbversion')) and (UPPER(judge_name) LIKE '%".strtoupper($name)."%') order by judge_name";
		/*$query = $this->db->query("select distinct judge_name from law_notation where (( CREATED_BY='$userid' or  	UPDATED_BY='$userid') or (type='public' or type='dbversion')) and (UPPER(judge_name) LIKE '%".strtoupper($name)."%') order by judge_name");
		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['judge_name'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
			}
		}*/
		$query = $this->db->query($str);
		return $query->result_array();

		return $data;
	}

	public function ajaxStatuate()
	{

		$type = $this->input->post('type');
		$name = $this->input->post('name_startsWith');
		$userid = $this->session->userdata('userid');

		$query = $this->db->query("select lsss.SSID as ssid, ls.NAME as sname, lsss.NAME as subname, ls.STID as stid from law_statuate ls left join law_statuate_sub_section lsss  on ls.STID=lsss.STID where (ls.userid='$userid' or ls.role='Admin')  and ls.disable='N' and (UPPER(ls.name) LIKE '%".strtoupper($name)."%') order by ls.NAME");
		
		//echo "select ls.NAME as sname, lsss.NAME as subname from law_statuate ls left join law_statuate_sub_section lsss  on ls.STID=lsss.STID where (userid='$userid' or userid='Admin')and (UPPER(ls.name) LIKE '%".strtoupper($name)."%')";

		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['sname'].'|'.$row['subname'].'|'.$row['stid'].'|'.$row['ssid'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
			}
		}
		return $data;
	}

	public function fetchUserStatuate()
	{
		
		$name = $this->input->post('name_startsWith');
		$userid = $this->session->userdata('userid');

		$query = $this->db->query("select ls.NAME as sname, ls.STID as stid from law_statuate ls where (ls.userid='$userid' or ls.role='Admin')  and ls.disable='N' and (UPPER(ls.name) LIKE '%".strtoupper($name)."%')");

		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['sname'].'|'.$row['stid'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
			}
		}
		return $data;	
	}

	public function fetchUserConcept()
	{

		$name = $this->input->post('name_startsWith');
		$userid = $this->session->userdata('userid');

		$query = $this->db->query("select ls.NAME as cname, ls.CID as cid from law_concepts ls where (ls.userid='$userid' or ls.role='Admin')  and ls.disable='N' and (UPPER(ls.name) LIKE '%".strtoupper($name)."%')");

		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['cname'].'|'.$row['cid'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
			}
		}
		return $data;
	}

	public function fetchUserSubSection()
	{

		$type = $this->input->post('type');
		$name = $this->input->post('name_startsWith');
		$userid = $this->session->userdata('userid');
		$statuate = $this->input->post('statuate');

		$query = $this->db->query("select lsss.SSID as ssid, lsss.NAME as subname from law_statuate_sub_section lsss where (lsss.userid='$userid' or lsss.role='Admin')  and lsss.disable='N' and (UPPER(lsss.name) LIKE '%".strtoupper($name)."%') and STID='$statuate'");
		
		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['subname'].'|'.$row['ssid'];//i am not want item code i,eeeeeeeeeeee
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
		$statuate = $this->input->post('statuate');
		$subsection = $this->input->post('subsection');
				
		if($statuate != '')
		{
			$subsectionstr = '';
			if($subsection !=''){
				/*
				$subsection_query = $this->db->query("SELECT SSID FROM law_statuate_sub_section where name='".$statuate."' AND STID IN ('".$statuate."')");
				if($subsection_query->num_rows() > 0)
				{
					$subsectionstr = ' AND (';
					$subresult = $subsection_query->result_array();
					foreach ($subresult as $sr) {
						$subsectionstr .= "SSID = '".$sr['SSID']."' OR ";
					}
					$subsectionstr = substr($subsectionstr, -1, 3);
					$subsectionstr .= ')';
				}*/
				$subsectionstr = " AND SSID='".$subsection."'";
			}
			else
				$subsectionstr = " AND SSID=''";	
			
			/*
			$statuatestr = '';

			$statuate_query = $this->db->query("SELECT STID FROM law_statuate where name='".$statuate."'");
			if($statuate_query->num_rows() > 0)
			{
				$statuatestr = ' AND (';
				$statuateresult = $statuate_query->result_array();
				foreach ($statuateresult as $st) {
					$statuatestr .= " (STID = '".$st['STID']."') OR ";
				}
				$statuatestr = substr($statuatestr, -1, 3);
				$statuatestr .= ')';
			}*/
			$query = $this->db->query("SELECT name FROM `law_concepts` lc inner join law_statuate_concept_link lscl on lc.CID=lscl.CID where (lc.role='Admin' or lc.userid='$userid')  and lc.disable='N' and (UPPER(lc.name) LIKE '%".strtoupper($name)."%') AND lscl.STID='".$statuate."' ".$subsectionstr." order by name");

			//$query = $this->db->query("select name from law_concepts  where (role='Admin' or userid='$userid') and (UPPER(name) LIKE '%".strtoupper($name)."%') ".$statuatestr.$subsectionstr);
			//echo "SELECT name FROM `law_concepts` lc inner join law_statuate_concept_link lscl on lc.CID=lscl.CID where (lc.role='Admin' or lc.userid='$userid') and (UPPER(lc.name) LIKE '%".strtoupper($name)."%') AND lscl.STID='".$statuate."' ".$subsectionstr;
		}
		else
		{
			$query = $this->db->query("select name from law_concepts  where (role='Admin' or userid='$userid')  and disable='N' and (UPPER(name) LIKE '%".strtoupper($name)."%') order by name");	
		}
		
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
						
		$query = $this->db->query("select citation from law_citation_notation_link where  disable='N' AND (UPPER(citation) LIKE '%".strtoupper($name)."%') order by citation");
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

	public function disableCourtType($courtID)
	{
		$query = $this->db->query("select disable from law_courttype  where (UPPER(CTID) = '".strtoupper($courtID)."')");
		
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

		$this->db->where('CTID', $courtID);
		$this->db->set('DISABLE', $disable);

		$this->db->update('law_courttype');

		$dArray = array();
		array_push($dArray, true);
		return $dArray;
	}

	public function fetchResearchTopic()
	{

		$name = $this->input->post('name_startsWith');
		$userid = $this->session->userdata('userid');
		$query = $this->db->query("select topic from law_research_group where (upper(assign_to) like '%".strtoupper($userid)."%') and (UPPER(topic) LIKE '%".strtoupper($name)."%') order by topic");
		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['topic'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
			}
		}
		return $data;
		
	}

	public function fetchUserID($username)
	{
		//echo "select * from law_login where name  = '".$username."'";
		$query = $this->db->query("select * from law_login where NAME  = '".$username."'");
		$result = $query->result_array();
		$userid = '';
		foreach($result as $r)
		{
			$userid = $r['USERID'];
		}

		return $userid;
	}

	public function fetchUserName($userid)
	{
		//echo "select * from law_login where name  = '".$username."'";
		$query = $this->db->query("select * from law_login where USERID  = '".$userid."'");
		$result = $query->result_array();
		$username = '';
		foreach($result as $r)
		{
			$username = $r['NAME'];
		}

		return $username;
	}

	public function fetchCaseNumber(){
		$userid = $this->session->userdata('userid');
		//$str = "select * from law_notation where created_by='".$userid."' or (type='public' or type='dbversion')";
		$str = "select * from law_client_entity_case where clientid in (SELECT clientid FROM law_client_master where BELONGS_TO='".$userid."')";
		$query = $this->db->query($str);
		return $query->result_array();	
	}

	public function fetchConceptStatuateLink()
	{

	}

}

/* End of file Configurationmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */