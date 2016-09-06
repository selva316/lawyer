<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$user = $this->session->userdata('username');
		
        if (isset($user) && strlen($user)>0)
        {
        	if($this->session->userdata('role') == 'Admin')
        		redirect('admin/homepage');
        	else
        		redirect('user/homepage');
            // User is logged in.  Do something.
        }

		$data['main_content'] = 'login_form';
		$this->load->view('includes/template',$data);
	}
	
	public function webservice_credentials()
	{
		$this->load->model('logindetailsmodel');
		$result = $this->logindetailsmodel->useravailable();
		$userid = '';
		if($result)
		{
			$userid = $this->logindetailsmodel->userid($this->input->post('j_username'));
			$jsonUserdetails = array(
				'userid'=>$userid,
				'status'=>'Success'
			);
			
		}
		else
		{
			$jsonUserdetails = array(
				'userid'=>$userid,
				'status'=>'Failure'
			);
		}
		echo json_encode($jsonUserdetails);
	}

	public function webserviceAddNotation()
	{
		
		$userid = $this->input->post('userid');
		if($userid != '')
		{
			$this->load->model('logindetailsmodel');
			$this->load->model('notationmodel');
			$role = $this->logindetailsmodel->userrole($userid);
			$this->session->set_userdata('userid',$userid);
			
			if($role == 1)
			{
				$role = 'Admin';
				$this->session->set_userdata('role','Admin');
			}
			else{
				$role = 'User';
				$this->session->set_userdata('role','User');
			}

			$citation = $this->input->post('citation');
			$casename = $this->input->post('casename');
			$casenumber = $this->input->post('casenumber');

			if($casename != '')
			{
				$vx  = 0;
				if($citation==''){
				
					if($casenumber != '')
					{
						
					}
					else
					{
						++$vx;
						$jsonUserdetails = array(
							'notationid'=>'Not available',
							'error_message'=>'Case Number is not available',
							'status'=>'Failure'
						);
		
					}
				}
				if($vx == 0){
					$notationid = $this->notationmodel->createWebNotation($casename, $citation, $casenumber, $userid, $role);
					$jsonUserdetails = array(
						'notationid'=>$notationid,
						'error_message'=>'Not available',
						'status'=>'Success'
					);	
				}
				
			}
			else
			{
				$jsonUserdetails = array(
					'notationid'=>'Not available',
					'error_message'=>'Case Number is not available',
					'status'=>'Failure'
				);
			}
			
		}
		else
		{
			$jsonUserdetails = array(
				'notationid'=>'Not available',
				'error_message'=>'Userid is not available',
				'status'=>'Failure'
			);
		}
		echo json_encode($jsonUserdetails);
	}

	public function webserviceUpdateNotation()
	{
		
		$userid = $this->input->post('userid');
		$notationid = $this->input->post('notationid');
		if($userid != '' && $notationid != '')
		{
			$this->load->model('logindetailsmodel');
			$this->load->model('notationmodel');
			$role = $this->logindetailsmodel->userrole($userid);
			$this->session->set_userdata('userid',$userid);
			
			if($role == 1)
			{
				$role = 'Admin';
				$this->session->set_userdata('role','Admin');
			}
			else{
				$role = 'User';
				$this->session->set_userdata('role','User');
			}

			$citation = $this->input->post('citation');
			$casename = $this->input->post('casename');
			$casenumber = $this->input->post('casenumber');

			if($casename != '')
			{
				$vx = 0;
				if($citation==''){
				
					if($casenumber != '')
					{
						
					}
					else
					{
						++$vx;
						$jsonUserdetails = array(
							'notationid'=>'Not available',
							'error_message'=>'Case Number is not available',
							'status'=>'Failure'
						);
					}
				}
				if($vx == 0)
				{
					$notationid = $this->notationmodel->updateWebNotation($notationid, $casename, $citation, $casenumber, $userid, $role);
					$jsonUserdetails = array(
						'notationid'=>$notationid,
						'error_message'=>'Not available',
						'status'=>'Success'
					);	
				}
				
			}
			else
			{
				$jsonUserdetails = array(
					'notationid'=>'Not available',
					'error_message'=>'Case Number is not available',
					'status'=>'Failure'
				);
			}
			
		}
		else
		{
			$jsonUserdetails = array(
				'notationid'=>'Not available',
				'error_message'=>'Userid & Notation is not available',
				'status'=>'Failure'
			);
		}
		echo json_encode($jsonUserdetails);
	}

	public function validate_credentials(){
		
		$this->load->model('logindetailsmodel');
		$result = $this->logindetailsmodel->useravailable();
		if($result)
		{
			$role = $this->logindetailsmodel->userrole($this->input->post('j_username'));
			$userid = $this->logindetailsmodel->userid($this->input->post('j_username'));
			$this->session->set_userdata('userid',$userid);

			if($role == 1){
				
				$this->session->set_userdata('username',$this->input->post('j_username'));
				$this->session->set_userdata('role','Admin');
				$result = $this->logindetailsmodel->session_tracking($this->session->all_userdata());
				
				$session_value = array(
					'roleid'=>'1',
					'role'=>'Admin'
				);
				
				$this->session->set_userdata('pilltabsValue', 'draftNotation');
				$this->session->set_userdata($session_value);
				redirect('admin/homepage');
			}
			else{
				
				$this->session->set_userdata('username',$this->input->post('j_username'));
				$this->session->set_userdata('role','User');

				$result = $this->logindetailsmodel->session_tracking($this->session->all_userdata());
				$session_value = array(
					'roleid'=>'2',
					'role'=>'Lawyer'
				);
				$this->session->set_userdata('pilltabsValue', 'draftNotation');
				$this->session->set_userdata($session_value);
				
				redirect('user/homepage');
			}
		}
		else
		{
			//$this->index();
			redirect('login');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('username');
		$this->session->sess_destroy();
		redirect('login','refresh');
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */