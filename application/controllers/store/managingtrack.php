<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managingtrack extends CI_Controller {

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
        $crud->set_table('ips_ordertracking');
        $crud->set_subject('Sales Tracking');
        $crud->required_fields('NAME');
        $crud->columns('ordertrackingid','orderid','name','orderdate');
		// $crud->columns('fullfillment','orderdate','orderid','returnid','itemrece','caseid','product','status');
		
		//$crud->fields('ordertrackingid','orderid','name','orderdate');
		$crud->callback_column('ordertrackingid',array($this,'_callback_webpage_url'));
		$crud->callback_column('orderdate',array($this,'_callback_dateformat'));
		// $crud->fields('NAME');
		// $crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
		
		// $crud->callback_after_insert(array($this, 'fullfillmentid_generation'));
		
        $output = $crud->render();
		$state = $crud->getState();
		if($state == 'add')
		{
			  redirect('store/addtracking');
		}
		
		// $this->grocery_crud->set_table('ips_login');
        // $output = $this->grocery_crud->render();
		$this->_example_output($output);
	} 		
	
	public function _callback_dateformat($value, $row)
	{
		return date('d-m-Y',$value);
	}
	
	public function _callback_webpage_url($value, $row)
	{
	  return "<a href='".site_url('store/managingtrack/edittracking?orderid='.$row->hashordertrackingid)."'>$value</a>";
	}

	function _example_output($output = null)
    {
        $this->load->view('store/managetracking',$output);    
    }
	
	public function viewtracking()
	{
		$ordertrackid = $_GET['orderid'];
		
		$this->load->model('trackingmodel');
		$data = $this->trackingmodel->fetchOrderDetails($ordertrackid);
		
		$this->load->model('configurationmodel');
		$data['dispositiondetails'] = $this->configurationmodel->fetchDisposition();
		$data['fullfillmentdetails'] = $this->configurationmodel->fetchFullfillment();
		$data['procondtiondetails'] = $this->configurationmodel->fetchProductCondition();
		$data['statusdetails'] = $this->configurationmodel->fetchProductStatus();
		
		
		$this->load->view('store/viewtracking',$data);    
	}
	
	public function edittracking()
	{
		$ordertrackid = $_GET['orderid'];
		
		$this->load->model('trackingmodel');
		$data = $this->trackingmodel->fetchOrderDetails($ordertrackid);
		
		$this->load->model('configurationmodel');
		$data['dispositiondetails'] = $this->configurationmodel->fetchDisposition();
		$data['fullfillmentdetails'] = $this->configurationmodel->fetchFullfillment();
		$data['procondtiondetails'] = $this->configurationmodel->fetchProductCondition();
		$data['statusdetails'] = $this->configurationmodel->fetchProductStatus();
		$data['branddetails'] = $this->configurationmodel->fetchBrand();
		
		
		$this->load->view('store/edittracking',$data);    
	}
	
	public function updatetracking()
	{
		if(isset($_POST))
		{
			log_message('info',print_r($_POST,TRUE));

			$data = array();
			$casedata = array();
			
			$data['fullfillment'] = $this->input->post('fullfillment');
			$data['itemrece'] = $this->input->post('itemrece');
			$data['name'] = mysql_real_escape_string($this->input->post('name'));
			$data['address'] = mysql_real_escape_string($this->input->post('address'));
			$data['orderid'] = $this->input->post('orderid');
			$data['returnid'] = $this->input->post('returnid');
			$data['orderdate'] = strtotime($this->input->post('orderdate'));
			$data['invoice'] = $this->input->post('invoice');
			$data['srnno'] = $this->input->post('srnno');
			if(strlen($this->input->post('return_initiate_date'))>4)
				$data['return_initiate_date'] = strtotime($this->input->post('return_initiate_date'));
			else
				$data['return_initiate_date'] = $this->input->post('return_initiate_date');
			
			if(strlen($this->input->post('return_rece_date'))>4)
				$data['return_rece_date'] = strtotime($this->input->post('return_rece_date'));
			else
				$data['return_rece_date'] = $this->input->post('return_rece_date');
			
			if(strlen($this->input->post('invoice_date'))>4)
				$data['invoice_date'] = strtotime($this->input->post('invoice_date'));
			else
				$data['invoice_date'] = $this->input->post('invoice_date');
			
			$data['partno'] = $this->input->post('partno');
			$data['return_awb_no'] = $this->input->post('return_awb_no');
			$data['disposition'] = $this->input->post('disposition');
			$data['incidentid'] = $this->input->post('incidentid');
			$data['product'] = $this->input->post('product');
			$data['apx_bill_no'] = $this->input->post('apx_bill_no');
			$data['status'] = $this->input->post('status');
			$data['caseid'] = $this->input->post('casedetails');
			
			if(strlen($this->input->post('casedate'))>4)
				$data['casedate'] = strtotime($this->input->post('casedate'));
			else
				$data['casedate'] = $this->input->post('casedate');
			
			$data['hashordertrackingid'] = $this->input->post('hashordertrackingid'); //$this->session->user
			
			$casedata['caseid'] = $this->input->post('casedetails');
			
			$casedata['casenotes'] = $this->input->post('notes');
			
			log_message('info', '-----------Before Update Order Tracking-------------------');
			log_message('info',print_r($data,TRUE));
			log_message('info',print_r($casedata,TRUE));
			log_message('info',print_r($productdata,TRUE));
			
			$this->load->model('trackingmodel');
			$id = $this->trackingmodel->update_tracking($data,$casedata);
			// echo $id;

			redirect('store/homepage');
		}
	}
	
	public function addnotes()
	{
		$str = '';
		if($this->input->post('hashorderid'))
		{
			log_message('info', '----Add Notes: Hash Order ID-------'.$this->input->post('hashorderid').'------');
			$casedata = array();
			$casedata['caseid'] = $this->input->post('caseid');
			if(strlen($this->input->post('casedate'))>4)
				$data['casedate'] = strtotime($this->input->post('casedate'));
			else
				$data['casedate'] = $this->input->post('casedate');
			$casedata['casenotes'] = $this->input->post('casenotes');
			
			log_message('info',print_r($casedata,TRUE));
			
			$orderid = $this->input->post('hashorderid');
			$this->load->model('trackingmodel');
			$casedetails = $this->trackingmodel->update_notes($orderid,$casedata);
			
			$str = '<table class="table">
				<thead>
					<tr>
						<th>#</th>
						
						<th>Notes</th>
					</tr>
				</thead>
				<tbody>';
				
				$clsrow = array(
					0=>"success",
					1=>"info",
					2=>"warning",
					3=>"danger"
				);
				$j = 1;
				$i = 0;
				foreach($casedetails as $caserow)
				{
					if($i == 4)
						$i = 0;
					$str .= "<tr class='".$clsrow[$i]."'>";
					$str .= "<td>".$j."</td>";
					$str .= "<td>".$caserow['casenotes']."</td>";
					$str .= "</tr>";					
					$j++;
					$i++;
				}
				$str .= '</tbody></table>';
				echo $str;
		}
		else{
			echo "Case Note is empty!";
		}
		
	}
}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */