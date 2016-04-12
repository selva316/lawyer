<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ListOfCourt extends CI_Controller {

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
		$data['result'] = $this->configurationmodel->fetchCourtType();
		
		$this->load->view('admin/listofCourt',$data);
	}
	
	public function checkCourtNameAvailable()
	{
		$this->load->model('listofcourtmodel');
		$data =  $this->listofcourtmodel->courtNameAvailable($this->input->post('courtname'));
		echo json_encode($data);
	}

	public function checkCourtTypeShortNameAvailable()
	{
		$this->load->model('configurationmodel');
		$data =  $this->configurationmodel->courtShortNameAvailable($this->input->post('shortname'));
		echo json_encode($data);
	}
	
	public function insertCourtList()
	{
		$this->load->model('listofcourtmodel');
		$data =  $this->listofcourtmodel->insertCourtList($this->input->post('courtname'),$this->input->post('courtType'));
		echo json_encode($data);
	}

	public function updateCourtList()
	{
		$this->load->model('listofcourtmodel');
		$data =  $this->listofcourtmodel->updateCourtList($this->input->post('courtname'),$this->input->post('courtType'),$this->input->post('editCNID'));
		echo json_encode($data);
	}

	public function findCourtListDetails()
	{
		$this->load->model('listofcourtmodel');
		$data =  $this->listofcourtmodel->courtListDetails($this->input->post('courtId'));
		$collectionDetails= array('data'=>$data);
		echo json_encode($collectionDetails);
	}

	public function disableCourtList()
	{
		$this->load->model('listofcourtmodel');
		$data =  $this->listofcourtmodel->disableCourtList($this->input->post('courtId'));
		$disableDetails= array('data'=>$data);
		echo json_encode($disableDetails);
	}

	public function fetchListCourt()
	{
		$this->load->model('listofcourtmodel');
		$result =  $this->listofcourtmodel->fetchListOfCourt();
		$detailsList = array();
		foreach($result as $r)
		{
			if($r['DISABLE'] == 'N')
				$statusStr = '<button type="button" class="btn btn-small btn-success editCourtType" value="'.$r['CNID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-danger disableCourtType" value="'.$r['CNID'].'" >Disable</button>';
			else
				$statusStr = '<button type="button" class="btn btn-small btn-success editCourtType" value="'.$r['CNID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-warning disableCourtType" value="'.$r['CNID'].'" >Enable</button>';

			$details = array(
				'cnid'=>$r['CNID'],
				'name'=>$r['NAME'],
				'court_type'=>$r['COURT_TYPE'],
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