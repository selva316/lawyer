<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ListOfStatuateSubsection extends CI_Controller {

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
		$this->load->model('listofstatuatesubsectionmodel');
		$data['result'] = $this->listofstatuatesubsectionmodel->fetchUserListOfStatuateSubSection();
	
		$this->load->view('admin/listofstatuatesubsection',$data);
	}
	
	public function fetchUserListOfStatuateSubSection()
	{
		$this->load->model('listofstatuatesubsectionmodel');
		$result = $this->listofstatuatesubsectionmodel->fetchUserListOfStatuateSubSection();
		$subarray = array();

		foreach ($result as $key => $value) {
			$arrayName = array( 
					'STID' => $key,
					'DESCRIPTION' => $value
				);
			array_push($subarray, $arrayName);
		}
		echo json_encode($subarray);
	}

	public function checkSubsectionStatuateNameAvailable()
	{
		$this->load->model('listofstatuatesubsectionmodel');
		$data =  $this->listofstatuatesubsectionmodel->subsectionNameAvailable($this->input->post('statuatename'), $this->input->post('subsectionname'));
		echo json_encode($data);
	}

	public function checkCourtTypeShortNameAvailable()
	{
		$this->load->model('configurationmodel');
		$data =  $this->configurationmodel->courtShortNameAvailable($this->input->post('shortname'));
		echo json_encode($data);
	}
	
	public function insertSubSection()
	{
		$this->load->model('listofstatuatesubsectionmodel');
		$data =  $this->listofstatuatesubsectionmodel->insertSubSection($this->input->post('statuatename'), $this->input->post('subsectionname'), $this->input->post('description'));
		echo json_encode($data);
	}

	public function updateSubsection()
	{
		$this->load->model('listofstatuatesubsectionmodel');
		$data =  $this->listofstatuatesubsectionmodel->updateSubsection($this->input->post('editStatuatename'),$this->input->post('editSubsectionname'),$this->input->post('description'), $this->input->post('editSSID'));
		echo json_encode($data);
	}

	public function findSubsection()
	{
		$this->load->model('listofstatuatesubsectionmodel');
		$data =  $this->listofstatuatesubsectionmodel->subsectionDetails($this->input->post('ssid'));
		$collectionDetails= array('data'=>$data);
		echo json_encode($collectionDetails);
	}

	public function disableSubSection()
	{
		$this->load->model('listofstatuatesubsectionmodel');
		$data =  $this->listofstatuatesubsectionmodel->disableSubSection();
		$disableDetails= array('data'=>$data);
		echo json_encode($disableDetails);
	}

	public function fetchListOfStatuateSubsection()
	{
		$this->load->model('configurationmodel');
		$this->load->model('listofstatuatesubsectionmodel');
		$result =  $this->listofstatuatesubsectionmodel->fetchListOfStatuateSubSection();
		$detailsList = array();
		foreach($result as $r)
		{
			if($r['DISABLE'] == 'N')
				$statusStr = '<button type="button" class="btn btn-small btn-success editCourtType" value="'.$r['SSID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-danger disableSubSection" value="'.$r['SSID'].'" >Disable</button>';
			else
				$statusStr = '<button type="button" class="btn btn-small btn-success editCourtType" value="'.$r['SSID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-warning disableSubSection" value="'.$r['SSID'].'" >Enable</button>';

			$details = array(
				//'stid'=> $this->listofstatuatesubsectionmodel->fetchStatuateName($r['STID']),
				'ssid'=>'<div style="display:inline"><div class="checkbox" ><label><input class="chkbox" type="checkbox" name="selectchk[]" value="'.$r['SSID'].'"/></label></div> </div>',
				'name'=>"<a  style='margin-left:10px;' class='editSubsection' href='#' data-type='".$r['SSID']."'>".$r['NAME']."</a>",
				//'name'=>$r['NAME'],
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

	public function fetchUserName($userid)
	{
		$this->load->model('configurationmodel');
		$result =  $this->configurationmodel->fetchUserName($userid);
	}


}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */