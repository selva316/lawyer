<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EditNotation extends CI_Controller {

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
		$this->load->model('notationmodel');
		$this->load->model('listofstatuatesubsectionmodel');
		$data = array();
		
		//echo  "Notation Id: ".$this->input->get('nid');
		$data = $this->notationmodel->fetchHashNotation();

		$data['courtDetails'] = $this->notationmodel->fetchCourtType();
		$data['typeOfCitation'] = $this->notationmodel->fetchTypeOfCitation();
		$data['status'] = $this->notationmodel->fetchStatus();
		$data['StatuateSubsection'] = $this->listofstatuatesubsectionmodel->fetchUserListOfStatuateSubSection();
		//print_r($data);
		$this->load->view('user/editNotation',$data);
	}
	
	public function ajax()
	{
		$type = $this->input->post('type');
	
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->ajaxcall();
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

	public function update(){
		
		if(isset($_POST))
		{
			$data = array();
			$data['ntype'] = $this->input->post('ntype');
			$data['casename'] = $this->input->post('casename');
			$data['citation'] = $this->input->post('citation');

			$data['judge_name'] = $this->input->post('judge_name');
			$data['court_name'] = $this->input->post('court_name');
			$data['casenumber'] = $this->input->post('casenumber');

			$data['year'] = $this->input->post('year');
			$data['bench'] = $this->input->post('bench');

			$data['facts_of_case'] = $this->input->post('facts_of_case');
			$data['type'] = $this->input->post('status');

			$this->load->model('notationmodel');
			$data = $this->notationmodel->updateNotation($data);
			//$this->load->view('user/homepage');
			$this->session->set_userdata('pilltabsValue', 'userNotation');
			if($this->session->userdata('role') == 'Admin')
				redirect('admin/homepage');
			else
				redirect('user/homepage');
		}
	}

	public function autoEditSave()
	{
		$output_hashnid = '';
		if(isset($_POST))
		{
			$data = array();
			if($this->input->post('casename') != '' && $this->input->post('citation') != ''){

				$data['casename'] = $this->input->post('casename');
				$data['citation'] = $this->input->post('citation');
				$data['dup_citation'] = $this->_clean($this->input->post('citation'));

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

	public function _clean($string) {
   		$string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.
  	 	return preg_replace('/[^A-Za-z0-9\s\(\)\-\,]/', '', $string); // Removes special chars.
	}
}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */