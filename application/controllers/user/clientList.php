<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class clientList extends CI_Controller {

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
		$this->load->model('cliententitymodel');
		$data = array();
		$data['clientid'] = $this->input->get('clientid');
		$this->load->view('user/clientList', $data);
	}
	
	public function fetchClientEntityNotation()
	{
		
		$this->load->model('cliententitymodel');
		$this->load->model('notationmodel');
		$this->load->model('userdetailsmodel');

		$clientid = $this->input->post('clientid');

		$result = $this->cliententitymodel->fetchClientEntityNotation($clientid);

		if($result)
		{
			$detailsList = array();
			foreach($result as $r)
			{	
				$res = $this->notationmodel->fetchNotationDetails($r['NOTATIONID']);
				
				$details = array(
					//'notation'=>'<div style="display:inline"><div class="checkbox" ><label><input class="chkNotationbox" type="checkbox" name="selectchk[]" value="'.$this->notationmodel->hashnotationid.'"/></label></div> </div>',
					'casename'=>"<a  style='margin-left:10px;' href=".site_url('user/editnotation')."?nid=".$this->notationmodel->hashnotationid.">".$this->notationmodel->casename."</a>",
					'citation'=>"<a  style='margin-left:10px;' href=".site_url('user/editnotation')."?nid=".$this->notationmodel->hashnotationid.">".$this->notationmodel->citation."</a>",
					//'citation'=>$r['CITATION'],
					'case_number' => $this->notationmodel->casenumber,
					'type' => ucfirst($this->notationmodel->type),
					'owner' => ucfirst($this->userdetailsmodel->findUsername($this->notationmodel->created_by))
				);
				
				array_push($detailsList, $details);
			}
			
			$notationDetails= array('data'=>$detailsList);

			echo json_encode($notationDetails);
	
		}
		
	}
}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */