<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliententity extends CI_Controller {

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
		
		$this->load->view('admin/cliententity',$data);
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
	
	public function insertClient()
	{
		$this->load->model('cliententitymodel');
		$data =  $this->cliententitymodel->insertClient($this->input->post('clientname'),$this->input->post('email'),$this->input->post('supernote'));
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

	public function fetchClientDetails()
	{
		$this->load->model('configurationmodel');
		$this->load->model('cliententitymodel');
		$result =  $this->cliententitymodel->fetchListOfClient();
		$detailsList = array();
		foreach($result as $r)
		{
			$statusStr = '<button type="button" class="btn btn-small btn-success viewClientEntityTopic" value="'.$r['CLIENTID'].'"  >View Tag Notation</button>';
			/*
			if($r['DISABLE'] == 'N')
				$statusStr = '<button type="button" class="btn btn-small btn-success editClientEntity" value="'.$r['CLIENTID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-danger disableClientEntity" value="'.$r['CLIENTID'].'" >Disable</button>';
			else
				$statusStr = '<button type="button" class="btn btn-small btn-success editClientEntity" value="'.$r['CLIENTID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-warning disableClientEntity" value="'.$r['CLIENTID'].'" >Enable</button>';
			*/
			$details = array(
				//'clientid'=>$r['CLIENTID'],
				'clientid'=>"<a  style='margin-left:10px;' href=".site_url('admin/editcliententity')."?hashcid=".$r['HASHCLIENTID'].">".$r['CLIENTID']."</a>",
				'name'=>$r['CLIENT_NAME'],
				//'description'=>$r['CLIENT_EMAIL'],
				'createdby'=>$this->configurationmodel->fetchUserName($r['BELONGS_TO']),
				'createdon'=>date('d-m-Y',$r['TIMESTAMP']),
				'action' => $statusStr
				
				//date('d-m-Y',$r['CREATED_ON']),
				//'disable' => $statusStr
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