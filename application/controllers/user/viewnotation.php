<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ViewNotation extends CI_Controller {

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
		$data = array();
		
		//echo  "Notation Id: ".$this->input->get('nid');
		
		$data = $this->notationmodel->fetchHashNotation();
		$data['typeOfCitation'] = $this->notationmodel->fetchTypeOfCitation();
		//print_r($data);
		$this->load->view('user/viewNotation',$data);
	}

	public function saveAsDraft()
	{
		$this->load->model('notationmodel');
		$data = $this->notationmodel->saveAsDraft();
		return $this->session->userdata('role');
	}
	
	public function dbVersion()
	{
		$this->load->model('notationmodel');
		$data = $this->notationmodel->dbVersion();
		return $this->session->userdata('role');
	}
}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */