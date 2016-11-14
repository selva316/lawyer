<?php 
class Notationmodel extends CI_Model {

	public $notationid;
	public $hashnotationid;
	public $casename;
	public $citation;
	public $dup_citation;
	public $casenumber;
	public $judge_name;
	public $courtname;
	public $year;
	public $bench;
	public $facts_of_case;
	public $case_note;
	public $created_by;
	public $created_on;
	public $type;

	public function fetchCourtType()
	{
		$str = "select * from law_courttype";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchNotationID($hashnotationid)
	{
		$query = $this->db->query("select notationid from law_notation where (UPPER(notationid) LIKE '%".strtoupper($hashnotationid)."%')");

		$notationid = '';
		$result = $query->result_array();
		foreach($result as $row)
		{
			$notationid = $row['notationid'];//i am not want item code i,eeeeeeeeeeee
		}
		return $notationid;
	}

	public function fetchTypeOfCitation()
	{
		$str = "select * from law_type_of_citation where disable='N'";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchStatus()
	{
		$str = "select * from law_status";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchCaseName($casename)
	{

		$query = $this->db->query("select distinct casename from law_notation where (UPPER(casename) LIKE '%".strtoupper($casename)."%')");
		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['casename'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
			}
		}
		return $data;
		
	}

	public function fetchCitationType($fetchCitationType)
	{
		$query = $this->db->query("select name from law_type_of_citation where (UPPER(name) LIKE '%".strtoupper($fetchCitationType)."%') order by name");
		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['name'];
				array_push($data, $name);
			}
		}
		return $data;
	}

	public function createWebNotation($casename, $citation, $casenumber, $judge_name, $courtname, $fact_of_case, $notes, $userid, $role)
	{
		$data = array();
		$data['CASENAME'] = $casename;
		
		if(strlen($citation) > 1){
			$data['CITATION'] = $citation;
			$data['DUP_CITATION'] = $this->_clean($citation);
		}
		else
			$data['CITATION'] = '';

		if(strlen($casenumber) > 1)
			$data['CASENUMBER'] = $casenumber;
		else
			$data['CASENUMBER'] = '';

		if(strlen($judge_name) > 1)
			$data['JUDGE_NAME'] = $judge_name;
		else
			$data['JUDGE_NAME'] = '';

		if(strlen($courtname) > 1)
			$data['COURT_NAME'] = $courtname;
		else
			$data['COURT_NAME'] = '';

		if(strlen($fact_of_case) > 1)
			$data['FACTS_OF_CASE'] = $fact_of_case;
		else
			$data['FACTS_OF_CASE'] = '';

		if(strlen($notes) > 1)
			$data['CASE_NOTE'] = $notes;
		else
			$data['CASE_NOTE'] = '';

		$this->db->insert('law_notation', $data); 
		$autoid = $this->db->insert_id();
		
		$this->db->where('id', $autoid);
		$nid = 'NT'.$autoid;
		$hashnid = md5($nid.time());
		$this->db->set('NOTATIONID', $nid);
		$this->db->set('HASHNOTATIONID', $hashnid);
		
		$this->db->set('CREATED_BY', $userid);
		$this->db->set('CREATED_ON', time());

		$this->db->set('TYPE', 'draft');
		$this->db->set('ROLE', $this->session->userdata('role'));
		$this->db->set('UPDATED_BY', $userid);
		$this->db->set('UPDATED_ON', time());

		$this->db->update('law_notation');

		return $nid;
	}

	public function updateWebNotation($notationid, $casename, $citation, $casenumber, $judge_name, $courtname, $fact_of_case, $notes, $userid, $role)
	{

		$data = array();
		$data['CASENAME'] = $this->findCaseName($notationid).';'.$casename;
		$data['CITATION'] = $this->findCitation($notationid).';'.$citation;
		$data['CASENUMBER'] = $this->findCasenumber($notationid).';'.$casenumber;
		$data['DUP_CITATION'] = $this->findDupCitation($notationid).';'.$this->_clean($citation);

		if(strlen($judge_name) > 1)
			$judge_name = $this->findJudgeName($notationid).';'.$judge_name;
		else
			$judge_name = $this->findJudgeName($notationid);

		if(strlen($courtname) > 1)
			$courtname = $this->findCourtname($notationid).';'.$courtname;
		else
			$courtname = $this->findCourtname($notationid);

		if(strlen($fact_of_case) > 1)
			$fact_of_case = $this->findFactofCase($notationid).';'.$fact_of_case;
		else
			$fact_of_case = $this->findFactofCase($notationid);

		if(strlen($notes) > 1)
			$notes = $this->findCaseNotes($notationid).';'.$notes;
		else
			$notes = $this->findCaseNotes($notationid);
		
		$this->db->where('NOTATIONID', $notationid);
		
		$this->db->set('TYPE', 'draft');
		$this->db->set('CASENAME', $casename);
		$this->db->set('CITATION', $citation);		
		$this->db->set('CASENUMBER', $casenumber);

		$this->db->set('JUDGE_NAME', $judge_name);
		$this->db->set('COURT_NAME', $courtname);
		$this->db->set('FACTS_OF_CASE', $fact_of_case);
		$this->db->set('CASE_NOTE', $notes);

		$this->db->set('UPDATED_BY', $userid);
		$this->db->set('UPDATED_ON', time());
		$this->db->set('ROLE', $this->session->userdata('role'));
		$this->db->update('law_notation');

		return $notationid;
	}

	function createNotation($data)
	{
		$this->db->insert('law_notation', $data); 
		$autoid = $this->db->insert_id();
		
		$this->db->where('id', $autoid);
		$nid = 'NT'.$autoid;
		$notationid = $nid;

		$hashnid = md5($nid.time());
		$this->db->set('NOTATIONID', $nid);
		$this->db->set('HASHNOTATIONID', $hashnid);
		
		$this->db->set('CREATED_BY', $this->session->userdata('userid'));
		$this->db->set('CREATED_ON', time());

		if($this->session->userdata('role') == 'Admin')
			$this->db->set('TYPE', 'dbversion');

		$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
		$this->db->set('UPDATED_ON', time());
		$this->db->set('ROLE', $this->session->userdata('role'));

		$this->db->update('law_notation');

		$this->db->where('NOTATIONID', $nid);
		$this->db->delete('law_notation_statuate');

		/* Statuate , Sub Section and Concept */
		$number_of_entries = count($this->input->post('statuate'));
		$statuate = $this->input->post('statuate');
		$subsection = $this->input->post('subsection');
		$concept = $this->input->post('concept');

		if($number_of_entries >= 0)
		{
			for ($i=0; $i <$number_of_entries ; $i++) { 
				
				$itemlist = array();

				if(($statuate[$i] == "") && ($concept[$i] == "") || ($nid == ""))
					continue;

				$itemlist['STATUATE'] = $statuate[$i];
				$itemlist['SUB_SECTION'] = $subsection[$i];
				$itemlist['CONCEPT'] = $concept[$i];
				$itemlist['NOTATIONID'] = $nid;

				$this->db->insert('law_notation_statuate', $itemlist); 
			}
		}

		/* Statuate , Sub Section and Concept */

		
		$numberOfCitationEntries = $this->input->post('numberOfCitationEntries');
		$citationNumber = $this->input->post('citationNumber');
		$listCaseName = $this->input->post('listCaseName');
		$typeCitation = $this->input->post('typeCitation');
		$treatment = $this->input->post('treatment');
		$note = $this->input->post('note');

		if($numberOfCitationEntries > 0)
		{
			for ($i=0; $i <$numberOfCitationEntries ; $i++) { 
				
				$itemlist = array();

				if(($citationNumber[$i] == "")  || ($nid == ""))
					continue;

				$itemlist['CITATION'] = $this->_clean($citationNumber[$i]);
				$itemlist['ACTUAL_CITATION'] = $citationNumber[$i];
				if($this->_checkCitationAvailable($citationNumber[$i]) <= 0)
				{
					if($listCaseName[$i] != '')
						$l_caseName = $listCaseName[$i];
					else
						$l_caseName = 'No Casename';

					$this->_createMissingCitationDraft($citationNumber[$i], $l_caseName);
				}

				if($listCaseName[$i] != '')
					$itemlist['CASENUMBER'] = $listCaseName[$i];
				else
					$itemlist['CASENUMBER'] = 'No Casename';

				$itemlist['TYPE_OF_CITATION'] = $typeCitation[$i];
				$itemlist['DESCRIPTION'] = $note[$i];
				$itemlist['TREATMENT'] = $treatment[$i];
				$itemlist['NOTATIONID'] = $nid;

				$this->db->insert('law_citation_notation_link', $itemlist); 
			}
		}

		/* Word Pharse and Legal Definition */

		$number_of_phrase = count($this->input->post('phrase'));
		$phrase = $this->input->post('phrase');
		$legal = $this->input->post('legal');

		if($number_of_phrase >= 0)
		{
			for ($i=0; $i <$number_of_phrase ; $i++) { 
				
				$phraselist = array();

				if(($phrase[$i] == "")  || ($nid == ""))
					continue;

				$phraselist['PHRASE'] = $phrase[$i];
				$phraselist['EXPLANATION'] = $legal[$i];
				$phraselist['NOTATIONID'] = $nid;

				$this->db->insert('law_notation_phrase', $phraselist); 
			}
		}

		$listcitation = $this->input->post('citation');

		$this->db->where('NOTATIONID', $notationid);
		$this->db->delete('law_citation');

		if (strpos($listcitation, ';') !== false) {
			$citation_arr = explode(";",$listcitation);
			foreach($citation_arr as $lcitation)
			{
				$itemlist = array();
				$itemlist['CITATION'] = trim($lcitation);
				$itemlist['ACTUAL_CITATION'] = trim($this->_clean($lcitation));
				$itemlist['NOTATIONID'] = $notationid;
				$this->db->insert('law_citation', $itemlist);
				//print_r($itemlist); 
			}
		}
		else
		{
			$itemlist = array();
			$itemlist['CITATION'] = trim($this->input->post('citation'));
			$itemlist['ACTUAL_CITATION'] = trim($this->_clean($this->input->post('citation')));
			$itemlist['NOTATIONID'] = $notationid;
			$this->db->insert('law_citation', $itemlist); 
			//print_r($itemlist);
		}

		$listcasenumber = $this->input->post('casenumber');

		$this->db->where('NOTATIONID', $notationid);
		$this->db->delete('law_casenumber');

		if (strpos($listcasenumber, ';') !== false) {
			$casenumber_arr = explode(";",$listcasenumber);
			foreach($casenumber_arr as $lcasenumber)
			{
				$itemlist = array();
				$itemlist['CASENUMBER'] = trim($lcasenumber);
				$itemlist['NOTATIONID'] = $notationid;
				$this->db->insert('law_casenumber', $itemlist);
				//print_r($itemlist); 
			}
		}
		else
		{
			$itemlist = array();
			$itemlist['CASENUMBER'] = trim($this->input->post('casenumber'));
			$itemlist['NOTATIONID'] = $notationid;
			$this->db->insert('law_casenumber', $itemlist); 
			//print_r($itemlist);
		}

		$listofjudge = $this->input->post('judge_name');
		$this->db->where('NOTATIONID', $notationid);
		$this->db->delete('law_judgename');

		if (strpos($listofjudge, ';') !== false) {
			$judge_arr = explode(";",$listofjudge);
			foreach($judge_arr as $ljudge)
			{
				if($this->fnJudgeAvailable($ljudge) == 0 && $ljudge != '')
				{
					$itemlist = array();
					$itemlist['JUDGE_NAME'] = trim($ljudge);
					$itemlist['NOTATIONID'] = $notationid;
					$this->db->insert('law_judgename', $itemlist);
				}
			}
		}
		else
		{
			$judgeName = $this->input->post('judge_name');
			if($this->fnJudgeAvailable($judgeName) == 0 && $judgeName != '') 
			{
				$itemlist = array();
				$itemlist['JUDGE_NAME'] = trim($this->input->post('judge_name'));
				$itemlist['NOTATIONID'] = $notationid;
				$this->db->insert('law_judgename', $itemlist); 
			}
		}

		return true;
	}

	function autoSaveNotation($notationData, $notationid)
	{
		$userid = $this->session->userdata('userid');
		$role = $this->session->userdata('role');

		if(strlen($notationid)>0 && $notationid != '')
		{
			$this->db->where('NOTATIONID', $notationid);
			$this->db->delete('law_notation_statuate');

			$listOfStatuate = $this->input->post('listOfStatuate');
			$listOfStatuate_arr = explode("--^--",$listOfStatuate);
			foreach ($listOfStatuate_arr as $los_arr) {
				$statuateContent = explode('--$$--', $los_arr);
				
				$ctid = '';
				$ssid = '';
				$contid = '';
				if(isset($statuateContent[0])){
					$statuateAvailable = $this->fnStatuateAvailable($statuateContent[0], $userid);
					if($statuateAvailable ==0 && $statuateContent[0] !='')
					{
						$data = array();
						$data['NAME'] = $statuateContent[0];
						$data['DESCRIPTION'] = $statuateContent[0];
						
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
					}
					else
						$ctid = $statuateContent[1];
				}
				
				
				if(isset($statuateContent[2])){
					$subsectionAvailable = $this->fnSubSectionAvailable($statuateContent[2], $userid, $ctid);
					if($subsectionAvailable == 0 && $statuateContent[2] != '' && $ctid != '')
					{
						$data = array();

						$data['STID'] = $ctid;
						$data['DESCRIPTION'] = $statuateContent[2];
						$data['NAME'] = $statuateContent[2];
						
						if($role == 'Admin')
							$data['ROLE'] = 'Admin';
						else
							$data['ROLE'] = 'User';

						$data['USERID'] = $this->session->userdata('userid');

						$data['DISABLE'] = 'N';		

						$this->db->insert('law_statuate_sub_section', $data); 
						$autoid = $this->db->insert_id();
						
						$this->db->where('id', $autoid);
						$ssid = 'SS'.$autoid;
						
						$this->db->set('SSID', $ssid);
							
						$this->db->update('law_statuate_sub_section');
					}
					else
						$ssid = $statuateContent[3];
				}
				

				if(isset($statuateContent[4])){
					$conceptAvailable = $this->fnConceptAvailable($statuateContent[4], $userid);
					if($conceptAvailable == 0 && $statuateContent[4] != '')
					{
						$data = array();

						$data['NAME'] = $statuateContent[4];
						$data['DESCRIPTION'] = $statuateContent[4];
						
						if($role == 'Admin')
							$data['ROLE'] = 'Admin';
						else
							$data['ROLE'] = 'User';

						$data['USERID'] = $this->session->userdata('userid');

						$data['DISABLE'] = 'N';		

						$this->db->insert('law_concepts', $data); 
						$autoid = $this->db->insert_id();
						
						$this->db->where('id', $autoid);
						$contid = 'C'.$autoid;
						
						$this->db->set('CID', $contid);
							
						$this->db->update('law_concepts');

					}
					else
					{
						$contid = $this->fnFetchConceptId($statuateContent[4], $userid);
					}

					if($ctid != '' && $contid != '')
					{
						$innerdata = array();
						$innerdata['STID'] = $ctid;
						$innerdata['SSID'] = $ssid;
						$innerdata['CID'] = $contid;
						$innerdata['USERID'] = $this->session->userdata('userid');
						$innerdata['DISABLE'] = 'N';		
						$this->db->insert('law_statuate_concept_link', $innerdata); 
						$autoid = $this->db->insert_id();
					
						$this->db->where('id', $autoid);
						$stconid = 'STCON'.$autoid;
					
						$this->db->set('STCONID', $stconid);
							
						$this->db->update('law_statuate_concept_link');	
					}
					
				}
			}

			$this->db->where('NOTATIONID', $notationid);
			$this->db->update('law_notation', $notationData);
			
			$listOfStatuate = $this->input->post('listOfStatuate');
			$listOfStatuate_arr = explode("--^--",$listOfStatuate);
			foreach ($listOfStatuate_arr as $los_arr) {
				$statuateContent = explode('--$$--', $los_arr);
				$notationStatuateAvailable = $this->fnNotationStatuateAvailable($statuateContent[0],$statuateContent[2],$statuateContent[4], $notationid);
				if($notationStatuateAvailable == 0)
				{
					if(($statuateContent[0] == "") && ($statuateContent[4] == "") || ($notationid == ""))
						continue;					

					$itemlist = array();

					$itemlist['STATUATE'] = $statuateContent[0];
					$itemlist['SUB_SECTION'] = $statuateContent[2];
					$itemlist['CONCEPT'] = $statuateContent[4];
					$itemlist['NOTATIONID'] = $notationid;

					$this->db->insert('law_notation_statuate', $itemlist); 
				}
			}

			$listcitation = $this->input->post('citation');

			$this->db->where('NOTATIONID', $notationid);
			$this->db->delete('law_citation');

			if (strpos($listcitation, ';') !== false) {
				$citation_arr = explode(";",$listcitation);
				foreach($citation_arr as $lcitation)
				{
					$itemlist = array();
					$itemlist['CITATION'] = trim($lcitation);
					$itemlist['ACTUAL_CITATION'] = trim($this->_clean($lcitation));
					$itemlist['NOTATIONID'] = $notationid;
					$this->db->insert('law_citation', $itemlist);
					//print_r($itemlist); 
				}
			}
			else
			{
				$itemlist = array();
				$itemlist['CITATION'] = trim($this->input->post('citation'));
				$itemlist['ACTUAL_CITATION'] = trim($this->_clean($this->input->post('citation')));
				$itemlist['NOTATIONID'] = $notationid;
				$this->db->insert('law_citation', $itemlist); 
				//print_r($itemlist);
			}

			$listcasenumber = $this->input->post('casenumber');

			$this->db->where('NOTATIONID', $notationid);
			$this->db->delete('law_casenumber');

			if (strpos($listcasenumber, ';') !== false) {
				$casenumber_arr = explode(";",$listcasenumber);
				foreach($casenumber_arr as $lcasenumber)
				{
					$itemlist = array();
					$itemlist['CASENUMBER'] = trim($lcasenumber);
					$itemlist['NOTATIONID'] = $notationid;
					$this->db->insert('law_casenumber', $itemlist);
					//print_r($itemlist); 
				}
			}
			else
			{
				$itemlist = array();
				$itemlist['CASENUMBER'] = trim($this->input->post('casenumber'));
				$itemlist['NOTATIONID'] = $notationid;
				$this->db->insert('law_casenumber', $itemlist); 
				//print_r($itemlist);
			}

			$listofjudge = $this->input->post('judge_name');
			$this->db->where('NOTATIONID', $notationid);
			$this->db->delete('law_judgename');

			if (strpos($listofjudge, ';') !== false) {
				$judge_arr = explode(";",$listofjudge);
				foreach($judge_arr as $ljudge)
				{
					if($this->fnJudgeAvailable($ljudge) == 0)
					{
						$itemlist = array();
						$itemlist['JUDGE_NAME'] = trim($ljudge);
						$itemlist['NOTATIONID'] = $notationid;
						$this->db->insert('law_judgename', $itemlist);
					}
				}
			}
			else
			{
				$judgeName = $this->input->post('judge_name');
				if($this->fnJudgeAvailable($judgeName) == 0)
				{
					$itemlist = array();
					$itemlist['JUDGE_NAME'] = trim($this->input->post('judge_name'));
					$itemlist['NOTATIONID'] = $notationid;
					$this->db->insert('law_judgename', $itemlist); 
				}
			}

			return $notationid;
		}
		else
		{
			$listOfStatuate = $this->input->post('listOfStatuate');
			$listOfStatuate_arr = explode("--^--",$listOfStatuate);
			foreach ($listOfStatuate_arr as $los_arr) {
				$statuateContent = explode('--$$--', $los_arr);
				
				$ctid = '';
				$ssid = '';
				$contid = '';
				if(isset($statuateContent[0])){
					
					$statuateAvailable = $this->fnStatuateAvailable($statuateContent[0], $userid);
					if($statuateAvailable ==0 && $statuateContent[0] !='')
					{
						$data = array();
						$data['NAME'] = $statuateContent[0];
						$data['DESCRIPTION'] = $statuateContent[0];
						
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
					}
					else
						$ctid = $statuateContent[1];
				}
								
				if(isset($statuateContent[2])){
					$subsectionAvailable = $this->fnSubSectionAvailable($statuateContent[2], $userid, $ctid);
					if($subsectionAvailable == 0 && $statuateContent[2] != '' && $ctid != '')
					{
						$data = array();

						$data['STID'] = $ctid;
						$data['DESCRIPTION'] = $statuateContent[2];
						$data['NAME'] = $statuateContent[2];
						
						if($role == 'Admin')
							$data['ROLE'] = 'Admin';
						else
							$data['ROLE'] = 'User';

						$data['USERID'] = $this->session->userdata('userid');

						$data['DISABLE'] = 'N';		

						$this->db->insert('law_statuate_sub_section', $data); 
						$autoid = $this->db->insert_id();
						
						$this->db->where('id', $autoid);
						$ssid = 'SS'.$autoid;
						
						$this->db->set('SSID', $ssid);
							
						$this->db->update('law_statuate_sub_section');
					}
					else
						$ssid = $statuateContent[3];
				}
				
				if(isset($statuateContent[4])){
					$conceptAvailable = $this->fnConceptAvailable($statuateContent[4], $userid);
					if($conceptAvailable == 0 && $statuateContent[4] != '')
					{
						$data = array();

						$data['NAME'] = $statuateContent[4];
						$data['DESCRIPTION'] = $statuateContent[4];
						
						if($role == 'Admin')
							$data['ROLE'] = 'Admin';
						else
							$data['ROLE'] = 'User';

						$data['USERID'] = $this->session->userdata('userid');

						$data['DISABLE'] = 'N';		

						$this->db->insert('law_concepts', $data); 
						$autoid = $this->db->insert_id();
						
						$this->db->where('id', $autoid);
						$contid = 'C'.$autoid;
						
						$this->db->set('CID', $contid);
							
						$this->db->update('law_concepts');

					}
					else
					{
						$contid = $this->fnFetchConceptId($statuateContent[4], $userid);
					}

					if($ctid != '' && $contid != '')
					{
						$innerdata = array();
						$innerdata['STID'] = $ctid;
						$innerdata['SSID'] = $ssid;
						$innerdata['CID'] = $contid;
						$innerdata['USERID'] = $this->session->userdata('userid');
						$innerdata['DISABLE'] = 'N';		
						$this->db->insert('law_statuate_concept_link', $innerdata); 
						$autoid = $this->db->insert_id();
					
						$this->db->where('id', $autoid);
						$stconid = 'STCON'.$autoid;
					
						$this->db->set('STCONID', $stconid);
							
						$this->db->update('law_statuate_concept_link');	
					}
					
				}
			}

			$this->db->insert('law_notation', $notationData); 
			$autoid = $this->db->insert_id();
			
			$this->db->where('id', $autoid);
			$nid = 'NT'.$autoid;
			$hashnid = md5($nid.time());
			$this->db->set('NOTATIONID', $nid);
			$this->db->set('HASHNOTATIONID', $hashnid);
			
			$this->db->set('CREATED_BY', $this->session->userdata('userid'));
			$this->db->set('CREATED_ON', time());

			$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
			$this->db->set('UPDATED_ON', time());
			$this->db->set('ROLE', $this->session->userdata('role'));

			$this->db->update('law_notation');
	
			$listOfStatuate = $this->input->post('listOfStatuate');
			$listOfStatuate_arr = explode("--^--",$listOfStatuate);
			foreach ($listOfStatuate_arr as $los_arr) {
				$statuateContent = explode('--$$--', $los_arr);
				$notationStatuateAvailable = $this->fnNotationStatuateAvailable($statuateContent[0],$statuateContent[2],$statuateContent[4], $nid);
				if($notationStatuateAvailable == 0)
				{
					if(($statuateContent[0] == "") && ($statuateContent[4] == "") || ($nid == ""))
						continue;					

					$itemlist = array();

					$itemlist['STATUATE'] = $statuateContent[0];
					$itemlist['SUB_SECTION'] = $statuateContent[2];
					$itemlist['CONCEPT'] = $statuateContent[4];
					$itemlist['NOTATIONID'] = $nid;

					$this->db->insert('law_notation_statuate', $itemlist); 
				}
			}
			
			return $nid;
		}
		
	}

	function updateDraftNotation($data)
	{

		$this->db->where('NOTATIONID', $this->input->post('ntype'));
		$this->db->delete('law_notation_statuate');

		$nid = $this->input->post('ntype');
		$notationid = $this->input->post('ntype');

		$this->db->where('NOTATIONID', $this->input->post('ntype'));
		
		$this->db->set('CASENAME', $this->input->post('casename'));
		$this->db->set('CITATION', $this->input->post('citation'));
		$this->db->set('DUP_CITATION', $this->_clean($this->input->post('citation')));

		$this->db->set('JUDGE_NAME', $this->input->post('judge_name'));
		$this->db->set('CASENUMBER', $this->input->post('casenumber'));
		$this->db->set('COURT_NAME', $this->input->post('court_name'));
		$this->db->set('YEAR', $this->input->post('year'));
		$this->db->set('BENCH', $this->input->post('bench'));
		$this->db->set('FACTS_OF_CASE', $this->input->post('facts_of_case'));
		$this->db->set('CASE_NOTE', $this->input->post('case_note'));
		$this->db->set('TYPE', $this->input->post('status'));
		$this->db->set('ROLE', $this->session->userdata('role'));
		$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
		$this->db->set('UPDATED_ON', time());

		$this->db->update('law_notation');

		/* Statuate , Sub Section and Concept */
		$number_of_entries = count($this->input->post('statuate'));
		$statuate = $this->input->post('statuate');
		$subsection = $this->input->post('subsection');
		$concept = $this->input->post('concept');

		if($number_of_entries >= 0)
		{
			for ($i=0; $i <$number_of_entries ; $i++) { 
				
				$itemlist = array();

				if(($statuate[$i] == "") && ($concept[$i] == "") || ($nid == ""))
					continue;

				$itemlist['STATUATE'] = $statuate[$i];
				$itemlist['SUB_SECTION'] = $subsection[$i];
				$itemlist['CONCEPT'] = $concept[$i];
				$itemlist['NOTATIONID'] = $nid;

				$this->db->insert('law_notation_statuate', $itemlist); 
			}
		}

		/* Statuate , Sub Section and Concept */

		
		$numberOfCitationEntries = $this->input->post('numberOfCitationEntries');
		$citationNumber = $this->input->post('citationNumber');
		$listCaseName = $this->input->post('listCaseName');
		$typeCitation = $this->input->post('typeCitation');
		$treatment = $this->input->post('treatment');
		$note = $this->input->post('note');

		if($numberOfCitationEntries > 0)
		{
			for ($i=0; $i <$numberOfCitationEntries; $i++) { 
				
				$itemlist = array();

				if(($typeCitation[$i] == "")  || ($nid == ""))
					continue;

				$itemlist['CITATION'] = $this->_clean($citationNumber[$i]);
				$itemlist['ACTUAL_CITATION'] = $citationNumber[$i];
				if($this->_checkCitationAvailable($citationNumber[$i]) <= 0)
				{
					if($listCaseName[$i] != '')
						$l_caseName = $listCaseName[$i];
					else
						$l_caseName = 'No Casename';

					$this->_createMissingCitationDraft($citationNumber[$i], $l_caseName);
				}

				if($listCaseName[$i] !='')
					$itemlist['CASENUMBER'] = $listCaseName[$i];
				else
					$itemlist['CASENUMBER'] = 'No Casename';
				
				$itemlist['TYPE_OF_CITATION'] = $typeCitation[$i];
				$itemlist['DESCRIPTION'] = $note[$i];
				$itemlist['TREATMENT'] = $treatment[$i];
				$itemlist['NOTATIONID'] = $nid;

				$this->db->insert('law_citation_notation_link', $itemlist); 
			}
		}
		/* Word Pharse and Legal Definition */

		$number_of_phrase = count($this->input->post('phrase'));
		$phrase = $this->input->post('phrase');
		$legal = $this->input->post('legal');

		if($number_of_phrase >= 0)
		{
			for ($i=0; $i <$number_of_phrase ; $i++) { 
				
				$phraselist = array();

				if(($phrase[$i] == "")  || ($nid == ""))
					continue;

				$phraselist['PHRASE'] = $phrase[$i];
				$phraselist['EXPLANATION'] = $legal[$i];
				$phraselist['NOTATIONID'] = $nid;

				$this->db->insert('law_notation_phrase', $phraselist); 
			}
		}
		
		$listcitation = $this->input->post('citation');

		$this->db->where('NOTATIONID', $notationid);
		$this->db->delete('law_citation');

		if (strpos($listcitation, ';') !== false) {
			$citation_arr = explode(";",$listcitation);
			foreach($citation_arr as $lcitation)
			{
				$itemlist = array();
				$itemlist['CITATION'] = trim($lcitation);
				$itemlist['ACTUAL_CITATION'] = trim($this->_clean($lcitation));
				$itemlist['NOTATIONID'] = $notationid;
				$this->db->insert('law_citation', $itemlist);
				//print_r($itemlist); 
			}
		}
		else
		{
			$itemlist = array();
			$itemlist['CITATION'] = trim($this->input->post('citation'));
			$itemlist['ACTUAL_CITATION'] = trim($this->_clean($this->input->post('citation')));
			$itemlist['NOTATIONID'] = $notationid;
			$this->db->insert('law_citation', $itemlist); 
			//print_r($itemlist);
		}

		return true;
	}

	function updateNotation($data)
	{
		$nid = $this->input->post('ntype');
		$notationid = $this->input->post('ntype');
		$this->auditNotationStatuate($nid);
		$this->auditNotationCitation($nid);
		$this->auditNotation($nid);

		$this->db->where('NOTATIONID', $nid);
		$this->db->delete('law_notation_statuate');
		
		$this->db->where('NOTATIONID', $this->input->post('ntype'));
		
		$this->db->set('CASENAME', $this->input->post('casename'));
		$this->db->set('CITATION', $this->input->post('citation'));
		$this->db->set('DUP_CITATION', $this->_clean($this->input->post('citation')));

		$this->db->set('JUDGE_NAME', $this->input->post('judge_name'));
		$this->db->set('CASENUMBER', $this->input->post('casenumber'));
		$this->db->set('COURT_NAME', $this->input->post('court_name'));
		$this->db->set('YEAR', $this->input->post('year'));
		$this->db->set('BENCH', $this->input->post('bench'));
		$this->db->set('FACTS_OF_CASE', $this->input->post('facts_of_case'));
		$this->db->set('CASE_NOTE', $this->input->post('case_note'));
		$this->db->set('ROLE', $this->session->userdata('role'));

		if($this->session->userdata('role') == 'Admin')
			$this->db->set('TYPE', 'dbversion');
		else
			$this->db->set('TYPE', $this->input->post('status'));

		$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
		$this->db->set('UPDATED_ON', time());

		$this->db->update('law_notation');

		/* Statuate , Sub Section and Concept */
		$number_of_entries = count($this->input->post('statuate'));
		$statuate = $this->input->post('statuate');
		$subsection = $this->input->post('subsection');
		$concept = $this->input->post('concept');

		if($number_of_entries >= 0)
		{
			for ($i=0; $i <$number_of_entries ; $i++) { 
				
				$itemlist = array();

				if(($statuate[$i] == "") && ($concept[$i] == "") || ($nid == ""))
					continue;

				$itemlist['STATUATE'] = $statuate[$i];
				$itemlist['SUB_SECTION'] = $subsection[$i];
				$itemlist['CONCEPT'] = $concept[$i];
				$itemlist['NOTATIONID'] = $nid;

				$this->db->insert('law_notation_statuate', $itemlist); 
			}
		}

		/* Statuate , Sub Section and Concept */

		$numberOfCitationEntries = $this->input->post('numberOfCitationEntries');
		$citationNumber = $this->input->post('citationNumber');
		$listCaseName = $this->input->post('listCaseName');
		$typeCitation = $this->input->post('typeCitation');
		$treatment = $this->input->post('treatment');
		$note = $this->input->post('note');

		if($numberOfCitationEntries > 0)
		{
			for ($i=0; $i <$numberOfCitationEntries ; $i++) {
				
				$itemlist = array();

				if(($typeCitation[$i] == "")  || ($nid == ""))
					continue;

				$itemlist['CITATION'] = $this->_clean($citationNumber[$i]);
				$itemlist['ACTUAL_CITATION'] = $citationNumber[$i];
				if($this->_checkCitationAvailable($citationNumber[$i]) <= 0)
				{
					if($listCaseName[$i] != '')
						$l_caseName = $listCaseName[$i];
					else
						$l_caseName = 'No Casename';

					$this->_createMissingCitationDraft($citationNumber[$i], $l_caseName);
				}

				if($listCaseName[$i] !='')
					$itemlist['CASENUMBER'] = $listCaseName[$i];
				else
					$itemlist['CASENUMBER'] = 'No Casename';

				$itemlist['TYPE_OF_CITATION'] = $typeCitation[$i];
				$itemlist['DESCRIPTION'] = $note[$i];
				$itemlist['TREATMENT'] = $treatment[$i];
				$itemlist['NOTATIONID'] = $nid;

				$this->db->insert('law_citation_notation_link', $itemlist); 
			}
		}
		/* Word Pharse and Legal Definition */

		$number_of_phrase = count($this->input->post('phrase'));
		$phrase = $this->input->post('phrase');
		$legal = $this->input->post('legal');

		if($number_of_phrase >= 0)
		{
			for ($i=0; $i <$number_of_phrase ; $i++) { 
				
				$phraselist = array();

				if(($phrase[$i] == "")  || ($nid == ""))
					continue;

				$phraselist['PHRASE'] = $phrase[$i];
				$phraselist['EXPLANATION'] = $legal[$i];
				$phraselist['NOTATIONID'] = $nid;

				$this->db->insert('law_notation_phrase', $phraselist); 
			}
		}
		
		$listcitation = $this->input->post('citation');

		$this->db->where('NOTATIONID', $notationid);
		$this->db->delete('law_citation');

		if (strpos($listcitation, ';') !== false) {
			$citation_arr = explode(";",$listcitation);
			foreach($citation_arr as $lcitation)
			{
				$itemlist = array();
				$itemlist['CITATION'] = trim($lcitation);
				$itemlist['ACTUAL_CITATION'] = trim($this->_clean($lcitation));
				$itemlist['NOTATIONID'] = $notationid;
				$this->db->insert('law_citation', $itemlist);
				//print_r($itemlist); 
			}
		}
		else
		{
			$itemlist = array();
			$itemlist['CITATION'] = trim($this->input->post('citation'));
			$itemlist['ACTUAL_CITATION'] = trim($this->_clean($this->input->post('citation')));
			$itemlist['NOTATIONID'] = $notationid;
			$this->db->insert('law_citation', $itemlist); 
			//print_r($itemlist);
		}

		$listcasenumber = $this->input->post('casenumber');

		$this->db->where('NOTATIONID', $notationid);
		$this->db->delete('law_casenumber');

		if (strpos($listcasenumber, ';') !== false) {
			$casenumber_arr = explode(";",$listcasenumber);
			foreach($casenumber_arr as $lcasenumber)
			{
				$itemlist = array();
				$itemlist['CASENUMBER'] = trim($lcasenumber);
				$itemlist['NOTATIONID'] = $notationid;
				$this->db->insert('law_casenumber', $itemlist);
				//print_r($itemlist); 
			}
		}
		else
		{
			$itemlist = array();
			$itemlist['CASENUMBER'] = trim($this->input->post('casenumber'));
			$itemlist['NOTATIONID'] = $notationid;
			$this->db->insert('law_casenumber', $itemlist); 
			//print_r($itemlist);
		}

		$listofjudge = $this->input->post('judge_name');
		$this->db->where('NOTATIONID', $notationid);
		$this->db->delete('law_judgename');

		if (strpos($listofjudge, ';') !== false) {
			$judge_arr = explode(";",$listofjudge);
			foreach($judge_arr as $ljudge)
			{
				if($this->fnJudgeAvailable($ljudge) == 0)
				{
					$itemlist = array();
					$itemlist['JUDGE_NAME'] = trim($ljudge);
					$itemlist['NOTATIONID'] = $notationid;
					$this->db->insert('law_judgename', $itemlist);
				}
			}
		}
		else
		{
			$judgeName = $this->input->post('judge_name');
			if($this->fnJudgeAvailable($judgeName) == 0)
			{
				$itemlist = array();
				$itemlist['JUDGE_NAME'] = trim($this->input->post('judge_name'));
				$itemlist['NOTATIONID'] = $notationid;
				$this->db->insert('law_judgename', $itemlist); 
			}
		}

		return true;
	}

	function auditNotation($notationid)
	{
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('NOTATIONID', $notationid);
		$itemdata = array();
		$itemquery = $this->db->get();
		$productdata = array();
		if($itemquery->num_rows() > 0)
		{
			$itemresult = $itemquery->result_array();
			$i = 0;
			foreach($itemresult as $itemrow)
			{
				$itemdata['NOTATIONID'] = $notationid;
				$itemdata['HASHNOTATIONID'] = $itemrow['HASHNOTATIONID'];
				$itemdata['CASENAME'] = $itemrow['CASENAME'];
				$itemdata['CITATION'] = $itemrow['CITATION'];

				$itemdata['CASENUMBER'] = $itemrow['CASENUMBER'];
				$itemdata['JUDGE_NAME'] = $itemrow['JUDGE_NAME'];
				$itemdata['COURT_NAME'] = $itemrow['COURT_NAME'];
				$itemdata['YEAR'] = $itemrow['YEAR'];
				$itemdata['BENCH'] = $itemrow['BENCH'];
				$itemdata['FACTS_OF_CASE'] = $itemrow['FACTS_OF_CASE'];
				$itemdata['CASE_NOTE'] = $itemrow['CASE_NOTE'];
				$itemdata['TYPE'] = $itemrow['TYPE'];

				$itemdata['CREATED_BY'] = $itemrow['CREATED_BY'];
				$itemdata['CREATED_ON'] = $itemrow['CREATED_ON'];
				$itemdata['UPDATED_BY'] = $itemrow['UPDATED_BY'];
				$itemdata['UPDATED_ON'] = $itemrow['UPDATED_ON'];

				$itemdata['MODIFIED_ON'] = time();
				$itemdata['MODIFIED_BY'] = $this->session->userdata('userid');
				
				$this->db->insert('audit_law_notation', $itemdata); 
				
			}
			
		}
	}

	function auditNotationStatuate($notationid)
	{
		$this->db->select('*');
		$this->db->from('law_notation_statuate');
		$this->db->where('NOTATIONID', $notationid);
		$itemdata = array();
		$itemquery = $this->db->get();
		$productdata = array();
		if($itemquery->num_rows() > 0)
		{
			$itemresult = $itemquery->result_array();
			$i = 0;
			foreach($itemresult as $itemrow)
			{
				$itemdata['NOTATIONID'] = $notationid;
				$itemdata['STATUATE'] = $itemrow['STATUATE'];
				$itemdata['SUB_SECTION'] = $itemrow['SUB_SECTION'];
				$itemdata['CONCEPT'] = $itemrow['CONCEPT'];
				$itemdata['MODIFIED_ON'] = time();
				$itemdata['MODIFIED_BY'] = $this->session->userdata('userid');
				
				$this->db->insert('audit_law_notation_statuate', $itemdata); 
				
			}
			$this->db->where('NOTATIONID', $notationid);
			$this->db->delete('law_notation_statuate'); 
		}
	}

	function auditNotationCitation($notationid)
	{
		$this->db->select('*');
		$this->db->from('law_citation_notation_link');
		$this->db->where('NOTATIONID', $notationid);
		$itemdata = array();
		$itemquery = $this->db->get();
		$productdata = array();
		if($itemquery->num_rows() > 0)
		{
			$itemresult = $itemquery->result_array();
			$i = 0;
			foreach($itemresult as $itemrow)
			{
				$itemdata['NOTATIONID'] = $notationid;
				$itemdata['CITATION'] = $this->_clean($itemrow['CITATION']);
				$itemdata['ACTUAL_CITATION'] = $itemrow['ACTUAL_CITATION'];
				$itemdata['TYPE_OF_CITATION'] = $itemrow['TYPE_OF_CITATION'];
				$itemdata['DESCRIPTION'] = $itemrow['DESCRIPTION'];
				$itemdata['MODIFIED_ON'] = time();
				$itemdata['MODIFIED_BY'] = $this->session->userdata('userid');
				
				$this->db->insert('audit_law_citation_notation_link', $itemdata); 
				
			}
			$this->db->where('NOTATIONID', $notationid);
			$this->db->delete('law_citation_notation_link'); 
		}
	}

	function fetchStatusNotation($status)
	{
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('type', $status);
		$this->db->where('disable', 'N');
		$this->db->where('CREATED_BY', $this->session->userdata('userid'));

		$itemdata = array();
		$itemquery = $this->db->get();
		if($itemquery->num_rows() > 0)
		{
			return $itemquery->result_array();
		}
	}

	function fetchNewUserNotation()
	{
		$userid = $this->session->userdata('userid');

		$str = "SELECT * FROM law_notation WHERE (((created_by ='$userid' OR updated_by='$userid') AND TYPE!='draft')  
OR (TYPE='dbversion' OR TYPE='public')) AND DISABLE='N'";

		//$str = "select * from law_notation where (type='public' or type='dbversion'  or type='private') and disable='N'";
		$query = $this->db->query($str);
		return $query->result_array();
		/*
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where("('type'='public' or 'type'='dbversion')");
		//$this->db->orWhere('type', 'dbversion');
		
		$itemdata = array();
		$itemquery = $this->db->get();
		if($itemquery->num_rows() > 0)
		{
			return $itemquery->result_array();
		}
		*/
	}

	function fetchAllNotation()
	{

		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('type !=', 'draft');

		$itemdata = array();
		$itemquery = $this->db->get();
		if($itemquery->num_rows() > 0)
		{
			return $itemquery->result_array();
		}
	}

	function fetchUserNotation()
	{
		

		$userid = $this->session->userdata('userid');
		/*
		$where_au =	"((created_by = '$userid' or updated_by='$userid') and type != 'draft') or (type = 'dbversion' or type='public') and disable='N'";
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where($where_au);
		*/
		
		$str = "SELECT * FROM law_notation WHERE (((created_by ='$userid' OR updated_by='$userid') AND TYPE!='draft')  OR (TYPE='dbversion' OR TYPE='public')) AND DISABLE='N'";
		$query = $this->db->query($str);
		return $query->result_array();
		/*
		$itemdata = array();
		$itemquery = $this->db->get();
		if($itemquery->num_rows() > 0)
		{
			return $itemquery->result_array();
		}*/
	}

	public function fetchHashNotation()
	{
		$nid = $this->input->get('nid');
		//echo "Notation Id: ".$nid;
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('HASHNOTATIONID', $nid);		

		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			//print_r($result);
			$data = array();
			$citationval = '';
			foreach($result as $row)
			{
				$notationid = $row['NOTATIONID'];
				$data['notationid'] = $row['NOTATIONID'];
				$data['hashnotationid'] = $row['HASHNOTATIONID'];
				$data['casename'] = $row['CASENAME'];
				$data['citation'] = $row['CITATION'];
				$data['dup_citation'] = $row['DUP_CITATION'];
				$citationval = $row['DUP_CITATION'];

				$data['casenumber'] = $row['CASENUMBER'];
				$data['judge_name'] = $row['JUDGE_NAME'];
				$data['court_name'] = $row['COURT_NAME'];
				$data['year'] = $row['YEAR'];
				$data['bench'] = $row['BENCH'];
				$data['facts_of_case'] = $row['FACTS_OF_CASE'];
				$data['case_note'] = $row['CASE_NOTE'];
				
				$data['created_by'] = $row['CREATED_BY'];
				$data['created_on'] = $row['CREATED_ON'];
				$data['type'] = $row['TYPE'];
				
				$this->db->select('*');
				$this->db->from('law_notation_statuate');
				$this->db->where('notationid', $notationid);
				$statuateData = array();
				$statuatequery = $this->db->get();
				
				/*
				$casedata = array();
				print "select * from ips_case where ordertrackingid='".$row['ordertrackingid']."'";
				$casequery = $this->db->query("select * from ips_case where ordertrackingid='".$row['ordertrackingid']."'");
				*/
				if($statuatequery->num_rows() > 0)
				{
					$statuateresult = $statuatequery->result_array();
					$i = 0;
					foreach($statuateresult as $statuaterow)
					{
						$statuateData[$i]['statuate'] = $statuaterow['STATUATE'];
						$statuateid = $this->fetchUserStatuate($statuaterow['STATUATE']);
						$statuateData[$i]['hiddenstatuate'] = $statuateid;
						$statuateData[$i]['sub_section'] = $statuaterow['SUB_SECTION'];
						$subsectionid = $this->fetchUserSubSection($statuateid, $statuaterow['SUB_SECTION']);
						$statuateData[$i]['hiddensubsection'] = $subsectionid;
						$statuateData[$i]['concept'] = $statuaterow['CONCEPT'];
						$i++;
					}
				}
				$data['statuatedetails'] = $statuateData;
							
				
				$this->db->select('*');
				$this->db->from('law_citation_notation_link');
				$this->db->where('notationid', $notationid);
				$notationdata = array();
				$notationquery = $this->db->get();
				
				if($notationquery->num_rows() > 0)
				{
					$notationresult = $notationquery->result_array();
					$i = 0;
					foreach($notationresult as $notationrow)
					{
						$notationdata[$i]['citation'] = $notationrow['CITATION'];
						$notationdata[$i]['actual_citation'] = $notationrow['ACTUAL_CITATION'];
						$notationdata[$i]['type_of_citation'] = $notationrow['TYPE_OF_CITATION'];
						$notationdata[$i]['casenumber'] = $notationrow['CASENUMBER'];
						$notationdata[$i]['description'] = $notationrow['DESCRIPTION'];
						$notationdata[$i]['treatment'] = $notationrow['TREATMENT'];
						$i++;
					}
				}
				$data['citationdetails'] = $notationdata;
				
				$this->db->select('*');
				$this->db->from('law_citation_notation_link');
				$this->db->where('CITATION', $citationval);

				$datalink = array();
				$datalinkquery = $this->db->get();
				if($datalinkquery->num_rows() > 0)
				{
					$notationlink = $datalinkquery->result_array();
					$i = 0;
					foreach($notationlink as $notationrow)
					{
						$datalink[$i]['citation'] = $this->findDupCitation($notationrow['NOTATIONID']);
						$datalink[$i]['actual_citation'] = $this->findCitation($notationrow['NOTATIONID']);
						$datalink[$i]['type_of_citation'] = $this->findCitationType($notationrow['TYPE_OF_CITATION']).' in ';//$notationrow['TYPE_OF_CITATION'];
						$datalink[$i]['casenumber'] = $this->findCaseName($notationrow['NOTATIONID']);
						$datalink[$i]['description'] = $notationrow['DESCRIPTION'];
						$datalink[$i]['treatment'] = $notationrow['TREATMENT'];
						$i++;
					}
				}
				$data['linkdetails'] = $datalink;

				return $data;
			}
			
		}
	}

	public function fetchUserStatuate($name)
	{
		$userid = $this->session->userdata('userid');

		$query = $this->db->query("select ls.NAME as sname, ls.STID as stid from law_statuate ls where (ls.userid='$userid' or ls.userid='Admin')and (UPPER(ls.name) LIKE '%".strtoupper($name)."%')");

		$data = array();
		$stid ='';
		if ($query->num_rows() > 0)
		{

			$result = $query->result_array();
			foreach($result as $row)
			{
				$stid = $row['stid'];//i am not want item code i,eeeeeeeeeeee
			}
		}
		return $stid;	
	}

	public function fetchUserSubSection($statuateid, $subsection)
	{

		$name = $subsection;
		$userid = $this->session->userdata('userid');
		$statuate = $statuateid;

		$query = $this->db->query("select lsss.SSID as ssid, lsss.NAME as subname from law_statuate_sub_section lsss where (lsss.userid='$userid' or lsss.userid='Admin') and (UPPER(lsss.name) LIKE '%".strtoupper($name)."%') and STID='$statuate'");
		
		$data = array();
		$subsectionid = '';
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$subsectionid = $row['ssid'];//i am not want item code i,eeeeeeeeeeee
			}
		}
		return $subsectionid;
	}

	public function saveAsDraft()
	{
		$hashid = $this->input->post('hashid');
		//echo "Notation Id: ".$nid;
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('HASHNOTATIONID', $hashid);		
		
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			//print_r($result);
			$data = array();
			foreach($result as $row)
			{
				$notationid = $row['NOTATIONID'];
				//$data['notationid'] = $row['NOTATIONID'];
				//$data['hashnotationid'] = $row['HASHNOTATIONID'];
				$data['casename'] = $row['CASENAME'];
				$data['citation'] = $row['CITATION'];
				$data['judge_name'] = $row['JUDGE_NAME'];
				$data['court_name'] = $row['COURT_NAME'];
				$data['year'] = $row['YEAR'];
				$data['bench'] = $row['BENCH'];
				$data['facts_of_case'] = $row['FACTS_OF_CASE'];
				$data['case_note'] = $row['CASE_NOTE'];
				
				$data['created_by'] = $row['CREATED_BY'];
				$data['created_on'] = $row['CREATED_ON'];
				$data['type'] = 'draft';
				
				
				$this->db->insert('law_notation', $data); 
				$autoid = $this->db->insert_id();
				
				$this->db->where('id', $autoid);
				$nid = 'NT'.$autoid;
				$hashnid = md5($nid.time());
				$this->db->set('NOTATIONID', $nid);
				$this->db->set('HASHNOTATIONID', $hashnid);
				
				$this->db->set('CREATED_BY', $this->session->userdata('userid'));
				$this->db->set('CREATED_ON', time());

				$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
				$this->db->set('UPDATED_ON', time());
				$this->db->set('ROLE', $this->session->userdata('role'));

				$this->db->update('law_notation');

				/*
				$casedata = array();
				print "select * from ips_case where ordertrackingid='".$row['ordertrackingid']."'";
				$casequery = $this->db->query("select * from ips_case where ordertrackingid='".$row['ordertrackingid']."'");
				*/
				$this->db->select('*');
				$this->db->from('law_notation_statuate');
				$this->db->where('notationid', $notationid);
				$statuateData = array();
				$statuatequery = $this->db->get();
				
				if($statuatequery->num_rows() > 0)
				{
					$statuateresult = $statuatequery->result_array();
					foreach($statuateresult as $statuaterow)
					{

						$itemlist = array();

						if(($statuaterow['STATUATE'] == "") && ($statuaterow['CONCEPT'] == "") && ($nid == ""))
							continue;

						$itemlist['STATUATE'] = $statuaterow['STATUATE'];
						$itemlist['SUB_SECTION'] = $statuaterow['SUB_SECTION'];
						$itemlist['CONCEPT'] = $statuaterow['CONCEPT'];
						$itemlist['NOTATIONID'] = $nid;

						$this->db->insert('law_notation_statuate', $itemlist); 
					}
				}
				$data['statuatedetails'] = $statuateData;
							
				
				$this->db->select('*');
				$this->db->from('law_citation_notation_link');
				$this->db->where('notationid', $notationid);
				$notationdata = array();
				$notationquery = $this->db->get();
				
				if($notationquery->num_rows() > 0)
				{
					$notationresult = $notationquery->result_array();
					foreach($notationresult as $notationrow)
					{

						$itemlist = array();

						if(($notationrow['CITATION'] == "")  && ($nid == ""))
							continue;

						$itemlist['CITATION'] = $notationrow['CITATION'];
						$itemlist['ACTUAL_CITATION'] = $notationrow['ACTUAL_CITATION'];
						$itemlist['TYPE_OF_CITATION'] = $notationrow['TYPE_OF_CITATION'];
						$itemlist['DESCRIPTION'] = $notationrow['DESCRIPTION'];
						$itemlist['TREATMENT'] = $notationrow['TREATMENT'];
						$itemlist['NOTATIONID'] = $nid;

						$this->db->insert('law_citation_notation_link', $itemlist);
					}
				}
				
				$this->db->where('HASHNOTATIONID', $hashid);
				$this->db->set('ACTION', 'Y');
				$this->db->update('law_notation');
								
				return true;
			}
			
		}	
	}

	public function saveAsPrivate()
	{
		$hashid = $this->input->post('hashid');
		//echo "Notation Id: ".$nid;
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('HASHNOTATIONID', $hashid);		
		
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			//print_r($result);
			$data = array();
			foreach($result as $row)
			{
				$notationid = $row['NOTATIONID'];
				//$data['notationid'] = $row['NOTATIONID'];
				//$data['hashnotationid'] = $row['HASHNOTATIONID'];
				$data['casename'] = $row['CASENAME'];
				$data['citation'] = $row['CITATION'];
				$data['judge_name'] = $row['JUDGE_NAME'];
				$data['court_name'] = $row['COURT_NAME'];
				$data['year'] = $row['YEAR'];
				$data['bench'] = $row['BENCH'];
				$data['facts_of_case'] = $row['FACTS_OF_CASE'];
				$data['case_note'] = $row['CASE_NOTE'];
				
				$data['created_by'] = $row['CREATED_BY'];
				$data['created_on'] = $row['CREATED_ON'];
				$data['type'] = 'private';
				
				
				$this->db->insert('law_notation', $data); 
				$autoid = $this->db->insert_id();
				
				$this->db->where('id', $autoid);
				$nid = 'NT'.$autoid;
				$hashnid = md5($nid.time());
				$this->db->set('NOTATIONID', $nid);
				$this->db->set('HASHNOTATIONID', $hashnid);
				
				$this->db->set('CREATED_BY', $this->session->userdata('userid'));
				$this->db->set('CREATED_ON', time());

				$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
				$this->db->set('UPDATED_ON', time());
				$this->db->set('ROLE', $this->session->userdata('role'));

				$this->db->update('law_notation');

				/*
				$casedata = array();
				print "select * from ips_case where ordertrackingid='".$row['ordertrackingid']."'";
				$casequery = $this->db->query("select * from ips_case where ordertrackingid='".$row['ordertrackingid']."'");
				*/
				$this->db->select('*');
				$this->db->from('law_notation_statuate');
				$this->db->where('notationid', $notationid);
				$statuateData = array();
				$statuatequery = $this->db->get();
				
				if($statuatequery->num_rows() > 0)
				{
					$statuateresult = $statuatequery->result_array();
					foreach($statuateresult as $statuaterow)
					{

						$itemlist = array();

						if(($statuaterow['STATUATE'] == "") && ($statuaterow['CONCEPT'] == "") && ($nid == ""))
							continue;

						$itemlist['STATUATE'] = $statuaterow['STATUATE'];
						$itemlist['SUB_SECTION'] = $statuaterow['SUB_SECTION'];
						$itemlist['CONCEPT'] = $statuaterow['CONCEPT'];
						$itemlist['NOTATIONID'] = $nid;

						$this->db->insert('law_notation_statuate', $itemlist); 
					}
				}
				$data['statuatedetails'] = $statuateData;
							
				
				$this->db->select('*');
				$this->db->from('law_citation_notation_link');
				$this->db->where('notationid', $notationid);
				$notationdata = array();
				$notationquery = $this->db->get();
				
				if($notationquery->num_rows() > 0)
				{
					$notationresult = $notationquery->result_array();
					foreach($notationresult as $notationrow)
					{

						$itemlist = array();

						if(($notationrow['CITATION'] == "")  && ($nid == ""))
							continue;

						$itemlist['CITATION'] = $notationrow['CITATION'];
						$itemlist['ACTUAL_CITATION'] = $notationrow['ACTUAL_CITATION'];
						$itemlist['TYPE_OF_CITATION'] = $notationrow['TYPE_OF_CITATION'];
						$itemlist['DESCRIPTION'] = $notationrow['DESCRIPTION'];
						$itemlist['TREATMENT'] = $notationrow['TREATMENT'];
						$itemlist['NOTATIONID'] = $nid;

						$this->db->insert('law_citation_notation_link', $itemlist);
					}
				}


				$this->db->where('HASHNOTATIONID', $hashid);
				$this->db->set('ACTION', 'Y');
				$this->db->update('law_notation');
				
				return true;
			}

			
		}	
	}

	public function changeDbVersion()
	{
		$hashid = $this->input->post('hashid');

		$hashidArr = explode(',', $hashid);
		foreach ($hashidArr as $hashval) {
		
			$type = $this->findTypeofNotation(trim($hashval));

			$citationval = $this->findCitationNotation(trim($hashval));
			//if($type != "dbversion")
			//{
				$this->db->where('HASHNOTATIONID', $hashval);
				$this->db->set('CREATED_BY', $this->session->userdata('userid'));
				$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
				$this->db->set('UPDATED_ON', time());
				$this->db->set('TYPE', 'dbversion');

				$this->db->update('law_notation');

			//}
		}
		return true;
	}
	
	public function changePublicVersion()
	{
		$hashid = $this->input->post('hashid');

		$hashidArr = explode(',', $hashid);
		foreach ($hashidArr as $hashval) {
			//echo "HashVal: ".$hashval;
			$type = $this->findTypeofNotation(trim($hashval));
			
			if($type == "private")
			{
				$this->db->where('HASHNOTATIONID', $hashval);
				$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
				$this->db->set('UPDATED_ON', time());
				$this->db->set('TYPE', 'public');

				$this->db->update('law_notation');

			}
		}
		return true;
	}

	public function changePrivateVersion()
	{
		$hashid = $this->input->post('hashid');
		$this->db->where('HASHNOTATIONID', $hashid);
		
		$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
		$this->db->set('UPDATED_ON', time());
		$this->db->set('TYPE', 'private');

		$this->db->update('law_notation');

		return true;
	}

	public function changeDraftVersion()
	{
		$hashid = $this->input->post('hashid');

		$hashidArr = explode(',', $hashid);
		foreach ($hashidArr as $hashval) {
			//echo "HashVal: ".$hashval;
			if($this->findTypeofNotation(trim($hashval)) == "draft")
			{
				$this->db->where('HASHNOTATIONID', $hashval);
				$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
				$this->db->set('UPDATED_ON', time());
				$this->db->set('TYPE', 'private');
				$this->db->update('law_notation');		
			}
		}

		return true;
	}

	public function deleteNotation()
	{
		$hashid = $this->input->post('hashid');

		$hashidArr = explode(',', $hashid);
		foreach ($hashidArr as $hashval) {
			//echo "HashVal: ".$hashval;
			$type = $this->findTypeofNotation(trim($hashval));
			
			if($type == "draft" || $type == "private")
			{
				$this->db->where('HASHNOTATIONID', $hashval);
				$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
				$this->db->set('UPDATED_ON', time());
				//$this->db->set('TYPE', 'private');
				$this->db->set('DISABLE', 'Y');
				$this->db->update('law_notation');		
			}

			if($this->session->userdata('role') == 'Admin')
			{
				$this->db->where('HASHNOTATIONID', $hashval);
				$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
				$this->db->set('UPDATED_ON', time());
				//$this->db->set('TYPE', 'private');
				$this->db->set('DISABLE', 'Y');
				$this->db->update('law_notation');			
			}
		}

		return true;
	}

	/*
	public function deleteNotation()
	{
		$hashid = $this->input->post('hashid');
		$this->db->where('HASHNOTATIONID', $hashid);
		
		$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
		$this->db->set('UPDATED_ON', time());
		$this->db->set('DISABLE', 'Y');

		$this->db->update('law_notation');

		return true;
	}*/

	public function changeEditNotation()
	{
		$hashid = $this->input->post('hashid');

		$hashidArr = explode(',', $hashid);
		foreach ($hashidArr as $hashval) {
			//echo "HashVal: ".$hashval;
			$type = $this->findTypeofNotation(trim($hashval));
			
			if($type == "public" || $type == "dbversion")
			{
				$this->changeEditCopyVersion($hashval);	
			}
		}

		return true;
	}

	public function createCitationEditCopyVersion()
	{
		$hashid = $this->input->post('hashid');		
		$type = $this->findTypeofNotation(trim($hashid));
		if($type == "public" || $type == "dbversion")
		{
			$this->changeEditCopyVersion($hashid);	
		}
	}

	public function changeEditCopyVersion($hashid)
	{
		//$hashid = $this->input->post('hashid');
		//echo "Notation Id: ".$nid;
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('HASHNOTATIONID', $hashid);		
		
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			//print_r($result);
			$data = array();
			foreach($result as $row)
			{
				$notationid = $row['NOTATIONID'];
				//$data['notationid'] = $row['NOTATIONID'];
				//$data['hashnotationid'] = $row['HASHNOTATIONID'];
				$data['casename'] = $row['CASENAME'];
				$data['citation'] = $row['CITATION'];
				$data['dup_citation'] = $row['DUP_CITATION'];
				$data['casenumber'] = $row['CASENUMBER'];
				$data['judge_name'] = $row['JUDGE_NAME'];
				$data['court_name'] = $row['COURT_NAME'];
				$data['year'] = $row['YEAR'];
				$data['bench'] = $row['BENCH'];
				$data['facts_of_case'] = $row['FACTS_OF_CASE'];
				$data['case_note'] = $row['CASE_NOTE'];
				
				//$data['created_by'] = $row['CREATED_BY'];
				//$data['created_on'] = $row['CREATED_ON'];
				$data['type'] = 'draft';
				
				
				$this->db->insert('law_notation', $data); 
				$autoid = $this->db->insert_id();
				
				$this->db->where('id', $autoid);
				$nid = 'NT'.$autoid;
				$hashnid = md5($nid.time());
				$this->db->set('NOTATIONID', $nid);
				$this->db->set('HASHNOTATIONID', $hashnid);
				
				$this->db->set('CREATED_BY', $this->session->userdata('userid'));
				$this->db->set('CREATED_ON', time());

				$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
				$this->db->set('UPDATED_ON', time());
				$this->db->set('ROLE', $this->session->userdata('role'));

				$this->db->update('law_notation');

				/*
				$casedata = array();
				print "select * from ips_case where ordertrackingid='".$row['ordertrackingid']."'";
				$casequery = $this->db->query("select * from ips_case where ordertrackingid='".$row['ordertrackingid']."'");
				*/
				$this->db->select('*');
				$this->db->from('law_notation_statuate');
				$this->db->where('notationid', $notationid);
				$statuateData = array();
				$statuatequery = $this->db->get();
				
				if($statuatequery->num_rows() > 0)
				{
					$statuateresult = $statuatequery->result_array();
					foreach($statuateresult as $statuaterow)
					{

						$itemlist = array();

						if(($statuaterow['STATUATE'] == "") && ($statuaterow['CONCEPT'] == "") && ($nid == ""))
							continue;

						$itemlist['STATUATE'] = $statuaterow['STATUATE'];
						$itemlist['SUB_SECTION'] = $statuaterow['SUB_SECTION'];
						$itemlist['CONCEPT'] = $statuaterow['CONCEPT'];
						$itemlist['NOTATIONID'] = $nid;

						$this->db->insert('law_notation_statuate', $itemlist); 
					}
				}
				$data['statuatedetails'] = $statuateData;
							
				
				$this->db->select('*');
				$this->db->from('law_citation_notation_link');
				$this->db->where('notationid', $notationid);
				$notationdata = array();
				$notationquery = $this->db->get();
				
				if($notationquery->num_rows() > 0)
				{
					$notationresult = $notationquery->result_array();
					foreach($notationresult as $notationrow)
					{

						$itemlist = array();

						if(($notationrow['CITATION'] == "")  && ($nid == ""))
							continue;

						$itemlist['CITATION'] = $notationrow['CITATION'];
						$itemlist['ACTUAL_CITATION'] = $notationrow['ACTUAL_CITATION'];
						$itemlist['TYPE_OF_CITATION'] = $notationrow['TYPE_OF_CITATION'];
						$itemlist['DESCRIPTION'] = $notationrow['DESCRIPTION'];
						$itemlist['TREATMENT'] = $notationrow['TREATMENT'];
						$itemlist['NOTATIONID'] = $nid;

						$this->db->insert('law_citation_notation_link', $itemlist);
					}
				}
				
				$this->db->where('HASHNOTATIONID', $hashid);
				$this->db->set('ACTION', 'Y');
				$this->db->update('law_notation');
								
				return true;
			}
			
		}	
	}

	public function dbVersion()
	{

		$hashid = $this->input->post('hashid');
		//echo "Notation Id: ".$nid;
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('HASHNOTATIONID', $hashid);		
		
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			//print_r($result);
			$data = array();
			foreach($result as $row)
			{
				$notationid = $row['NOTATIONID'];
				//$data['notationid'] = $row['NOTATIONID'];
				//$data['hashnotationid'] = $row['HASHNOTATIONID'];
				$data['casename'] = $row['CASENAME'];
				$data['citation'] = $row['CITATION'];
				$data['judge_name'] = $row['JUDGE_NAME'];
				$data['court_name'] = $row['COURT_NAME'];
				$data['year'] = $row['YEAR'];
				$data['bench'] = $row['BENCH'];
				$data['facts_of_case'] = $row['FACTS_OF_CASE'];
				$data['case_note'] = $row['CASE_NOTE'];
				
				$data['created_by'] = $row['CREATED_BY'];
				$data['created_on'] = $row['CREATED_ON'];
				$data['type'] = 'dbversion';
				
				
				$this->db->insert('law_notation', $data); 
				$autoid = $this->db->insert_id();
				
				$this->db->where('id', $autoid);
				$nid = 'NT'.$autoid;
				$hashnid = md5($nid.time());
				$this->db->set('NOTATIONID', $nid);
				$this->db->set('HASHNOTATIONID', $hashnid);
				
				$this->db->set('CREATED_BY', $this->session->userdata('userid'));
				$this->db->set('CREATED_ON', time());

				$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
				$this->db->set('UPDATED_ON', time());
				$this->db->set('ROLE', $this->session->userdata('role'));

				$this->db->update('law_notation');

				/*
				$casedata = array();
				print "select * from ips_case where ordertrackingid='".$row['ordertrackingid']."'";
				$casequery = $this->db->query("select * from ips_case where ordertrackingid='".$row['ordertrackingid']."'");
				*/
				$this->db->select('*');
				$this->db->from('law_notation_statuate');
				$this->db->where('notationid', $notationid);
				$statuateData = array();
				$statuatequery = $this->db->get();
				
				if($statuatequery->num_rows() > 0)
				{
					$statuateresult = $statuatequery->result_array();
					foreach($statuateresult as $statuaterow)
					{

						$itemlist = array();

						if(($statuaterow['STATUATE'] == "") && ($statuaterow['CONCEPT'] == "") && ($nid == ""))
							continue;

						$itemlist['STATUATE'] = $statuaterow['STATUATE'];
						$itemlist['SUB_SECTION'] = $statuaterow['SUB_SECTION'];
						$itemlist['CONCEPT'] = $statuaterow['CONCEPT'];
						$itemlist['NOTATIONID'] = $nid;

						$this->db->insert('law_notation_statuate', $itemlist); 
					}
				}
				$data['statuatedetails'] = $statuateData;
							
				
				$this->db->select('*');
				$this->db->from('law_citation_notation_link');
				$this->db->where('notationid', $notationid);
				$notationdata = array();
				$notationquery = $this->db->get();
				
				if($notationquery->num_rows() > 0)
				{
					$notationresult = $notationquery->result_array();
					foreach($notationresult as $notationrow)
					{

						$itemlist = array();

						if(($notationrow['CITATION'] == "")  && ($nid == ""))
							continue;

						$itemlist['CITATION'] = $notationrow['CITATION'];
						$itemlist['ACTUAL_CITATION'] = $notationrow['ACTUAL_CITATION'];
						$itemlist['TYPE_OF_CITATION'] = $notationrow['TYPE_OF_CITATION'];
						$itemlist['DESCRIPTION'] = $notationrow['DESCRIPTION'];
						$itemlist['TREATMENT'] = $notationrow['TREATMENT'];
						$itemlist['NOTATIONID'] = $nid;

						$this->db->insert('law_citation_notation_link', $itemlist);
					}
				}

				$this->db->where('HASHNOTATIONID', $hashid);
				$this->db->set('ACTION', 'Y');
				$this->db->update('law_notation');
				
				return true;
			}
			
		}
		
	}

	public function chkCasenameAndCitation($casename, $citation, $ntype)
	{
		$userid =  $this->session->userdata('userid');
		//ED23883, RD233
		# casename CA99821
		# citation	ED23883, RD23232
		$citation_arr = explode(",",$citation);

		$chkAvailable = 0;
		foreach($citation_arr as $lcitation)
		{
			if($ntype != ''){

				$query = $this->db->query("select casename, notationid, hashnotationid, count(notationid) as cntname  from law_notation where notationid<>'$ntype' and (created_by='$userid' or UPDATED_BY='userid' ) AND  (type='dbversion' OR type='public') AND (UPPER(CASENAME) = '".$casename."') AND ((UPPER(CITATION) LIKE '%".strtoupper(trim($lcitation))."%') OR (UPPER(DUP_CITATION) LIKE '%".strtoupper(trim($lcitation))."%')) group by notationid");	
			}
			else
			{
				$query = $this->db->query("select casename, notationid, hashnotationid, count(notationid) as cntname  from law_notation where (created_by='$userid' or UPDATED_BY='userid' ) AND  (type='dbversion' OR type='public') AND (UPPER(CASENAME) = '".$casename."') AND ((UPPER(CITATION) LIKE '%".strtoupper(trim($lcitation))."%') OR (UPPER(DUP_CITATION) LIKE '%".strtoupper(trim($lcitation))."%')) group by notationid");
			}

			$count = 0;
			$result = $query->result_array();
			$details = '';
			foreach($result as $row)
			{
				$count = $row['cntname'];
				if($count > 0)
				{
					$uniqueid = "'".$row['hashnotationid']."'";
					//'action' => "<a  style='margin-left:10px;' href=".site_url('user/viewnotation')."?nid=".$r['HASHNOTATIONID']."><span class='glyphicon glyphicon-eye-open'></span></a>"
					$details .= '<a  style="margin-right:5px;" class="btn btn-success" href="javascript:viewCitation('.$uniqueid.')">'.$row['casename'].' <span class="glyphicon glyphicon-eye-open"></span></a>';
				}
			}

		}

		return $details;
		
	}

	public function _clean($string) {
   		//$string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.
  	 	return preg_replace('/[^a-zA-Z0-9]/', '', $string); // Removes special chars.
	}

	public function _cleanWithSemicolon($string) {
   		//$string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.
  	 	return preg_replace('/[^a-zA-Z0-9]/', '', $string); // Removes special chars.
	}

	public function _checkCitationAvailable($citation)
	{
		$userid =  $this->session->userdata('userid');

		$query = $this->db->query("select count(citation) as cntname from law_notation  where (created_by='$userid' or UPDATED_BY='userid' ) AND  (type='dbversion' OR type='public' OR type='draft') AND (UPPER(citation) = '".strtoupper($citation)."')");
		
		$data = array();
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['cntname'];//i am not want item code i,eeeeeeeeeeee
		}

		return $count;
	}

	public function _createMissingCitationDraft($citation, $l_caseName)
	{
		$data['casename'] = $l_caseName;
		$data['citation'] = $citation;
		$data['dup_citation'] = $this->_clean($citation);

		$this->db->insert('law_notation', $data); 
		$autoid = $this->db->insert_id();
		
		$this->db->where('id', $autoid);
		$nid = 'NT'.$autoid;
		$hashnid = md5($nid.time());
		$this->db->set('NOTATIONID', $nid);
		$this->db->set('HASHNOTATIONID', $hashnid);
		
		$this->db->set('CREATED_BY', $this->session->userdata('userid'));
		$this->db->set('CREATED_ON', time());

		$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
		$this->db->set('UPDATED_ON', time());
		$this->db->set('ROLE', $this->session->userdata('role'));

		$this->db->update('law_notation');

	}

	public function searchStringCollection($searchString)
	{
		$userid =  $this->session->userdata('userid');

		$listOfSearchStringArray = explode("--^--",$searchString);

		$searchFields = array();

		foreach ($listOfSearchStringArray as $ss_arr) {
		  $searchStringContent = explode('--$$--', $ss_arr);
		  array_push($searchFields,$searchStringContent[0]); 
		}

		$strFields = array('statuate','sub_section','concept');
		$searchResult = false;
		foreach($strFields as $fields)
		{
			if (in_array($fields, $searchFields))
				$searchResult = true;	  
		}

		
		if($searchResult)
		{
			$searchQuery = "SELECT * FROM law_notation lno INNER JOIN law_notation_statuate lns ON lno.notationid = lns.notationid WHERE  ((created_by='$userid' OR UPDATED_BY='$userid') OR (TYPE='dbversion' OR TYPE='public') ) AND ";
		}
		else
		{
			$searchQuery = "SELECT * FROM law_notation WHERE ((created_by='$userid' OR UPDATED_BY='$userid') OR (TYPE='dbversion' OR TYPE='public') ) AND ";	
		}

		//$searchQuery = "SELECT * FROM law_notation lno INNER JOIN law_notation_Statuate lns ON lno.notationid = lns.notationid WHERE  ((created_by='$userid' OR UPDATED_BY='$userid') OR (TYPE='dbversion' OR TYPE='public') ) AND ";

		$allColumn = 'casename, citation, dup_citation, casenumber, judge_name, court_name, YEAR, bench, facts_of_case, statuate, sub_section, concept';
		
		$i = 0;
		foreach ($listOfSearchStringArray as $ss_arr) {
			$searchStringContent = explode('--$$--', $ss_arr);
			
			if(isset($searchStringContent[1])){
				if($searchStringContent[1] !='')
				{
					$searchColumn = $searchStringContent[0];
					$searchContent = $searchStringContent[1];
					$logical = $searchStringContent[2];

					if($searchColumn != '')
					{
						if($i == 0)
							$searchQuery .= "  MATCH ( ".$searchColumn." ) AGAINST ("."'".$searchContent."*'"." IN BOOLEAN MODE) ";
						else
							$searchQuery .= $logical."  MATCH ( ".$searchColumn." ) AGAINST ("."'".$searchContent."*'"." IN BOOLEAN MODE) ";
					}
					else
					{
						if($i == 0)
							$searchQuery .= "  MATCH ( ".$allColumn." ) AGAINST ("."'".$searchContent."*'"." IN BOOLEAN MODE) ";
						else
							$searchQuery .= $logical."  MATCH ( ".$allColumn." ) AGAINST ("."'".$searchContent."*'"." IN BOOLEAN MODE) ";
					}
					++$i;
				}
			}
		}
		//echo $searchQuery;
		$query = $this->db->query($searchQuery);
		return $query->result_array();
	}

	public function fnStatuateAvailable($statuateName, $userid)
	{
		$query = $this->db->query("select count(name) as cntname from law_statuate  where (UPPER(name) = '".strtoupper($statuateName)."') and (userid='".$userid."' or role='Admin')");
		
		$data = array();
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['cntname'];//i am not want item code i,eeeeeeeeeeee
		}
		
		return $count;
	}

	public function fnJudgeAvailable($judgeName)
	{

		$query = $this->db->query("select count(judge_name) as cntname from law_judgename  where (UPPER(judge_name) = '".strtoupper(trim($judgeName))."') ");
		
		$data = array();
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['cntname'];//i am not want item code i,eeeeeeeeeeee
		}
		
		return $count;
	}

	public function fnNotationStatuateAvailable($statuate, $subsection, $concept, $nid)
	{
		$query = $this->db->query("select count(STATUATE) as cntname from law_notation_statuate  where (UPPER(STATUATE) = '".strtoupper($statuate)."') and (UPPER(SUB_SECTION) = '".strtoupper($subsection)."') and (UPPER(CONCEPT) = '".strtoupper($concept)."') and (NOTATIONID='".$nid."')");
		
		$data = array();
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['cntname'];//i am not want item code i,eeeeeeeeeeee
		}
		
		return $count;
	}

	public function fnSubSectionAvailable($subSection, $userid, $ctid)
	{
		
		$query = $this->db->query("select count(name) as cntname from law_statuate_sub_section where STID IN (select STID from law_statuate  where (stid = '".$ctid."') and (userid='".$userid."' or role='Admin')) and upper(name)='".strtoupper($subSection)."'");
		
		$data = array();
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['cntname'];//i am not want item code i,eeeeeeeeeeee
		}
		
		return $count;	
	}

	public function fnConceptAvailable($conceptName, $userid)
	{
		$query = $this->db->query("select count(name) as cntname from law_concepts  where (UPPER(name) = '".strtoupper($conceptName)."') and (userid='".$userid."' or role='Admin')");
		
		$data = array();
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['cntname'];//i am not want item code i,eeeeeeeeeeee
		}
		return $count;	
	}

	public function fnFetchConceptId($conceptName, $userid)
	{
		$query = $this->db->query("select CID from law_concepts  where (UPPER(name) = '".strtoupper($conceptName)."') and (userid='".$userid."' or role='Admin')");
		
		$data = array();
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['CID'];//i am not want item code i,eeeeeeeeeeee
		}
		return $count;		
	}

	public function findCitationType($citation)
	{
		
		//$query = $this->db->query("select * from law_type_of_citation where CIID  = '".$citation."'");
		$query = $this->db->query("select * from law_type_of_citation where NAME  like '".$citation."'");
		$result = $query->result_array();
		$name = '';
		foreach($result as $r)
		{
			$name = $r['NAME'];
		}

		return $name;
	}

	public function findDupCitation($notationid)
	{
		$query = $this->db->query("select dup_citation from law_notation where notationid  = '".$notationid."'");
		$result = $query->result_array();
		$name = '';
		foreach($result as $r)
		{
			$name = $r['dup_citation'];
		}

		return $name;	
	}

	public function findCitation($notationid)
	{
		$query = $this->db->query("select citation from law_notation where notationid  = '".$notationid."'");
		$result = $query->result_array();
		$name = '';
		foreach($result as $r)
		{
			$name = $r['citation'];
		}

		return $name;	
	}

	public function findCasenumber($notationid)
	{
		$query = $this->db->query("select casenumber from law_notation where notationid  = '".$notationid."'");
		$result = $query->result_array();
		$name = '';
		foreach($result as $r)
		{
			$name = $r['casenumber'];
		}

		return $name;	
	}

	public function findCaseName($notationid)
	{
		$query = $this->db->query("select casename from law_notation where notationid  = '".$notationid."'");
		$result = $query->result_array();
		$name = '';
		foreach($result as $r)
		{
			$name = $r['casename'];
		}

		return $name;	
	}

	public function findJudgeName($notationid)
	{
		$query = $this->db->query("select judge_name from law_notation where notationid  = '".$notationid."'");
		$result = $query->result_array();
		$name = '';
		foreach($result as $r)
		{
			$name = $r['judge_name'];
		}

		return $name;	
	}

	public function findCourtname($notationid)
	{
		$query = $this->db->query("select court_name from law_notation where notationid  = '".$notationid."'");
		$result = $query->result_array();
		$name = '';
		foreach($result as $r)
		{
			$name = $r['court_name'];
		}

		return $name;	
	}

	public function findFactofCase($notationid)
	{
		$query = $this->db->query("select facts_of_case from law_notation where notationid  = '".$notationid."'");
		$result = $query->result_array();
		$name = '';
		foreach($result as $r)
		{
			$name = $r['facts_of_case'];
		}

		return $name;	
	}

	public function findCaseNotes($notationid)
	{
		$query = $this->db->query("select case_note from law_notation where notationid  = '".$notationid."'");
		$result = $query->result_array();
		$name = '';
		foreach($result as $r)
		{
			$name = $r['case_note'];
		}

		return $name;	
	}

	public function findTypeofNotation($hashnotationid)
	{
		//echo "select type from law_notation where hashnotationid  = '".$hashnotationid."'";
		$query = $this->db->query("select type from law_notation where hashnotationid  = '".$hashnotationid."'");
		$result = $query->result_array();
		$type = '';
		foreach($result as $r)
		{
			$type = $r['type'];
		}

		return $type;	
	}

	public function findCitationNotation($hashnotationid)
	{
		$query = $this->db->query("select citation from law_notation where hashnotationid  = '".$hashnotationid."'");
		$result = $query->result_array();
		$listcitation = '';
		foreach($result as $r)
		{
			$listcitation = $r['citation'];
		}

		if($listcitation != '')
		{
			if (strpos($listcitation, ';') !== false) {
				$citation_arr = explode(";",$listcitation);
				foreach($citation_arr as $lcitation)
				{
					$citationval = trim($this->_clean($lcitation));
					if($citationval!='')
					{

						$dubcitation = $this->_clean($citationval);
						$this->db->query("update law_notation set type='public' where (type = 'public' or type = 'dbversion') and dup_citation like '%$dubcitation%'");
					}
				}
				
			}
			else
			{

				$dubcitation = $this->_clean($citationval);
				$this->db->query("update law_notation set type='public' where (type = 'public' or type = 'dbversion') and dup_citation like '%$dubcitation%'");
			}
		}
	}

	public function checkCitationTypeAvailable($citationType){
				
		$query = $this->db->query("select count(name) as cntname from law_type_of_citation where (UPPER(name) = '".strtoupper($citationType)."')");
		
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

	public function insertCitationType($citationType){

		$role = $this->session->userdata('role');
		
		$data = array();
		$data['NAME'] = $citationType;
		$data['DISABLE'] = 'N';		

		$this->db->insert('law_type_of_citation', $data); 
		$autoid = $this->db->insert_id();
		
		$this->db->where('id', $autoid);
		$ctid = 'CIID'.$autoid;
		
		$this->db->set('CIID', $ctid);
			
		$this->db->update('law_type_of_citation');

		$dArray = array();
		array_push($dArray, true);
		return $dArray;
	}

	public function fetchCitationAvailable()
	{
		$listcitation = $this->input->post('citation');
		$citationStr = 'AND  (';

		if (strpos($listcitation, ';') !== false) {
			$citation_arr = explode(";",$listcitation);
			foreach($citation_arr as $lcitation)
			{
				$citationval = trim($this->_clean($lcitation));
				if($citationval!='')
				{
					$citationStr .= "( ACTUAL_CITATION = '".$citationval."') ";
                	$citationStr .= " OR " ;	
				}
			}
			
			$removelast_or = strlen($citationStr) - 4;
	        $citationStr = substr($citationStr, 0, $removelast_or);
	        $citationStr .= " ) ";
		}
		else
		{

			$citationval = trim($this->_clean($this->input->post('citation')));
			$citationStr .= "( ACTUAL_CITATION = '".$citationval."') ";
			$citationStr .= " ) ";
		}

		//echo $citationStr;
		$userid =  $this->session->userdata('userid');
		
		//echo "select count(notationid) as cntname  from law_notation where (created_by='$userid' or UPDATED_BY='$userid' ) AND  (type='dbversion' OR type='public') ".$citationStr." ";

		//$query = $this->db->query("select count(notationid) as cntname  from law_notation where (created_by='$userid' or UPDATED_BY='$userid' OR type='dbversion' OR type='public') ".$citationStr);
		
		//echo "select COUNT(lan.notationid) AS cntname, hashnotationid, TYPE, lan.citation  FROM law_notation lan INNER JOIN law_citation lc ON lan.notationid=lc.notationid WHERE ((created_by='$userid' OR UPDATED_BY='$userid') OR (TYPE='dbversion' OR TYPE='public') ) AND TYPE!='draft' ".$citationStr."  GROUP BY hashnotationid, TYPE, lan.citation";

		$query = $this->db->query("select COUNT(lan.notationid) AS cntname, hashnotationid, type, lan.citation  FROM law_notation lan INNER JOIN law_citation lc ON lan.notationid=lc.notationid WHERE ((created_by='$userid' OR UPDATED_BY='$userid') OR (TYPE='dbversion' OR TYPE='public') ) AND TYPE!='draft' ".$citationStr."  GROUP BY hashnotationid, TYPE, lan.citation");


		//$query = $this->db->query("select COUNT(notationid) AS cntname, hashnotationid, type, citation  FROM law_notation WHERE ((created_by='$userid' OR UPDATED_BY='$userid') OR (TYPE='dbversion' OR TYPE='public') ) AND TYPE!='draft' ".$citationStr." GROUP BY hashnotationid, type, citation");
 

		$data = array();
		$valueExist = 0;
		$result = $query->result_array();
		$tableDetails = '<table class="table table-bordered table-hover tableCitation">	<thead>	<tr><th>Citation</th><th>Type</th><th>Edit Copy</th></tr></thead><tbody>';
		foreach ($result as $row) {
			$valueExist = 1;
			$tableDetails .= "<tr><td><a  style='margin-left:10px;' href=".site_url('user/editnotation')."?nid=".$row['hashnotationid'].">".$row['citation']."</a></td><td>".$row['type']."</td>";
			
			if($row['type'] == 'dbversion' || $row['type'] == 'public')
				$tableDetails .= "<td><button style='margin-left:10px;' type='button' class='btn btn-info btnEditDraftCopy' value=".$row['hashnotationid']."> Make Edit Copy </button></td>";
			else
				$tableDetails .= "<td>--</td>";
					
			$tableDetails .= "</tr>";
		}
		$tableDetails .= "</tbody></table>" ;
		
		array_push($data, $valueExist);
		array_push($data, $tableDetails);
		/*
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['cntname'];//i am not want item code i,eeeeeeeeeeee
		}

		if ($count > 0)
		{
			array_push($data, true);
		}
		else{
			array_push($data, false);
		}*/
		
		return $data;

	}

	public function fetchPdfHashNotation()
	{
		$nid = $this->input->get('nid');
		//echo "Notation Id: ".$nid;
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('HASHNOTATIONID', $nid);		

		$query = $this->db->get();

		$html = '';
		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			//print_r($result);
			$data = array();
			$citationval = '';
			foreach($result as $row)
			{
				$notationid = $row['NOTATIONID'];

				$html .= '
				<div style="text-align:center;"><h2>Notation Details</h2></div>

				<table>
					<thead>
						<tr>
							<th><span  style="font-weight:bold;">Case Name: </span>'.$row['CASENAME'].'</th>
							<th><span  style="font-weight:bold;">Citation: </span>'.$row['CITATION'].'</th>
						</tr>
					</thead>
				</table>

			<div class="panel panel-info">
				
                <div class="panel-heading" style="font-weight:bold;">Case Information</div>
                <div class="panel-body">
            		<div class="row-fluid">';
						
				$html .= '
						<div class="span3">
							<label class="control-label" style="font-weight:bold; ">Court assigned case number: </label>';


				$html .= $row['CASENUMBER'];

				$html .= '
						</div>
						<div class="span3">
							<label class="control-label" style="font-weight:bold;">Court Name: </label>';
				$html .= $row['COURT_NAME'];

				$html .= '
						</div>

						<div class="span3">
							<label class="control-label" style="font-weight:bold;">Judge Name: </label>';

				$html .= ucfirst($row['JUDGE_NAME']);

				$html .= '
						</div>
						<div class="span3">
							<label class="control-label" style="font-weight:bold;">Year of Judgement: </label>';

				$html .= $row['YEAR'];
				
				$html .= '
						</div>
						<div class="span3">
							<label class="control-label" style="font-weight:bold;">Type of Bench: </label>';

				$html .= $row['BENCH'];

				$html .= '
						</div>
						
						<div class="span3">
							<label  class="control-label" style="font-weight:bold;">Status: </label>';

				$html .= ucfirst($row['TYPE']);

				$html .= '
						</div>

						<div class="span8">
							<label  class="control-label" style="font-weight:bold;">Notes:</label>';

				$html .= $row['FACTS_OF_CASE'];

				$html .=	'</div>
					</div>';

            	$this->db->select('*');
				$this->db->from('law_notation_statuate');
				$this->db->where('notationid', $notationid);
				$statuateData = array();
				$statuatequery = $this->db->get();
				
				if($statuatequery->num_rows() > 0)
				{
					$html .= '<BR/>';
					$html .= '<h3>Statute and Concepts</h3>';
	            	$html .= '<table class="table table-bordered table-hover tableStatuate" border="1">
									<thead>
										<tr>
											<th>ID</th>
											<th>Statute</th>
											<th>Section & Subsection</th>
											<th>Concept</th>
										</tr>
									</thead>
									<tbody>
								';

					$statuateresult = $statuatequery->result_array();
					$k = 0;
					foreach($statuateresult as $statuaterow)
					{
						$html .= '<tr>';
						$html .= '<td>'.($k+1) .'</td>';
						$html .= '<td>'.$statuaterow['STATUATE'].'</td>';
						$html .= '<td>'.$statuaterow['SUB_SECTION'].'</td>';
						$html .= '<td>'.$statuaterow['CONCEPT'].'</td>';
						$html .='</tr>';

						$k++;
					}

					$html .='</tbody>
							</table>';
            	}

            	$this->db->select('*');
				$this->db->from('law_citation_notation_link');
				$this->db->where('notationid', $notationid);
				$notationdata = array();
				$notationquery = $this->db->get();
				
				if($notationquery->num_rows() > 0)
				{
					$html .= '<BR/>';
					$html .= '<h3>List of Citation</h3>';
					$html .= '<table class="table table-bordered table-hover tableCitation" border="1">
								<thead>
									<tr>
										<th>Type of Citation</th>
										<th>Treatment</th>
										<th>Case Name</th>
										<th>Citation Number</th>
										<th>Notes</th>
									</tr>
								</thead>
								<tbody>';

					$notationresult = $notationquery->result_array();
					$i = 0;
					foreach($notationresult as $notationrow)
					{
						$html .= '<tr>';
						$html .= '<td>'.$notationrow['TYPE_OF_CITATION'].'</td>';
						$html .= '<td>'.$notationrow['TREATMENT'].'</td>';
						$html .= '<td>'.$notationrow['CASENUMBER'].'</td>';
						$html .= '<td>'.$notationrow['ACTUAL_CITATION'].'</td>';
						$html .= '<td>'.$notationrow['DESCRIPTION'].'</td>';
						$html .='</tr>';

						$i++;
					}

					$html .='</tbody>
							</table>';
				}
            	/*		
				
			
				$this->db->select('*');
				$this->db->from('law_citation_notation_link');
				$this->db->where('CITATION', $citationval);

				$datalink = array();
				$datalinkquery = $this->db->get();
				if($datalinkquery->num_rows() > 0)
				{
					$notationlink = $datalinkquery->result_array();
					$i = 0;
					foreach($notationlink as $notationrow)
					{
						$datalink[$i]['citation'] = $this->findDupCitation($notationrow['NOTATIONID']);
						$datalink[$i]['actual_citation'] = $this->findCitation($notationrow['NOTATIONID']);
						$datalink[$i]['type_of_citation'] = $this->findCitationType($notationrow['TYPE_OF_CITATION']).' in ';//$notationrow['TYPE_OF_CITATION'];
						$datalink[$i]['casenumber'] = $this->findCaseName($notationrow['NOTATIONID']);
						$datalink[$i]['description'] = $notationrow['DESCRIPTION'];
						$datalink[$i]['treatment'] = $notationrow['TREATMENT'];
						$i++;
					}
				}
				$data['linkdetails'] = $datalink;
				*/
				return $html;
			}
			
		}
	}

	public function fetchNotationDetails($nid)
	{
		/*
		$this->notationid = '';
		$this->hashnotationid = '';
		$this->casename = '';
		$this->citation = '';
		$this->dup_citation = '';
		$this->casenumber = '';
		$this->judge_name = '';
		$this->courtname = '';
		$this->year = '';
		$this->bench = '';
		$this->facts_of_case = '';
		$this->case_note = '';
		$this->created_by = '';
		$this->created_on = '';
		$this->type = '';
		*/
		//$nid = $this->input->get('nid');
		//echo "Notation Id: ".$nid;
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('NOTATIONID', $nid);		

		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			//print_r($result);
			$data = array();
			$citationval = '';
			foreach($result as $row)
			{
				$this->notationid = $row['NOTATIONID'];
				$this->hashnotationid = $row['HASHNOTATIONID'];
				$this->casename = $row['CASENAME'];
				$this->citation = $row['CITATION'];
				$this->dup_citation = $row['DUP_CITATION'];
				$this->casenumber = $row['CASENUMBER'];
				$this->judge_name = $row['JUDGE_NAME'];
				$this->courtname = $row['COURT_NAME'];
				$this->year = $row['YEAR'];
				$this->bench = $row['BENCH'];
				$this->facts_of_case = $row['FACTS_OF_CASE'];
				$this->case_note = $row['CASE_NOTE'];
				$this->created_by = $row['CREATED_BY'];
				$this->created_on = $row['CREATED_ON'];
				$this->type = $row['TYPE'];

				/*
				$notationid = $row['NOTATIONID'];
				$data['notationid'] = $row['NOTATIONID'];
				$data['hashnotationid'] = $row['HASHNOTATIONID'];
				$data['casename'] = $row['CASENAME'];
				$data['citation'] = $row['CITATION'];
				$data['dup_citation'] = $row['DUP_CITATION'];
				$citationval = $row['DUP_CITATION'];

				$data['casenumber'] = $row['CASENUMBER'];
				$data['judge_name'] = $row['JUDGE_NAME'];
				$data['court_name'] = $row['COURT_NAME'];
				$data['year'] = $row['YEAR'];
				$data['bench'] = $row['BENCH'];
				$data['facts_of_case'] = $row['FACTS_OF_CASE'];
				$data['case_note'] = $row['CASE_NOTE'];
				
				$data['created_by'] = $row['CREATED_BY'];
				$data['created_on'] = $row['CREATED_ON'];
				$data['type'] = $row['TYPE'];
				*/
				return $row;
			}
			
		}
	}

}
/* End of file Logindetailsmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */