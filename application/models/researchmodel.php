<?php 
class Researchmodel extends CI_Model {

	public function fetchResearchTopic()
	{
		$str = "select * from law_research_group";
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
			$this->db->set('ASSIGN_TO', $userid);			

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
				$name = $row['topic'].'|'.$row['rid'];//i am not want item code i,eeeeeeeeeeee
				array_push($data, $name);
			}
		}
		return $data;
	}

	public function notesSave($data)
	{
		$this->db->insert('law_research_notation_link', $data);
		return true;
	}
}
/* End of file Logindetailsmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */