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
		
		$this->load->view('user/homepage',$data);
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
				$actionStr = '';
				$actionStr .= "<button style='margin-left:10px;' type='button' class='btn btn-info btnDraft' value=".$r['HASHNOTATIONID']."> Accept Draft</button>";
				$actionStr .= "<button style='margin-left:10px;' type='button' class='btn btn-warning btnDelete' value=".$r['HASHNOTATIONID']."> Delete</button>";
				
				$details = array(
					'notation'=>'<div style="display:inline"><div class="checkbox" ><label><input class="chkbox" type="checkbox" name="selectchk[]" value="'.$r['HASHNOTATIONID'].'"/></label></div> </div>',

					'casename'=>"<a  style='margin-left:10px;' href=".site_url('user/editnotation')."?nid=".$r['HASHNOTATIONID'].">".$r['CASENAME']."</a>",
					'citation'=>"<a  style='margin-left:10px;' href=".site_url('user/editnotation')."?nid=".$r['HASHNOTATIONID'].">".$r['CITATION']."</a>",
					//'citation'=>$r['CITATION'],
					'case_number' => $r['CASENUMBER'],
					'type' => ucfirst($r['TYPE'])
					//'action' => $actionStr

					//'action' => "<a href=".site_url('user/editnotation')."?nid=".$r['HASHNOTATIONID']."><span class='glyphicon glyphicon-pencil'></span></a>"."<a  style='margin-left:10px;' href=".site_url('user/viewnotation')."?nid=".$r['HASHNOTATIONID']."><span class='glyphicon glyphicon-eye-open'></span></a>"
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
	
	public function fetchNotation()
	{
		$this->load->model('notationmodel');
		$this->load->model('userdetailsmodel');

		$result = $this->notationmodel->fetchUserNotation();
		
		if($result)
		{
			$detailsList = array();
			foreach($result as $r)
			{
				$actionStr = '';
				if(($r['CREATED_BY'] == $this->session->userdata('userid') || $r['UPDATED_BY'] ==$this->session->userdata('userid')) && $r['TYPE'] != 'dbversion')
				{

					//$actionStr .= "<a href=".site_url('user/editnotation')."?nid=".$r['HASHNOTATIONID']."><span class='glyphicon glyphicon-pencil' rel='tooltip' title='Edit'></span></a>"; 
				}
				
				if($r['TYPE'] == 'dbversion')
				{
					//$actionStr .= "<a style='margin-left:10px;' href=".site_url('user/viewnotation')."?nid=".$r['HASHNOTATIONID']."><span rel='tooltip' title='Mark it as Draft' > Make Draft</span></a>";	
					//$actionStr .= "<button style='margin-left:10px;' type='button' class='btn btn-warning btnSaveAsDraft' value=".$r['HASHNOTATIONID']."> Mark Edit Copy</button>";
				}


				if($r['TYPE'] == 'private')
				{
					//$actionStr .= "<button style='margin-left:10px;' type='button' class='btn btn-danger btnPublic' value=".$r['HASHNOTATIONID']."> Make Public</button>";
					//$actionStr .= "<button style='margin-left:10px;' type='button' class='btn btn-warning btnDelete' value=".$r['HASHNOTATIONID']."> Delete</button>";
					//$actionStr .= "<button style='margin-left:10px;' type='button' class='btn btn-success btnDbVersion' value=".$r['HASHNOTATIONID']."> Make DB Version</button>";
				}

				if($r['TYPE'] == 'public')
				{
					//$actionStr .= "<button style='margin-left:10px;' type='button' class='btn btn-success btnPrivate' value=".$r['HASHNOTATIONID']."> Make Private</button>";
				}

				

				$details = array(
					'notation'=>'<div style="display:inline"><div class="checkbox" ><label><input class="chkNotationbox" type="checkbox" name="selectchk[]" value="'.$r['HASHNOTATIONID'].'"/></label></div> </div>',
					'casename'=>"<a  style='margin-left:10px;' href=".site_url('user/editnotation')."?nid=".$r['HASHNOTATIONID'].">".$r['CASENAME']."</a>",
					'citation'=>"<a  style='margin-left:10px;' href=".site_url('user/editnotation')."?nid=".$r['HASHNOTATIONID'].">".$r['CITATION']."</a>",
					//'citation'=>$r['CITATION'],
					'case_number' => $r['CASENUMBER'],
					'type' => ucfirst($r['TYPE']),
					'owner' => ucfirst($this->userdetailsmodel->findUsername($r['CREATED_BY']))
					//'action' => $actionStr
					//'action' => "<a href=".site_url('user/editnotation')."?nid=".$r['HASHNOTATIONID']."><span class='glyphicon glyphicon-pencil'></span></a>"."<a  style='margin-left:10px;' href=".site_url('user/viewnotation')."?nid=".$r['HASHNOTATIONID']."><span class='glyphicon glyphicon-eye-open'></span></a>"
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
}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */