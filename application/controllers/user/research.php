<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Research extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		
		ob_start();
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', FALSE);
		header('Pragma: no-cache');
		ob_clean();
		//$this->output->nocache();
	}
	
	public function index()
	{
		$this->load->model('researchmodel');
		$data = array();
		
		$data['researchTopic'] = $this->researchmodel->fetchResearchTopic();
		
		$this->load->view('user/research',$data);
	}
	
	public function researchList()
	{
		$this->load->view('user/researchList');	
	}

	public function fetchResearchTopic()
	{
		$this->load->model('researchmodel');
		$result = $this->researchmodel->fetchResearchTopic();
		
		if($result)
		{
			$detailsList = array();
			foreach($result as $r)
			{	
				/*
				if($r['DISABLE'] == 'N')
					$statusStr = '<button type="button" class="btn btn-small btn-success editResearchGroup" value="'.$r['RID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-danger disableCourtType" value="'.$r['RID'].'" >Disable</button>';
				else
					$statusStr = '<button type="button" class="btn btn-small btn-success editResearchGroup" value="'.$r['RID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-warning disableCourtType" value="'.$r['RID'].'" >Enable</button>';
				*/

				$statusStr = '<button type="button" class="btn btn-small btn-success viewResearchTopic" value="'.$r['RID'].'"  >View Tag Notation</button>';

				$assign_userid = '';
				if($r['ASSIGN_TO'] != "" )
				{
					$assignTo = $r['ASSIGN_TO'];

					$source_array = explode(',', $assignTo);
					$userList = array_map('trim', $source_array);

					
					foreach ($userList as $username) {
						//echo $username."<BR/>";
						
						$assign_userid .= $this->researchmodel->fetchUserName($username);
						$assign_userid .=',';
					}
				}

				$details = array(
					'rid'=>'<div style="display:inline"><div class="checkbox" ><label><input class="chkbox" type="checkbox" name="selectchk[]" value="'.$r['RID'].'"/></label></div> </div>',
					'topic'=>"<a class='editResearchGroup' data-type='".$r['RID']."' style='margin-left:10px;' href='#'>".$r['TOPIC']."</a>",
					'belongs_to'=>$this->researchmodel->fetchUserName($r['BELONGS_TO']),
					'timestamp' => date("d-m-Y", $r['TIMESTAMP']),
					'assign' => $assign_userid,
					'action' => $statusStr
				);
				
				array_push($detailsList, $details);
			}
			
			$collectionDetails= array('data'=>$detailsList);

			echo json_encode($collectionDetails);
	
		}
		else
		{
			$detailsList = array();
			$collectionDetails= array('data'=>$detailsList);
			echo json_encode($collectionDetails);		
		}

	}

	public function disableResearch()
	{
		$this->load->model('researchmodel');
		$data =  $this->researchmodel->disableResearch();
		$disableDetails= array('data'=>$data);
		echo json_encode($disableDetails);
	}

	public function checkTopicAvailable()
	{
		$this->load->model('researchmodel');
		$data =  $this->researchmodel->checkTopicAvailable($this->input->post('topicname'));
		echo json_encode($data);
	}

	public function fetchUsers()
	{
		$this->load->model('researchmodel');
		$result =  $this->researchmodel->fetchUsers();
		//echo json_encode($data);
		$detailsList = array();	
		foreach($result as $r)
		{
			$details = array(
					'userid'=>$r['USERID'],
					'firstname'=>$r['FIRSTNAME'],
					'lastname'=>$r['LASTNAME'],
					'fullname'=>$r['NAME']
				);
			array_push($detailsList, $details);
		}

		$collectionDetails= array('data'=>$detailsList);

		echo json_encode($detailsList);
	}

	public function updateReseaarchTopic()
	{
		$topicname = $this->input->post('topicname');
		$assignTo = $this->input->post('assignTo');
		$rid = $this->input->post('rid');
		$userid = $this->session->userdata('userid');

		$this->load->model('researchmodel');
		$this->researchmodel->updateResearchGroup();
		
		$data = array();
		$data['BELONGS_TO'] = $this->session->userdata('userid');
		
		echo json_encode($data);
	}

	public function insertReseaarchTopic()
	{
		$topicname = $this->input->post('topicname');
		$assignTo = $this->input->post('assignTo');
		$userid = $this->session->userdata('userid');

		$this->load->model('researchmodel');

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

			$data = array();

			$data['TOPIC'] = $topicname;
			$data['BELONGS_TO'] = $userid;
			$data['TIMESTAMP'] = time();
			$data['ASSIGN_TO'] = $assign_userid;

			//$this->load->model('researchmodel');
			$result =  $this->researchmodel->createResearchGroup($data);
		}
		else
		{

			$data = array();

			$data['TOPIC'] = $topicname;
			$data['BELONGS_TO'] = $userid;
			$data['TIMESTAMP'] = time();
			$data['ASSIGN_TO'] = $userid.',';
			$result =  $this->researchmodel->createResearchGroup($data);
		}
		
		$data = array();
		$data['BELONGS_TO'] = $this->session->userdata('userid');
		
		echo json_encode($data);
	}

	public function fetchAssignUsers()
	{
		$rid = $this->input->post('rid');

		$this->load->model('researchmodel');
		$assignTo =  $this->researchmodel->fetchResearchUsers($rid);
		
		$assignTo = substr($assignTo, 0, -1);
		$source_array = explode(',', $assignTo);
		$userList = array_map('trim', $source_array);
		$details = array();
		
		foreach ($userList as $username) {

			array_push($details, $this->researchmodel->fetchUserName($username));
		}
		$detailsList = array('name'=>$details);
		$collectionDetails= array('data'=>$detailsList);
		//{"name":["Prabhu Ganapathilingam","Karthik Dhanabal"]}
		//[{"name":"Selva Lingam"}]
		echo json_encode($detailsList);	
	}

	public function researchTopic()
	{
		$rid = $this->input->post('rid');
		$this->load->model('researchmodel');
		$topic =  $this->researchmodel->fetchResearchTopicName($rid);
		$assignTo =  $this->researchmodel->fetchResearchUsers($rid);
		
		$assignTo = substr($assignTo, 0, -1);
		$source_array = explode(',', $assignTo);
		$userList = array_map('trim', $source_array);
		$details = array();
		
		foreach ($userList as $username) {

			array_push($details, $this->researchmodel->fetchUserName($username));
		}
		$detailsList = array('name'=>$details, 'topic'=>$topic);
		
		//{"name":["Prabhu Ganapathilingam","Karthik Dhanabal"]}
		//[{"name":"Selva Lingam"}]
		echo json_encode($detailsList);	
		/*
		$detailsList['topic'] = $topic;

		$collectionDetails= array('data'=>$detailsList);//, 'topic'=>$topic);

		echo json_encode($collectionDetails);*/
	}

	public function notesSave()
	{
		$data = array();
		$this->load->model('researchmodel');
		$data['RID'] = $this->input->post('rid');
		$data['NOTATIONID'] = $this->input->post('nid');
		$data['NOTES'] = $this->input->post('tagNote');
		$data['USERID'] = $this->session->userdata('userid');
		$data['DISABLE'] = 'N';
		$this->researchmodel->notesSave($data);
	}

	public function accessResearchName()
	{
		$topicname = $this->input->post('topicname');
		$this->load->model('researchmodel');
		$data =  $this->researchmodel->accessResearchName($topicname);
		echo json_encode($data);
	}

	public function saveResearchName()
	{
		$this->load->model('researchmodel');
		$data =  $this->researchmodel->saveResearchName();
		echo json_encode($data);	
	}

	public function fetchResearchName()
	{
		$this->load->model('researchmodel');
		$data =  $this->researchmodel->fetchResearchName();
		echo json_encode($data);	
	}
}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */