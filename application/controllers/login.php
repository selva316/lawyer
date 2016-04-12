<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$data['main_content'] = 'login_form';
		$this->load->view('includes/template',$data);
	}
	
	public function validate_credentials(){
		
		$this->load->model('logindetailsmodel');
		$result = $this->logindetailsmodel->useravailable();
		if($result)
		{
			$role = $this->logindetailsmodel->userrole($this->input->post('username'));
			$userid = $this->logindetailsmodel->userid($this->input->post('username'));
			$this->session->set_userdata('userid',$userid);

			if($role == 1){
				
				$this->session->set_userdata('username',$this->input->post('username'));
				$result = $this->logindetailsmodel->session_tracking($this->session->all_userdata());
				
				$session_value = array(
					'roleid'=>'1',
					'role'=>'Admin'
				);
				
				$this->session->set_userdata($session_value);
				redirect('admin/homepage');
			}
			else{
				
				$this->session->set_userdata('username',$this->input->post('username'));

				$result = $this->logindetailsmodel->session_tracking($this->session->all_userdata());
				$session_value = array(
					'roleid'=>'2',
					'role'=>'Lawyer'
				);
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
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */