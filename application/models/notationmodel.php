<?php 
class Notationmodel extends CI_Model {

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
		$query = $this->db->query("select casename from law_notation where (UPPER(casename) LIKE '%".strtoupper($casename)."%')");
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

	function createNotation($data)
	{
		$this->db->insert('law_notation', $data); 
		$autoid = $this->db->insert_id();
		
		$this->db->where('id', $autoid);
		$nid = 'NT'.$autoid;
		$hashnid = md5($nid.time());
		$this->db->set('NOTATIONID', $nid);
		$this->db->set('HASHNOTATIONID', $hashnid);
		
		$this->db->set('CREATED_BY', $this->session->userdata('userid'));
		$this->db->set('CREATED_ON', time());

		if($this->session->userdata('role') == 'Admin')
			$this->db->set('TYPE', 'dbversion');

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

		if (strpos($listcitation, ',') !== false) {
			$citation_arr = explode(",",$listcitation);
			foreach($citation_arr as $lcitation)
			{
				$itemlist = array();
				$itemlist['CITATION'] = $lcitation;
				$itemlist['NOTATIONID'] = $nid;
				$this->db->insert('law_citation', $itemlist);
				//print_r($itemlist); 
			}
		}
		else
		{
			$itemlist = array();
			$itemlist['CITATION'] = $this->input->post('citation');
			$itemlist['NOTATIONID'] = $nid;
			$this->db->insert('law_citation', $itemlist); 
			//print_r($itemlist);
		}

		$listofjudge = $this->input->post('judge_name');
		if (strpos($listofjudge, ',') !== false) {
			$judge_arr = explode(",",$listofjudge);
			foreach($judge_arr as $ljudge)
			{
				$itemlist = array();
				$itemlist['JUDGE_NAME'] = $ljudge;
				$itemlist['NOTATIONID'] = $nid;
				$this->db->insert('law_judgename', $itemlist);
				//print_r($itemlist); 
			}
		}
		else
		{
			$itemlist = array();
			$itemlist['JUDGE_NAME'] = $this->input->post('judge_name');
			$itemlist['NOTATIONID'] = $nid;
			$this->db->insert('law_judgename', $itemlist); 
			//print_r($itemlist);
		}		
		return true;
	}

