<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuration extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		
		$this->load->library('grocery_CRUD');
	}
	
	public function index()
	{
		//$data['main_content'] = 'login_form';
		//$this->load->view('includes/template',$data);
		//$this->load->view('admin/configuration');
		//$this->load->view('admin/homepage');
		
		$crud = new grocery_CRUD();
 
        $crud->set_theme('datatables');
        $crud->set_table('ips_login');
        $crud->set_subject('User');
        $crud->required_fields('username');
        $crud->columns('FNAME','LNAME','USERNAME','ROLE','DISABLE');
 
        $output = $crud->render();
		
		// $this->grocery_crud->set_table('ips_login');
        // $output = $this->grocery_crud->render();
		$this->_example_output($output);
	} 		
	
	function _example_output($output = null)
    {
        $this->load->view('admin/configuration',$output);    
    }
}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */