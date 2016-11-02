<?php 
class Researchmodel extends CI_Model {

	public function fetchResearchTopic()
	{
		$userid = $this->session->userdata('userid');

		$str = "select * from law_research_group where disable='N' and BELONGS_TO='".$userid."'";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function checkTopicAvailable($topic){
				
		$query = $this->db->query("select count(topic) as cntname from law_research_group  where (UPPER(TOPIC) = '".strtoupper($topic)."')");
		
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

	public function fetchUsers(){
		$str = "select * from law_login where role='2'";
		$query = $this->db->query($str);
		return $query->result_array();	
	}

	function createResearchGroup($data)
	{
		$this->db->insert('law_research_group', $data); 
		$autoid = $this->db->insert_id();
		
		$this->db->where('id', $autoid);
		$rid = 'RID'.$autoid;

		$this->db->set('RID', $rid);
		$this->db->update('law_research_group');
	}

	public function updateResearchGroup()
	{
		$assignTo = $this->input->post('assignTo');
		$topicname = $this->input->post('topicname');
		$rid = $this->input->post('rid');
		$userid = $this->session->userdata('userid');

		if($assignTo != "" && $assignTo != "null")
		{
			$source_array = explode('!', $assignTo);
			$userList = array_map('trim', $source_array);
			//$this->researchmodel->deleteResearchGroupUser($userid);

			$assign_userid = '';
			foreach ($userList as $username) {
				
				$assign_userid .= $this->researchmodel->fetchUserID($username);
				$assign_userid .=',';
			}
			$this->db->set('TOPIC', $topicname);
			$this->db->set('BELONGS_TO', $userid);
			$this->db->set('TIMESTAMP', time());
			$this->db->set('ASSIGN_TO', $assign_userid);

			$this->db->where('RID', $rid);
			$this->db->update('law_research_group');
		}
		else
		{
			$this->db->set('TOPIC', $topicname);
			$this->db->set('BELONGS_TO', $userid);
			$this->db->set('TIMESTAMP', time());
			$this->db->set('ASSIGN_TO', $userid.',');			

			$this->db->where('RID', $rid);
			$this->db->update('law_research_group');
		}

	}

	public function deleteResearchGroupUser($userID)
	{
		$this->db->where('BELONGS_TO', $userID);
		$this->db->delete('law_research_group'); 		
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

	public function fetchResearchUsers($rid)
	{
		$query = $this->db->query("select * from law_research_group where RID  = '".$rid."'");
		$result = $query->result_array();
		$username = '';
		foreach($result as $r)
		{
			$username = $r['ASSIGN_TO'];
			//$research_name = $r['TOPIC'];
		}

		return $username;
	}

	public function fetchResearchTopicName($rid)
	{
		$query = $this->db->query("select * from law_research_group where RID  = '".$rid."'");
		$result = $query->result_array();
		$research_name = '';
		foreach($result as $r)
		{
			$research_name = $r['TOPIC'];
		}

		return $research_name;
	}

	public function fetchClientTopicName($rid)
	{
		$query = $this->db->query("select * from law_client_master where clientid  = '".$rid."'");
		$result = $query->result_array();
		$research_name = '';
		foreach($result as $r)
		{
			$research_name = $r['CLIENT_NAME'];
		}

		return $research_name;	
	}

	public function accessResearchName($topicname)
	{
		$topicname = "%".$topicname."%";

		$query = $this->db->query("select topic, rid from law_research_group where topic like '".$topicname."'");
		$data = array();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$name = $row['topic']."|".$row['rid'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
			}
		}

		$clientquery = $this->db->query("select clientid, client_name from law_client_master where client_name like '".$topicname."'");
		

		$clientid = '';
		$client_name = '';
		if ($clientquery->num_rows() > 0)
		{
			$result = $clientquery->result_array();
			foreach($result as $row)
			{
				$clientid = $row['clientid'];
				$client_name = $row['client_name'];
				$entityid = '';

				$name = $row['client_name']."|".$row['clientid'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
				
				$entityquery = $this->db->query("select entityid, entity_name from law_client_entity where clientid = '".$clientid."'");
				if ($entityquery->num_rows() > 0)
				{
					$result = $entityquery->result_array();
					foreach($result as $erow)
					{
						$entityid = $erow['entity_name'];
						$name = $client_name." - ".$erow['entity_name']."|".$erow['entityid'];
						array_push($data, $name);

						if($entityid != '')
						{
							//echo "select entityid, casenumber from law_client_entity_case where clientid = '".$clientid."' and entityid='".$entityid."'";

							$casequery = $this->db->query("select entityid, casenumber from law_client_entity_case where clientid = '".$clientid."' and entityid='".$entityid."'");
							if ($casequery->num_rows() > 0)
							{
								$caseresult = $casequery->result_array();
								foreach($caseresult as $caserow)
								{
									$name = $client_name." - ".$erow['entity_name']." - ".$caserow['casenumber']."|".$row['clientid'];
									array_push($data, $name);
								}
							}
						}
					}

				}
				
				if($entityid != '')
				{
					//echo "select entityid, casenumber from law_client_entity_case where clientid = '".$clientid."'";

					$casequery = $this->db->query("select entityid, casenumber from law_client_entity_case where clientid = '".$clientid."' and entityid='".$clientid."'");
					if ($casequery->num_rows() > 0)
					{
						$caseresult = $casequery->result_array();
						foreach($caseresult as $caserow)
						{
							$name = $client_name." - ".$caserow['casenumber']."|".$row['clientid'];
							array_push($data, $name);
						}
					}
				}
			}
		}
		
		return $data;
	}

	public function saveResearchName()
	{
		//$topicname = $this->input->post('rid');
		$topicname = $this->input->post('topicname');
		$tagNote  = $this->input->post('notes');
		$notationid = $this->input->post('notationid');
		$userid = $this->session->userdata('userid');

		$this->db->where('NOTATIONID', $notationid);
		$this->db->delete('law_research_notation_link');

		if (strpos($topicname, ';') !== false) {
			$rid_arr = explode(";",$topicname);
			foreach($rid_arr as $lrid)
			{
				if($lrid != '' && $lrid != null && strlen($lrid) > 1)
				{
					$topicid = $this->findResearchId($lrid);
					
					$itemlist = array();
					//$itemlist['RID'] = trim($lrid);
					$itemlist['RID'] = trim($topicid);
					$itemlist['NOTATIONID'] = $notationid;
					$itemlist['NOTES'] = $tagNote;
					$itemlist['USERID'] = $userid;
					$this->db->insert('law_research_notation_link', $itemlist);	
				}
			}
		}
		else
		{
			//$topicname = $this->input->post('rid');
			$topicname = $this->input->post('topicname');
			if($topicname)
			{
				$topicid = $this->findResearchId($topicname);
				$itemlist = array();
				//$itemlist['RID'] = trim($topicname);
				$itemlist['RID'] = trim($topicid);
				$itemlist['NOTATIONID'] = $notationid;
				$itemlist['NOTES'] = $tagNote;
				$itemlist['USERID'] = $userid;
				$this->db->insert('law_research_notation_link', $itemlist);
			}
		}
	}

	public function fetchResearchName()
	{
		$notationid = $this->input->post('notationid');

		$query = $this->db->query("select * from law_research_notation_link where notationid='".$notationid."'");
		$data = array();
		$topicname = '';
		$ridvalue = '';
		$tagNotes = '';

		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $row)
			{
				$rid = $row['RID'];
				$chkval = substr($rid, 0, 3);

				if($chkval == 'RID')
				{
					$topicname .= $this->fetchResearchTopicName($rid).'; ';
					$ridvalue .= $rid.'; ';
				}
				else
				{
					$topicname .= $this->fetchClientTopicName($rid).'; ';
					$ridvalue .= $rid.'; ';	
				}
				$tagNotes = $row['NOTES'];
			}
		}
		if($ridvalue != '')
			$ridvalue = $topicname.'|'.$ridvalue.'|'.$tagNotes;

		return $ridvalue;
	}

	public function disableResearch()
	{
		$ridList = $this->input->post('rid');
		$hashidArr = explode(',', $ridList);
		foreach ($hashidArr as $rid) 
		{

			$query = $this->db->query("select disable from law_research_group where (UPPER(RID) = '".strtoupper($rid)."')");
			
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

			$this->db->where('RID', $rid);
			$this->db->set('DISABLE', $disable);
			$this->db->update('law_research_group');
		
		}
		$dArray = array();
		array_push($dArray, true);
		return $dArray;
	}

	public function notesSave($data)
	{
		$this->db->insert('law_research_notation_link', $data);
		return true;
	}

	public function fetchResearchNotation($researchid)
	{
		$str = "select * from law_research_notation_link where disable='N' and rid='".$researchid."'";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchClientName($topicname)
	{
		$query = $this->db->query("select * from law_client_master where client_name  = '".trim($topicname)."'");
		$result = $query->result_array();
		foreach($result as $r)
		{
			$research_name = $r['CLIENTID'];
		}
		return $research_name;
	}

	public function fetchEntityName($clientid, $topicname)
	{
		echo "select * from law_client_entity where clientid='".$clientid."' and entity_name  = '".trim($topicname)."'";
		echo "<BR/>";

		$query = $this->db->query("select * from law_client_entity where clientid='".$clientid."' and entity_name  = '".trim($topicname)."'");
		$result = $query->result_array();
		foreach($result as $r)
		{
			$research_name = $r['ENTITYID'];
		}
		return $research_name;
	}

	public function findResearchId($topicname)
	{
		$research_name = '';
		
		$query = $this->db->query("select * from law_research_group where topic  = '".trim($topicname)."'");
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach($result as $r)
			{
				$research_name = $r['RID'];
			}	
		}
		else
		{
			if (strpos($topicname, ' - ') !== false) 
			{
				if (strpos($topicname, ';') !== false) 
					$topicname = substr($topicname, 0, -1);
				
				$rid_arr = explode("-",$topicname);
				
				$rid_arr[0] = $this->fetchClientName($rid_arr[0]);

				if(count($rid_arr) == 2)
				{
					$rid_arr[1] = $this->fetchEntityName($rid_arr[0], $rid_arr[1]);

					$query = $this->db->query("select * from law_client_entity where clientid='".$rid_arr[0]."' and entity_name  = '".trim($rid_arr[1])."'");
					if ($query->num_rows() > 0)
					{
						$result = $query->result_array();
						foreach($result as $r)
						{
							$research_name = $r['CLIENTID'];
						}	
					}
					else
					{
						$query = $this->db->query("select * from law_client_entity_case where clientid='".$rid_arr[0]."' and casenumber  = '".trim($rid_arr[1])."'");
						$result = $query->result_array();
						foreach($result as $r)
						{
							$research_name = $r['CLIENTID'];
						}	
					}
				}
				
				if(count($rid_arr) == 3)
				{
					//$rid_arr[1] = $this->fetchEntityName($rid_arr[0], $rid_arr[1]);

					echo "select * from law_client_entity_case where clientid='".$rid_arr[0]."' and casenumber  = '".trim($rid_arr[2])."'  and entityid  = '".trim($rid_arr[1])."'";

					$query = $this->db->query("select * from law_client_entity_case where clientid='".$rid_arr[0]."' and casenumber  = '".trim($rid_arr[2])."'  and entityid  = '".trim($rid_arr[1])."'");
					$result = $query->result_array();
					foreach($result as $r)
					{
						$research_name = $r['CLIENTID'];
					}
				}
				
			}
			else
			{
				$query = $this->db->query("select * from law_client_master where client_name  = '".trim($topicname)."'");
				$result = $query->result_array();
				foreach($result as $r)
				{
					$research_name = $r['CLIENTID'];
				}	
			}
			
		}
		
		return $research_name;
	}

}
/* End of file Logindetailsmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */