<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addtracking extends CI_Controller {

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
		
		$this->load->model('configurationmodel');
		$data = array();
		
		$data['dispositiondetails'] = $this->configurationmodel->fetchDisposition();
		$data['fullfillmentdetails'] = $this->configurationmodel->fetchFullfillment();
		$data['procondtiondetails'] = $this->configurationmodel->fetchProductCondition();
		$data['statusdetails'] = $this->configurationmodel->fetchProductStatus();
		$data['branddetails'] = $this->configurationmodel->fetchBrand();
		
		$this->load->view('store/addtracking',$data);
	}
	
	public function inserttracking()
	{
		if(isset($_POST))
		{
			log_message('info',print_r($_POST,TRUE));
			$data = array();
			$casedata = array();
			$productdata = array();
			
			$data['fullfillment'] = $this->input->post('fullfillment');
			$data['itemrece'] = $this->input->post('itemrece');
			$data['name'] = mysql_real_escape_string($this->input->post('name'));
			$data['address'] = mysql_real_escape_string($this->input->post('address'));
			$data['orderid'] = $this->input->post('orderid');
			$data['returnid'] = $this->input->post('returnid');
			$data['orderdate'] = strtotime($this->input->post('orderdate'));
			$data['invoice'] = $this->input->post('invoice');
			$data['srnno'] = $this->input->post('srnno');
			$data['return_initiate_date'] = strtotime($this->input->post('return_initiate_date'));
			$data['return_rece_date'] = strtotime($this->input->post('return_rece_date'));
			$data['partno'] = $this->input->post('partno');
			$data['remarks'] = $this->input->post('remarks');

			$data['invoice_date'] = strtotime($this->input->post('invoice_date'));
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
			
			$casedata['caseid'] = $this->input->post('casedetails');
			$casedata['casenotes'] = $this->input->post('notes');
			
			$data['createdby'] = 1; //$this->session->user
			$data['createddate'] = time();
			$data['lastmodifiedby'] = 1; //$this->session->user
			$data['lastmodifieddate'] = time();
			$data['numberofmodification'] = 1;
			/*
			$productdata['upc'] = $this->input->post('upc');
			$productdata['description'] = $this->input->post('description');
			$productdata['category'] = $this->input->post('category');
			$productdata['qty'] = $this->input->post('qty');
			$productdata['cost'] = $this->input->post('cost');
			$productdata['mrp'] = $this->input->post('mrp');
			$productdata['total'] = $this->input->post('total');
			$productdata['reimbursed'] = $this->input->post('reimbursed');
			$productdata['number_of_entries'] = $this->input->post('number_of_entries');
			*/

			log_message('info', '-----------Before Insert Order Tracking-------------------');
			log_message('info',print_r($data,TRUE));
			log_message('info',print_r($casedata,TRUE));
			log_message('info',print_r($productdata,TRUE));
			
			$this->load->model('trackingmodel');
			$id = $this->trackingmodel->add_tracking($data, $casedata,$productdata);
			//echo $id;
			// echo site_url('admin/managingtrack');
			
			// redirect('store/managingtrack');
			redirect('store/homepage');
		}
	}
	
	public function checkMandatory()
	{
		if($this->input->post('fullfillment'))
		{
			$fullfillment = $this->input->post('fullfillment');
			$this->load->model('configurationmodel');
			$val = $this->configurationmodel->fetchSRNAvailable($fullfillment);
			if($val == 'Y')
				echo 'yes';
			else
				echo 'no';
		}
	}
}

/* End of file addtracking.php */
/* Location: ./application/controllers/addtracking.php */