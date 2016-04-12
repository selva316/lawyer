<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courttype extends CI_Controller {

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
		
		$this->load->view('admin/courttype',$data);
	}
	
	public function checkCourtNameAvailable()
	{
		$this->load->model('configurationmodel');
		$data =  $this->configurationmodel->courtNameAvailable($this->input->post('courtname'));
		echo json_encode($data);
	}

	public function checkCourtTypeShortNameAvailable()
	{
		$this->load->model('configurationmodel');
		$data =  $this->configurationmodel->courtShortNameAvailable($this->input->post('shortname'));
		echo json_encode($data);
	}
	
	public function insertCourtType()
	{
		$this->load->model('configurationmodel');
		$data =  $this->configurationmodel->insertCourtType($this->input->post('courtname'),$this->input->post('shortname'));
		echo json_encode($data);
	}

	public function updateCourtType()
	{
		$this->load->model('configurationmodel');
		$data =  $this->configurationmodel->updateCourtType($this->input->post('courtname'),$this->input->post('shortname'),$this->input->post('editCTID'));
		echo json_encode($data);
	}

	public function findCourtTypeDetails()
	{
		$this->load->model('configurationmodel');
		$data =  $this->configurationmodel->courtTypeDetails($this->input->post('courtId'));
		$collectionDetails= array('data'=>$data);
		echo json_encode($collectionDetails);
	}

	public function disableCourtType()
	{
		$this->load->model('configurationmodel');
		$data =  $this->configurationmodel->disableCourtType($this->input->post('courtId'));
		$disableDetails= array('data'=>$data);
		echo json_encode($disableDetails);
	}

	public function fetchCourtType()
	{
		$this->load->model('configurationmodel');
		$result =  $this->configurationmodel->fetchCourtType();
		$detailsList = array();
		foreach($result as $r)
		{
			if($r['DISABLE'] == 'N')
				$statusStr = '<button type="button" class="btn btn-small btn-success editCourtType" value="'.$r['CTID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-danger disableCourtType" value="'.$r['CTID'].'" >Disable</button>';
			else
				$statusStr = '<button type="button" class="btn btn-small btn-success editCourtType" value="'.$r['CTID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-warning disableCourtType" value="'.$r['CTID'].'" >Enable</button>';

			$details = array(
				'ctid'=>$r['CTID'],
				'name'=>$r['NAME'],
				'shortname'=>$r['SHORTNAME'],
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