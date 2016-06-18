<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addcliententity extends CI_Controller {

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
		$this->load->model('configurationmodel');
		$data['result'] = $this->configurationmodel->fetchClient();
		
		$this->load->view('admin/addcliententity',$data);
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
					'createdby'=>$r['CREATED_BY'],
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
	
	public function insertClientEntities()
	{
		$this->load->model('cliententitymodel');
		print_r($this->input->post());

		if(isset($_POST))
		{
			$data = array();
			$data['CLIENT_NAME'] = $this->input->post('clientname');
			$data['CLIENT_EMAIL'] = $this->input->post('email');
			$data['SUPERNOTE'] = $this->input->post('supernote');
			$data['TIMESTAMP'] = time();
			$this->cliententitymodel->insertClientEntities($data);

		}
	}



}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */