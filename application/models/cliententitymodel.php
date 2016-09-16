<?php 
class Cliententitymodel extends CI_Model {

	public function fetchListOfClient()
	{
		$str = "select * from law_client_master";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function clientNameAvailable($name){
				
		$query = $this->db->query("select count(client_name) as cntname from law_client_master  where (UPPER(client_name) = '".strtoupper($name)."')");
		
		$data = array();
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['cntname'];//i am not want item code i,eeeeeeeeeeee
		}

		if ($count == 0)
		{
			array_push($data, true);
		}
		else{
			array_push($data, false);
		}
		
		return $data;
	}

	public function clientDetails($clientid)
	{
		$str = "select * from law_client_master where disable='N' and CLIENTID='".$clientid."'";
		$query = $this->db->query($str);
		$result = $query->result_array();

		$data = array();
		foreach($result as $row)
		{
			$clientid = $row['CLIENTID'];
			array_push($data, $clientid);
			$name = $row[' 	CLIENT_NAME'];//i am not want item code i,eeeeeeeeeeee
			array_push($data, $name);
			$email = $row['CLIENT_EMAIL'];
			array_push($data, $email);
		}

		return $data;
	}

	public function insertClientEntities($data)
	{
		$this->db->insert('law_client_master', $data); 
		$autoid = $this->db->insert_id();

		$this->db->where('id', $autoid);
		$clientid = 'CLI'.$autoid;
		
		$this->db->set('CLIENTID', $clientid);
		$this->db->set('BELONGS_TO', $this->session->userdata('userid'));

		$this->db->update('law_client_master');

		/* Client Entities */
		$number_of_entries = $this->input->post('numberofClientEntity');

		$entityname = $this->input->post('entityname');
		//$entityemail = $this->input->post('entityemail');
		$entitysupernote = $this->input->post('entitysupernote');
		echo "number_of_entries: ".$number_of_entries;
		if($number_of_entries >= 0)
		{
			for ($i=0; $i <$number_of_entries ; $i++) {
				
				$itemlist = array();

				if(($entityname[$i] == "") || ($clientid == ""))
					continue;

				$itemlist['ENTITY_NAME'] = $entityname[$i];
				//$itemlist['ENTITY_EMAIL'] = $entityemail[$i];
				$itemlist['SUPERNOTE'] = $entitysupernote[$i];
				$itemlist['CLIENTID'] = $clientid;

				$entityautoid = $this->db->insert('law_client_entity', $itemlist);
				
				$this->db->where('id', $entityautoid);
				$entityid = 'ENE'.$autoid;
				
				$this->db->set('ENTITYID', $entityid);
				$this->db->update('law_client_entity');

			}
		}

		$number_of_case = $this->input->post('numberofClientCase');
		$casenumber = $this->input->post('casenumber');
		$casesupernote = $this->input->post('casesupernote');
		$caseEntity = $this->input->post('caseEntity');
		
		if($number_of_case >= 0)
		{
			for ($j=0; $j <$number_of_case; $j++) {

				if($casenumber[$j] != '')
				{
					$casenumber_array = explode(';', $casenumber[$j]);
					$caseList = array_map('trim', $casenumber_array);

				
					foreach ($caseList as $singlecasenumber) {
						$caselist = array();
						if($caseEntity[$j] != '')
							$caselist['ENTRYID'] = $caseEntity[$j];
						else
							$caselist['ENTRYID'] = $clientid;
						
						$caselist['CASENUMBER'] = $singlecasenumber;
						$caselist['SUPERNOTE'] = $casesupernote[$j];
						$caselist['CLIENTID'] = $clientid;
						$this->db->insert('law_client_entity_case', $caselist);
					}
				}
			}
		}
		/* Client Entities */
		redirect('admin/cliententity');
	}
}

/* End of file Configurationmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */