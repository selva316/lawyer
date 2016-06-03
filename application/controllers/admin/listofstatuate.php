<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ListOfStatuate extends CI_Controller {

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
		$data['result'] = $this->configurationmodel->fetchStatuate();
		
		$this->load->view('admin/listofstatuate',$data);
	}
	
	public function checkStatuateNameAvailable()
	{
		$this->load->model('listofstatuatemodel');
		$data =  $this->listofstatuatemodel->courtNameAvailable($this->input->post('statuatename'));
		echo json_encode($data);
	}

	public function checkCourtTypeShortNameAvailable()
	{
		$this->load->model('configurationmodel');
		$data =  $this->configurationmodel->courtShortNameAvailable($this->input->post('shortname'));
		echo json_encode($data);
	}
	
	public function insertStatuate()
	{
		$this->load->model('listofstatuatemodel');
		$data =  $this->listofstatuatemodel->insertStatuate($this->input->post('statuatename'),$this->input->post('description'));
		echo json_encode($data);
	}

	public function updateStatuate()
	{
		$this->load->model('listofstatuatemodel');
		$data =  $this->listofstatuatemodel->updateStatuate($this->input->post('editStatuatename'),$this->input->post('description'),$this->input->post('editSTID'));
		echo json_encode($data);
	}

	public function findStatuate()
	{
		$this->load->model('listofstatuatemodel');
		$data =  $this->listofstatuatemodel->statuateDetails($this->input->post('statuateid'));
		$collectionDetails= array('data'=>$data);
		echo json_encode($collectionDetails);
	}

	public function disableStatuate()
	{
		$this->load->model('listofstatuatemodel');
		$data =  $this->listofstatuatemodel->disableStatuate($this->input->post('statuateid'));
		$disableDetails= array('data'=>$data);
		echo json_encode($disableDetails);
	}

	public function fetchListOfStatuate()
	{
		$this->load->model('configurationmodel');
		$this->load->model('listofstatuatemodel');
		$result =  $this->listofstatuatemodel->fetchListOfStatuate();
		$detailsList = array();
		foreach($result as $r)
		{
			if($r['DISABLE'] == 'N')
				$statusStr = '<button type="button" class="btn btn-small btn-success editCourtType" value="'.$r['STID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-danger disableStatuate" value="'.$r['STID'].'" >Disable</button>';
			else
				$statusStr = '<button type="button" class="btn btn-small btn-success editCourtType" value="'.$r['STID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-warning disableStatuate" value="'.$r['STID'].'" >Enable</button>';

			$details = array(
				'stid'=>$r['STID'],
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