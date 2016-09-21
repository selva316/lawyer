<?php 
class Cliententitymodel extends CI_Model {

	public function fetchListOfClient()
	{
		$userid = $this->session->userdata('userid');
		
		$str = "select * from law_client_master where disable='N' and (timestamp ='$userid' OR updated_by='$userid')";
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

	public function editClientEntities()
	{
		$clientid = $this->input->post('clientid');
		$hashid = $this->input->post('hashid');

		$this->db->where('CLIENTID', $clientid);
		$this->db->delete('law_client_entity');

		$this->db->where('CLIENTID', $clientid);
		$this->db->delete('law_client_entity_case');


		$this->db->set('CLIENT_NAME', $this->input->post('clientname'));
		$this->db->set('SUPERNOTE', $this->input->post('supernote'));
		$this->db->set('UPDATED_ON', time());
		$this->db->set('UPDATED_BY', $this->session->userdata('userid'));

		$this->db->update('law_client_master');
		

		$number_of_entries = $this->input->post('numberofClientEntity');

		$entityname = $this->input->post('entityname');
		//$entityemail = $this->input->post('entityemail');
		$entitysupernote = $this->input->post('entitiessupernote');
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

				$this->db->insert('law_client_entity', $itemlist);
				
				$entityautoid = $this->db->insert_id();

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
							$caselist['ENTITYID'] = $caseEntity[$j];
						else
							$caselist['ENTITYID'] = $clientid;
						
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

	public function insertClientEntities($data)
	{
		$this->db->insert('law_client_master', $data); 
		$autoid = $this->db->insert_id();

		$this->db->where('id', $autoid);
		$clientid = 'CLI'.$autoid;
		
		$hashclientid = md5($clientid.time());
		$this->db->set('CLIENTID', $clientid);
		$this->db->set('HASHCLIENTID', $hashclientid);
		$this->db->set('BELONGS_TO', $this->session->userdata('userid'));
		$this->db->set('UPDATED_BY', $this->session->userdata('userid'));

		$this->db->update('law_client_master');

		/* Client Entities */
		$number_of_entries = $this->input->post('numberofClientEntity');

		$entityname = $this->input->post('entityname');
		//$entityemail = $this->input->post('entityemail');
		$entitysupernote = $this->input->post('entitiessupernote');
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

				$this->db->insert('law_client_entity', $itemlist);
				
				$entityautoid = $this->db->insert_id();

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
							$caselist['ENTITYID'] = $caseEntity[$j];
						else
							$caselist['ENTITYID'] = $clientid;
						
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

	public function fetchClientEntity()
	{
		$hashcid = $this->input->get('hashcid');
		//echo "Notation Id: ".$nid;
		$this->db->select('*');
		$this->db->from('law_client_master');
		$this->db->where('hashclientid', $hashcid);		

		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			//print_r($result);
			$data = array();
			$citationval = '';
			foreach($result as $row)
			{
				$clientid = $row['CLIENTID'];
				$data['clientid'] = $row['CLIENTID'];
				$data['hashclientid'] = $row['HASHCLIENTID'];
				$data['client_name'] = $row['CLIENT_NAME'];
				$data['belongs_to'] = $row['BELONGS_TO'];
				$data['clientsupernote'] = $row['SUPERNOTE'];
				$data['timestamp'] = $row['TIMESTAMP'];
				
				$this->db->select('*');
				$this->db->from('law_client_entity');
				$this->db->where('clientid', $clientid);
				$entityData = array();
				$entityquery = $this->db->get();
				
				if($entityquery->num_rows() > 0)
				{
					$entityresult = $entityquery->result_array();
					$i = 0;
					foreach($entityresult as $entityrow)
					{
						$entityData[$i]['entityid'] = $entityrow['ENTITYID'];
						$entityData[$i]['entityname'] = $entityrow['ENTITY_NAME'];
						$entityData[$i]['entitysupernote'] = $entityrow['SUPERNOTE'];

						$i++;
					}
				}
				$data['entitydetails'] = $entityData;
							
				
				$this->db->select('*');
				$this->db->from('law_client_entity_case');
				$this->db->where('clientid', $clientid);
				$casedata = array();
				$casequery = $this->db->get();
				
				if($casequery->num_rows() > 0)
				{
					$caseresult = $casequery->result_array();
					$i = 0;
					foreach($caseresult as $caserow)
					{
						if($clientid != $caserow['ENTITYID'])
							$casedata[$i]['entityid'] = $caserow['ENTITYID'];
						else
							$casedata[$i]['entityid'] = '';
						$casedata[$i]['casenumber'] = $caserow['CASENUMBER'];
						$casedata[$i]['casesupernote'] = $caserow['SUPERNOTE'];
						
						$i++;
					}
				}
				$data['casedetails'] = $casedata;
				
				return $data;
			}
			
		}
	}
}

/* End of file Configurationmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */