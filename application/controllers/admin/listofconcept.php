<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ListOfConcept extends CI_Controller {

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
		$data['result'] = $this->configurationmodel->fetchConcept();
		
		$this->load->view('admin/listofconcept',$data);
	}
	
	public function checkConceptNameAvailable()
	{
		$this->load->model('listofconceptmodel');
		$data =  $this->listofconceptmodel->conceptNameAvailable($this->input->post('conceptname'));
		echo json_encode($data);
	}

	public function checkCourtTypeShortNameAvailable()
	{
		$this->load->model('configurationmodel');
		$data =  $this->configurationmodel->courtShortNameAvailable($this->input->post('shortname'));
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

	public function fetchUserConcept()
	{
		$type = $this->input->post('type');
		$this->load->model('configurationmodel');
		$data = $this->configurationmodel->fetchUserConcept();
		echo json_encode($data);
	}

	/*
	public function insertConcept()
	{
		$this->load->model('listofconceptmodel');
		$data =  $this->listofconceptmodel->insertConcept($this->input->post('statuate'),$this->input->post('subsection'),$this->input->post('concept'));
		echo json_encode($data);
	}
	*/
	public function insertConcept()
	{
		$this->load->model('listofconceptmodel');
		$data =  $this->listofconceptmodel->insertConcept($this->input->post('statuate'),$this->input->post('subsection'),$this->input->post('concept'));
		echo json_encode($data);
	}

	public function newConcept()
	{
		$this->load->model('listofconceptmodel');
		$data =  $this->listofconceptmodel->newConcept($this->input->post('conceptname'),$this->input->post('description'));
		echo json_encode($data);	
	}

	public function updateConcept()
	{
		$this->load->model('listofconceptmodel');
		$data =  $this->listofconceptmodel->updateConcept($this->input->post('editConceptname'),$this->input->post('description'),$this->input->post('editCID'));
		echo json_encode($data);
	}

	public function findConcept()
	{
		$this->load->model('listofconceptmodel');
		$data =  $this->listofconceptmodel->conceptDetails($this->input->post('conceptid'));
		$collectionDetails= array('data'=>$data);
		echo json_encode($collectionDetails);
	}

	public function disableConcept()
	{
		$this->load->model('listofconceptmodel');
		$data =  $this->listofconceptmodel->disableConcept($this->input->post('cid'));
		$disableDetails= array('data'=>$data);
		echo json_encode($disableDetails);
	}

	public function fetchListOfConcept()
	{
		$this->load->model('configurationmodel');
		$this->load->model('listofconceptmodel');
		$result =  $this->listofconceptmodel->fetchListOfConcept();
		$detailsList = array();
		foreach($result as $r)
		{
			if($r['DISABLE'] == 'N')
				$statusStr = '<button type="button" class="btn btn-small btn-success editCourtType" value="'.$r['CID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-danger disableConcept" value="'.$r['CID'].'" >Disable</button>';
			else
				$statusStr = '<button type="button" class="btn btn-small btn-success editCourtType" value="'.$r['CID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-warning disableConcept" value="'.$r['CID'].'" >Enable</button>';

			$details = array(
				'cid'=>$r['CID'],
				'name'=>$r['NAME'],
				'description'=>$r['DESCRIPTION'],
				'createdby'=>$this->configurationmodel->fetchUserName($r['USERID']),
				'disable' => $statusStr
				//'disable' => '<div id="infoView'.$r['CTID'].'"> <a class="btn btn-xs btn-success editCourtType" data-toggle="modal" href="javascript:editView(\''.$r['CTID'].'\')"> <span class="glyphicon glyphicon-eye-open"></span> </a> <a class="btn btn-xs btn-danger" href="javascript:infoView(\''.$r['CTID'].'\')"> <span class="glyphicon glyphicon-eye-open"></span> </a> </div>'
			);
			
			array_push($detailsList, $details);
		}
		
		$collectionDetails= array('data'=>$detailsList);
		
		echo json_encode($collectionDetails);
	}


}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */