<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notation extends CI_Controller {

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
	
	public function _clean($string) {
   		//$string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.
  	 	return preg_replace('/[^a-zA-Z0-9]/', '', $string); // Removes special chars.
	}

	public function index()
	{
		$this->load->model('configurationmodel');
		$this->load->model('notationmodel');
		$this->load->model('listofstatuatesubsectionmodel');
		$data = array();
		
		$data['courtDetails'] = $this->configurationmodel->fetchCourtType();
		$data['typeOfCitation'] = $this->configurationmodel->fetchTypeOfCitation();
		$data['status'] = $this->notationmodel->fetchStatus();
		$data['StatuateSubsection'] = $this->listofstatuatesubsectionmodel->fetchUserListOfStatuateSubSection();

		$this->load->view('user/notation',$data);
	}

	public function fetchYear()
	{
		$year = $this->input->post('year');
	
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->fetchYear($year);
		echo json_encode($data);
		
	}

	public function fetchCasename()
	{
		$casename = $this->input->post('casename');
	
		$this->load->model('notationmodel');
		$data = $this->notationmodel->fetchCasename($casename);
		echo json_encode($data);
		
	}

	public function ajax()
	{
		$type = $this->input->post('type');
	
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->ajaxcall();
		echo json_encode($data);
		
	}

	public function fetchAllJudges()
	{
		$type = $this->input->post('type');
	
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->fetchAllJudges();
		echo json_encode($data);
	}
	
	public function fetchUserStatuate()
	{
		$type = $this->input->post('type');
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->fetchUserStatuate();
		echo json_encode($data);
	}

	public function fetchUserSubSection()
	{
		$type = $this->input->post('type');
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->fetchUserSubSection();
		echo json_encode($data);
	}

	public function statuateAjax()
	{
		$type = $this->input->post('type');
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->ajaxStatuate();
		echo json_encode($data);
	}

	public function conceptAjax()
	{
		$type = $this->input->post('type');
	
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->ajaxConcept();
		echo json_encode($data);
	
	}

	public function citationTypeAjax()
	{
		$type = $this->input->post('type');
	
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->citationTypeAjax();
		echo json_encode($data);
	
	}

	public function caseNameAvailable()
	{
		$casename = $this->input->post('casename');
	
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->ajaxCaseName();
		echo json_encode($data);
	}
	
	public function citationAvailable()
	{
		$citation = $this->input->post('citation');
	
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->ajaxCitation();
		echo json_encode($data);
	}

	public function insertStatuate()
	{

	}

	public function changeDbVersion()
	{
		$this->load->model('notationmodel');
		$data = $this->notationmodel->changeDbVersion();
		return $this->session->userdata('role');
	}

	public function changePublicVersion()
	{
		$this->load->model('notationmodel');
		$data = $this->notationmodel->changePublicVersion();
		return $this->session->userdata('role');
	}
	
	public function changePrivateVersion()
	{
		$this->load->model('notationmodel');
		$data = $this->notationmodel->changePrivateVersion();
		return $this->session->userdata('role');
	}

	public function changeDraftVersion()
	{
		$this->load->model('notationmodel');
		$data = $this->notationmodel->changeDraftVersion();
		return $this->session->userdata('role');
	}
	
	public function changeEditCopyVersion()
	{
		$this->load->model('notationmodel');
		$data = $this->notationmodel->changeEditCopyVersion();
		return $this->session->userdata('role');
	}
	
	public function deleteNotation()
	{
		$this->load->model('notationmodel');
		$data = $this->notationmodel->deleteNotation();
		return $this->session->userdata('role');
	}

	public function save(){
		
		if(isset($_POST))
		{
			$data = array();
			if($this->input->post('ntype') == '')
			{
				echo "if";	
				$data['casename'] = $this->input->post('casename');
				$data['citation'] = $this->input->post('citation');
				$data['dup_citation'] = $this->input->post('dubcitation');

				$data['judge_name'] = $this->input->post('judge_name');
				$data['court_name'] = $this->input->post('court_name');
				$data['casenumber'] = $this->input->post('casenumber');

				$data['year'] = $this->input->post('year');
				$data['bench'] = $this->input->post('bench');

				$data['facts_of_case'] = $this->input->post('facts_of_case');

				if($this->input->post('case_note') != '')
				{
					$data['case_note'] = $this->input->post('case_note');	
				}

				if($this->session->userdata('role') == 'Admin')
					$data['type'] = 'dbversion';
				else	
					$data['type'] = $this->input->post('status');

				$this->load->model('notationmodel');
				$data = $this->notationmodel->createNotation($data);
					
			}
			else
			{
				echo "else";
				$data['ntype'] = $this->input->post('ntype');
				$data['casename'] = $this->input->post('casename');
				$data['citation'] = $this->input->post('citation');
				$data['dup_citation'] = $this->input->post('dubcitation');

				$data['judge_name'] = $this->input->post('judge_name');
				$data['court_name'] = $this->input->post('court_name');
				$data['casenumber'] = $this->input->post('casenumber');

				$data['year'] = $this->input->post('year');
				$data['bench'] = $this->input->post('bench');

				$data['facts_of_case'] = $this->input->post('facts_of_case');
				
				if($this->input->post('case_note') != '')
				{
					$data['case_note'] = $this->input->post('case_note');	
				}

				if($this->session->userdata('role') == 'Admin')
					$data['type'] = 'dbversion';
				else	
					$data['type'] = $this->input->post('status');

				$this->load->model('notationmodel');
				$data = $this->notationmodel->updateNotation($data);
			}
			//$this->load->view('user/homepage');
			$this->session->set_userdata('pilltabsValue', 'userNotation');
			if($this->session->userdata('role') == 'Admin')
				redirect('admin/homepage');
			else
				redirect('user/homepage');
		}
	}

	public function autoSave()
	{
		$output_hashnid = '';
		if(isset($_POST))
		{
			$data = array();
			$casename = $this->input->post('casename');
			$citation = $this->input->post('citation');
			$casenumber = $this->input->post('casenumber');
			//if($this->input->post('casename') != '' && $this->input->post('citation') != ''){
			if(($casename != '') && ($citation != '' || $casenumber !=''))
			{
				$data['casename'] = $this->input->post('casename');
				$data['citation'] = $this->input->post('citation');
				$data['dup_citation'] = $this->input->post('dubcitation');

				if($this->input->post('judge_name') != ''){
					$data['judge_name'] = $this->input->post('judge_name');
				}

				if($this->input->post('court_name') != ''){
					$data['court_name'] = $this->input->post('court_name');
				}
				
				if($this->input->post('casenumber') != ''){
					$data['casenumber'] = $this->input->post('casenumber');	
				}
				
				if($this->input->post('year')){
					$data['year'] = $this->input->post('year');	
				}
				
				if($this->input->post('bench')){
					$data['bench'] = $this->input->post('bench');	
				}
				
				if($this->input->post('facts_of_case') != '')
				{
					$data['facts_of_case'] = $this->input->post('facts_of_case');	
				}
				
				if($this->input->post('case_note') != '')
				{
					$data['case_note'] = $this->input->post('case_note');	
				}
				
				if($this->input->post('status') != '' && $this->input->post('notationid') != '')
				{
					$data['type'] = $this->input->post('status');	
				}
				else
				{
					$data['type'] = 'draft';	
				}

				//$data['type'] = 'draft';	
				
				$notationid = '';
				if($this->input->post('notationid') != '' && strlen($this->input->post('notationid')) > 0)
				{
					$notationid = $this->input->post('notationid');
					//$notationid = $this->notationmodel->fetchNotationID($hashnotationid);
				}

				$this->load->model('notationmodel');
				$output_hashnid = $this->notationmodel->autoSaveNotation($data, $notationid);
			}
			echo $output_hashnid;
		}
	}

	public function autoSaveAsDraft()
	{

		$data['ntype'] = $this->input->post('ntype');
		$data['casename'] = $this->input->post('casename');
		$data['citation'] = $this->input->post('citation');
		$data['dup_citation'] = $this->input->post('dubcitation');

		$data['judge_name'] = $this->input->post('judge_name');
		$data['court_name'] = $this->input->post('court_name');
		$data['casenumber'] = $this->input->post('casenumber');

		$data['year'] = $this->input->post('year');
		$data['bench'] = $this->input->post('bench');

		$data['facts_of_case'] = $this->input->post('facts_of_case');
		
		if($this->input->post('case_note') != '')
		{
			$data['case_note'] = $this->input->post('case_note');	
		}
		
		$data['type'] = $this->input->post('status');

		$this->load->model('notationmodel');
		$data = $this->notationmodel->updateDraftNotation($data);
	}

	public function fetchResearchTopic()
	{
		$topicname = $this->input->post('topicname');
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->fetchResearchTopic();
		echo json_encode($data);
	}

	public function fetchAllCitation()
	{
		$topicname = $this->input->post('term');
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->fetchAllCitation($topicname);
		echo json_encode($data);
	}

	public function caseame_and_citation_avilabilty()
	{
		$this->load->model('notationmodel');
		$citation_arr = array();

		$casename = $this->input->post('casename');
		$citation = $this->input->post('citation');
		$ntype = $this->input->post('ntype');
		$chkAvailable = $this->notationmodel->chkCasenameAndCitation($casename, $citation, $ntype);

		echo $chkAvailable;
	}
}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */