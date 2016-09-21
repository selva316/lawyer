<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editcliententity extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		
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
		$data = array();
		$this->load->model('cliententitymodel');
		$data = $this->cliententitymodel->fetchClientEntity();
		
		$this->load->view('admin/editcliententity',$data);
	}
	
	public function fetchCaseNumber()
	{
		$this->load->model('configurationmodel');
		$result =  $this->configurationmodel->fetchCaseNumber();
		//echo json_encode($data);
		$detailsList = array();	
		foreach($result as $r)
		{
			$details = array(
					'userid'=>$this->session->userdata('userid'),
					'casenumber'=>$r['CASENUMBER']
				);
			array_push($detailsList, $details);
		}

		$collectionDetails= array('data'=>$detailsList);

		echo json_encode($detailsList);
	}

	public function checkClientNameAvailable()
	{
		$this->load->model('cliententitymodel');
		$data =  $this->cliententitymodel->clientNameAvailable($this->input->post('clientname'));
		echo json_encode($data);
	}

	public function checkCourtTypeShortNameAvailable()
	{
		$this->load->model('configurationmodel');
		$data =  $this->configurationmodel->courtShortNameAvailable($this->input->post('shortname'));
		echo json_encode($data);
	}
	
	public function editClientEntities()
	{
		$this->load->model('cliententitymodel');
		if(isset($_POST))
		{
			$data = array();
			$data['CLIENT_NAME'] = $this->input->post('clientname');
			$data['SUPERNOTE'] = $this->input->post('supernote');
			$data['TIMESTAMP'] = time();
			$this->cliententitymodel->editClientEntities($data);

		}
	}



}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */