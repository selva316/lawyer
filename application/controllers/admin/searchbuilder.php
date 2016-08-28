<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Searchbuilder extends CI_Controller {

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
		$data['roleresult'] = $this->configurationmodel->fetchListOfRole();
		
		$this->load->view('admin/searchbuilder',$data);
	}
	
	public function searchAjax()
	{
		$this->load->model('notationmodel');
		$searchString = $this->input->post('searchString');
		
		$result = $this->notationmodel->searchStringCollection($searchString);
		
		if($result)
		{
			$detailsList = array();
			foreach($result as $r)
			{
				$details = array(
					//'notation'=>$r['NOTATIONID'],
					//'notation'=>"<a  style='margin-left:10px;' target='_blank' href=".site_url('user/viewnotation')."?nid=".$r['HASHNOTATIONID'].">".$r['NOTATIONID']."</a>",
					'casename'=>"<a  style='margin-left:10px;' target='_blank' href=".site_url('user/viewnotation')."?nid=".$r['HASHNOTATIONID'].">".$r['CASENAME']."</a>",
					
					'citation'=>$r['CITATION'],
					'court_name' => $r['COURT_NAME'],
					'judge_name' => ucfirst($r['JUDGE_NAME'])
					//'action' => "<a href=".site_url('user/editnotation')."?nid=".$r['HASHNOTATIONID']."><span class='glyphicon glyphicon-pencil' rel='tooltip' title='Edit'></span></a>"."<a  style='margin-left:10px;' href=".site_url('user/viewnotation')."?nid=".$r['HASHNOTATIONID']."><span class='glyphicon glyphicon-eye-open' rel='tooltip' title='View'></span></a>"
					
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