	function autoSaveNotation($notationData, $notationid)
	{
		$userid = $this->session->userdata('userid');
		$role = $this->session->userdata('role');

		if(strlen($notationid)>0 && $notationid != '')
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

			if (strpos($listcitation, ',') !== false) {
				$citation_arr = explode(",",$listcitation);
				foreach($citation_arr as $lcitation)
				{
					$itemlist = array();
					$itemlist['CITATION'] = $lcitation;
					$itemlist['NOTATIONID'] = $notationid;
					$this->db->insert('law_citation', $itemlist);
					//print_r($itemlist); 
				}
			}
			else
			{
				$itemlist = array();
				$itemlist['CITATION'] = $this->input->post('citation');
				$itemlist['NOTATIONID'] = $notationid;
				$this->db->insert('law_citation', $itemlist); 
				//print_r($itemlist);
			}

			$listofjudge = $this->input->post('judge_name');
			if (strpos($listofjudge, ',') !== false) {
				$judge_arr = explode(",",$listofjudge);
				foreach($judge_arr as $ljudge)
				{
					if($this->fnJudgeAvailable($ljudge) > 0)
					{
						$itemlist = array();
						$itemlist['JUDGE_NAME'] = $ljudge;
						$itemlist['NOTATIONID'] = $notationid;
						$this->db->insert('law_judgename', $itemlist);	
					}
				}
			}
			else
			{
				$judgeName = $this->input->post('judge_name');
				if($this->fnJudgeAvailable($judgeName) > 0)
				{
					$itemlist = array();
					$itemlist['JUDGE_NAME'] = $judgeName;
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
		$nid = $this->input->post('ntype');
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
		if (strpos($listcitation, ',') !== false) {
			$citation_arr = explode(",",$listcitation);
			foreach($citation_arr as $lcitation)
			{
				$itemlist = array();
				$itemlist['CITATION'] = $lcitation;
				$itemlist['NOTATIONID'] = $nid;
				$this->db->insert('law_citation', $itemlist);
				print_r($itemlist); 
			}
		}
		else
		{
			$itemlist = array();
			$itemlist['CITATION'] = $this->input->post('citation');
			$itemlist['NOTATIONID'] = $nid;
			$this->db->insert('law_citation', $itemlist); 
			print_r($itemlist);
		}
		return true;
	}

	function updateNotation($data)
	{
		$nid = $this->input->post('ntype');

		$this->auditNotationStatuate($nid);
		$this->auditNotationCitation($nid);
		$this->auditNotation($nid);

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
		
		if (strpos($listcitation, ',') !== false) {
			$citation_arr = explode(",",$listcitation);
			foreach($citation_arr as $lcitation)
			{
				$itemlist = array();
				$itemlist['CITATION'] = $lcitation;
				$itemlist['NOTATIONID'] = $nid;
				$this->db->insert('law_citation', $itemlist);
				print_r($itemlist); 
			}
		}
		else
		{
			$itemlist = array();
			$itemlist['CITATION'] = $this->input->post('citation');
			$itemlist['NOTATIONID'] = $nid;
			$this->db->insert('law_citation', $itemlist); 
			print_r($itemlist);
		}


		$listofjudge = $this->input->post('judge_name');
		if (strpos($listofjudge, ',') !== false) {
			$judge_arr = explode(",",$listofjudge);
			foreach($judge_arr as $ljudge)
			{
				$itemlist = array();
				$itemlist['JUDGE_NAME'] = $ljudge;
				$itemlist['NOTATIONID'] = $nid;
				$this->db->insert('law_judgename', $itemlist);
				//print_r($itemlist); 
			}
		}
		else
		{
			$itemlist = array();
			$itemlist['JUDGE_NAME'] = $this->input->post('judge_name');
			$itemlist['NOTATIONID'] = $nid;
			$this->db->insert('law_judgename', $itemlist); 
			//print_r($itemlist);
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

		$str = "select * from law_notation where (type='public' or type='dbversion'  or type='private')";
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
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('type !=', 'draft');
		$this->db->where('created_by =', $userid);
		
		$itemdata = array();
		$itemquery = $this->db->get();
		if($itemquery->num_rows() > 0)
		{
			return $itemquery->result_array();
		}
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
			foreach($result as $row)
			{
				$notationid = $row['NOTATIONID'];
				$data['notationid'] = $row['NOTATIONID'];
				$data['hashnotationid'] = $row['HASHNOTATIONID'];
				$data['casename'] = $row['CASENAME'];
				$data['citation'] = $row['CITATION'];
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
						$i++;
					}
				}
				$data['citationdetails'] = $notationdata;
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
		$this->db->where('HASHNOTATIONID', $hashid);
		
		$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
		$this->db->set('UPDATED_ON', time());
		$this->db->set('TYPE', 'dbversion');

		$this->db->update('law_notation');

		return true;
	}
	
	public function changePublicVersion()
	{
		$hashid = $this->input->post('hashid');
		$this->db->where('HASHNOTATIONID', $hashid);
		
		$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
		$this->db->set('UPDATED_ON', time());
		$this->db->set('TYPE', 'public');

		$this->db->update('law_notation');

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
   		$string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.
  	 	return preg_replace('/[^A-Za-z0-9\s\(\)\-\,]/', '', $string); // Removes special chars.
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

		$this->db->update('law_notation');

	}

	public function searchStringCollection($searchString)
	{
		$listOfSearchStringArray = explode("--^--",$searchString);
		$allColumn = 'casename, citation, dup_citation, casenumber, judge_name, court_name, YEAR, bench, facts_of_case';
		$searchQuery = "SELECT * FROM law_notation WHERE ";
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

}
/* End of file Logindetailsmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */