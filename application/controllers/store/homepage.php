<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		
		$this->load->library('grocery_CRUD');
	}
	
	public function index()
	{
		$crud = new grocery_CRUD();
				
		$crud->set_theme('datatables');
		$crud->set_model('My_Custom_model');
        $crud->set_table('ips_ordertracking', 'ips_productitems');
        $crud->set_subject('Sales Tracking');
        $crud->required_fields('NAME');
		
		// void set_relation_n_n( string $field_name, string $relation_table, string $selection_table, string $primary_key_alias_to_this_table, string $primary_key_alias_to_selection_table , string $title_field_selection_table [ , string $priority_field_relation ] )
		$crud->set_relation_n_n('orderdetails', 'ips_ordertracking', 'ips_productitems', 'ips_ordertracking', 'ordertrackingid', 'description','category');
		
		
		// $crud->set_relation('ordertrackingid','ips_productitems','description');
        
		// $crud->columns('ordertrackingid','fullfillment','orderdate','orderid','returnid','itemrece','caseid','product','status','Action');
		
		// $crud->display_as('orderdate','Order Date')->display_as('orderid','Order ID')->display_as('returnid','Sales Return ID')->display_as('itemrece','Item Received')->display_as('caseid','Case ID')->display_as('product','Product Condition')->display_as('ordertrackingid','ID');
		
		
		$crud->columns('ordertrackingid','orderid','description','category','product','itemrece','cost','mrp','Action');
		
		$crud->display_as('orderid','Order ID')->display_as('itemrece','Item Received')->display_as('product','Product Condition')->display_as('ordertrackingid','ID')->display_as('description','Product Name')->display_as('category','Category')->display_as('cost','Recovery Min')->display_as('mrp','Recovery Max');
		
		$crud->callback_column('ordertrackingid',array($this,'_callback_webpage_url'));
		$crud->callback_column('orderdate',array($this,'_callback_dateformat'));
		
		$crud->callback_column('fullfillment',array($this,'_callback_fullfillment'));
		// $crud->callback_column('product',array($this,'_callback_product'));
		$crud->callback_column('status',array($this,'_callback_status'));
		$crud->callback_column('itemrece',array($this,'_callback_itemrece'));
		$crud->callback_column('cost',array($this,'_callback_recovery_min'));
		$crud->callback_column('mrp',array($this,'_callback_recovery_max'));
		
		$crud->callback_column('Action',array($this,'_callback_viewpage_url'));
		
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_delete();
		
		// $crud->callback_after_insert(array($this, 'fullfillmentid_generation'));
		
        $output = $crud->render();
		$state = $crud->getState();
		if($state == 'add')
		{
			  redirect('store/addtracking');
		}
		
		if($state == 'view')
		{
			  redirect('store/viewtracking');
		}
		// $this->grocery_crud->set_table('ips_login');
        // $output = $this->grocery_crud->render();
		$this->_example_output($output);
	} 		
	
	public function _callback_recovery_min($value, $row)
	{
		$qty = $cost = $mrp = $reimbursed = 0;
		foreach($row as $k=>$v)
		{
			if($k == 'qty')
				$qty = $v;
			
			if($k == 'cost')
				$cost = $v;
			
			if($k == 'mrp')
				$mrp = $v;
			
			if($k == 'reimbursed')
				$reimbursed = $v;
			
		}
		$rminval = ($qty * $cost) - $reimbursed;
		$rminval =	number_format($rminval, 2, '.', ',');
		return $rminval;
	}
	
	public function _callback_recovery_max($value, $row)
	{
		$qty = $cost = $mrp = $reimbursed = 0;
		foreach($row as $k=>$v)
		{
			if($k == 'qty')
				$qty = $v;
			
			if($k == 'cost')
				$cost = $v;
			
			if($k == 'mrp')
				$mrp = $v;
			
			if($k == 'reimbursed')
				$reimbursed = $v;
			
		}
		
		$rmaxval = ($qty * $mrp) - $reimbursed;
		$rmaxval =	number_format($rmaxval, 2, '.', ',');
		return $rmaxval;
	}
	
	public function _callback_itemrece($value, $row)
	{
		if($value == 'n')
			return "No";
		else
			return 'Yes';
	}
	
	public function _callback_fullfillment($value, $row)
	{
		$this->load->model('configurationmodel');
		$name = $this->configurationmodel->fetchIdValues('ips_fullfillment', 'FID', 'NAME' ,$value);
		return $name;
	}
	
	public function _callback_status($value, $row)
	{
		$this->load->model('configurationmodel');
		$name = $this->configurationmodel->fetchIdValues('ips_status', 'SID', 'NAME' ,$value);
		return $name;
	}
	
	public function _callback_product($value, $row)
	{
		$this->load->model('configurationmodel');
		$name = $this->configurationmodel->fetchIdValues('ips_productcondition', 'PCID', 'NAME' ,$value);
		return $name;
	}
	
	public function _callback_dateformat($value, $row)
	{
		return date('d-m-Y',$value);
	}
	
	public function _callback_webpage_url($value, $row)
	{
	  return "<a href='".site_url('store/managingtrack/edittracking?orderid='.$row->hashordertrackingid)."'>$value</a>";
	}

	public function _callback_viewpage_url($value, $row)
	{
	  return "<a href='".site_url('store/managingtrack/viewtracking?orderid='.$row->hashordertrackingid)."'>View</a>";
	}
	
	function _example_output($output = null)
    {
        $this->load->view('store/managetracking',$output);    
    }
	
	public function edittracking()
	{
		$data = array();
		$data['val'] = $_GET;
		
		$this->load->view('store/edittracking',$data);    
	}
	
	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */