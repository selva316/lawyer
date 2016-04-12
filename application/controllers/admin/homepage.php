<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends CI_Controller {

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
		//$data['main_content'] = 'login_form';
		//$this->load->view('includes/template',$data);
		$data = array();
		
		$this->load->view('admin/homepage',$data);
	}

	public function fetchDraftNotation()
	{
		$this->load->model('notationmodel');
		$result = $this->notationmodel->fetchStatusNotation('draft');
		
		if($result)
		{
			$detailsList = array();
			foreach($result as $r)
			{
				$details = array(
					//'notation'=>$r['NOTATIONID'],
					'notation'=>"<a  style='margin-left:10px;' target='_blank' href=".site_url('user/viewnotation')."?nid=".$r['HASHNOTATIONID'].">".$r['NOTATIONID']."</a>",
					'casename'=>$r['CASENAME'],
					'citation'=>$r['CITATION'],
					'court_name' => $r['COURT_NAME'],
					'type' => ucfirst($r['TYPE']),
					'action' => "<a href=".site_url('user/editnotation')."?nid=".$r['HASHNOTATIONID']."><span class='glyphicon glyphicon-pencil'></span></a>"."<a  style='margin-left:10px;' href=".site_url('user/viewnotation')."?nid=".$r['HASHNOTATIONID']."><span class='glyphicon glyphicon-eye-open'></span></a>"
					//'disable' => '<div id="infoView'.$r['CTID'].'"> <a class="btn btn-xs btn-success editCourtType" data-toggle="modal" href="javascript:editView(\''.$r['CTID'].'\')"> <span class="glyphicon glyphicon-eye-open"></span> </a> <a class="btn btn-xs btn-danger" href="javascript:infoView(\''.$r['CTID'].'\')"> <span class="glyphicon glyphicon-eye-open"></span> </a> </div>'
				);
				
				array_push($detailsList, $details);
			}
			
			$collectionDetails= array('data'=>$detailsList);
			echo json_encode($collectionDetails);
		}
		else
		{
			$detailsList = array();
			$collectionDetails= array('data'=>$detailsList);
			echo json_encode($collectionDetails);		
		}
		
	}
	
	public function fetchUserNotation()
	{
		$this->load->model('notationmodel');
		$this->load->model('configurationmodel');
		$result = $this->notationmodel->fetchNewUserNotation();
		
		if($result)
		{
			$detailsList = array();

			foreach($result as $r)
			{
				$actionStr = '';
				if($r['CREATED_BY'] == $this->session->userdata('userid'))
				{
					$actionStr .= "<a href=".site_url('user/editnotation')."?nid=".$r['HASHNOTATIONID']."><span class='glyphicon glyphicon-pencil'></span></a>"; 
				}
				$actionStr .= "<a  style='margin-left:10px;' href=".site_url('user/viewnotation')."?nid=".$r['HASHNOTATIONID']."><span class='glyphicon glyphicon-eye-open'></span></a>";

				$details = array(
					'notation'=>"<a  style='margin-left:10px;' target='_blank' href=".site_url('user/viewnotation')."?nid=".$r['HASHNOTATIONID'].">".$r['NOTATIONID']."</a>",
					'casename'=>$r['CASENAME'],
					'citation'=>$r['CITATION'],
					//'court_name' => $r['COURT_NAME'],
					'date_of_creation' => date('d-m-Y',$r['CREATED_ON']),
					'created_by' => $this->configurationmodel->fetchUserName($r['CREATED_BY']),
					'type' => ucfirst($r['TYPE']),
					'action' => $actionStr
				);
				
				array_push($detailsList, $details);
			}
			
			$collectionDetails= array('data'=>$detailsList);

			echo json_encode($collectionDetails);
	
		}
		else
		{
			$detailsList = array();
			$collectionDetails= array('data'=>$detailsList);
			echo json_encode($collectionDetails);		
		}
		
	}	
}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */