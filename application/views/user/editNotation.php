<?php
	if($this->session->userdata('username'))
	{
		//print "<script>window.location.href='".site_url('login')."';</script>";
	}
	else
	{
		print "<script>window.location.href='".site_url('login')."';</script>";
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit Notation</title>
    <!-- jQuery UI CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/jquery/css/jquery-ui.min.css" />
	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/dist/css/bootstrap.min.css" />
	<!-- Bootstrap Responsive CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/bootstrap-responsive.min.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/jquery/css/datepicker.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/datatables/css/jquery.dataTables.css" />
	
	<!-- MetisMenu CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/metisMenu/dist/metisMenu.min.css" />
	
	<link rel="stylesheet" href="<?php echo base_url();?>assets/menu/css/menu.css" />
	
    <!-- Timeline CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>dist/css/timeline.css" />
    <!-- Custom Fonts -->
    <link rel="stylesheet"  href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet"  href="<?php echo base_url();?>assets/toaster/toastr.min.css" />

    <style>
		.ui-autocomplete {
			z-index: 9999;
		}

		#mceu_29{
			display: none;
		}

		#mceu_60{
			display: none;	
		}
	</style>
</head>

<body>
	<form name="frmNotation" id="frmNotation" action="editnotation/update" method="post" onsubmit="return frmvalidation()"  autocomplete="off">
    <div class="container-fluid">
    	<?php $this->load->view('includes/defaultconfiguration');?>
    	
    	<div class="blockUIOverlay" style="display:none; z-index: 1000; border: medium none; width: 100%; height: 100%; top: 0px; left: 0px; background-color: #5f5c5c; opacity: 0.6; cursor: wait; position: absolute;"></div>
      	<div class="blockUILoading" style="display:none; z-index: 1011; position: absolute; top: 45%; left: 50%; text-align: center; cursor: wait;">
             <div class="loading-message loading-message-boxed"><img style="width: 20px;" src="<?php echo base_url();?>img/spinner-big.gif"><span>&nbsp;&nbsp;Processing...</span></div>
      	</div>
      	<!--
		<div class="panel panel-success titleClass">
			<div class="panel-heading">
				<center><label><b>Edit Notation</b></label></center>
			</div>
		</div>-->		
		<div id="page-wrapper" class="titleClass">
			<div class="panel panel-default">
                <div class="panel-heading">Case Information</div>
                <div class="panel-body">

            		<div class="row-fluid">
						
						<div class="span3">
							<div id="divcitation" class="form-group">
								<label class="control-label">Citation</label>
								<input  class="form-control" type="text" id="citation" name="citation" value="<?php echo $citation; ?>"/>
								<input  class="form-control" type="hidden" id="dubcitation" name="dubcitation" value="<?php echo $dup_citation; ?>"/>
							</div>
							<div class="form-group" id="divhref">
								
							</div>
						</div>
						<div class="span3">
							<div id="divcasename" class="form-group">
								<label class="control-label">Case Name</label>
								<input  class="form-control" type="text" id="casename" name="casename" value="<?php echo $casename; ?>"/>
								<input type="hidden" name="ntype" id="ntype" value="<?php echo $notationid; ?>"/>
								<input type="hidden" name="statusType" id="statusType" value="<?php echo $type; ?>"/>
							</div>
						</div>
						<div class="span3">
							<div id="divcasenumber" class="form-group">
								<label class="control-label">Court assigned case number</label>
								<input  class="form-control" type="text" id="casenumber" name="casenumber" value="<?php echo $casenumber; ?>"/>
							</div>
						</div>
						<div class="span3">
							<div id="divcourt_name" class="form-group">
								<label class="control-label">Court Name</label>
								<input  class="form-control autocomplete_txt"  data-type="court_name" type="text" id="court_name" name="court_name" autocomplete="off" value="<?php echo $court_name; ?>"/>
							</div>
						</div>
					</div>   

					<div class="row-fluid"  style="margin-top:20px;">
						<div class="span3">
							<div id="divjudge_name" class="form-group">
								<label class="control-label">Name of Judge</label>
								<input  class="form-control autocomplete_judge" type="text" id="judge_name" name="judge_name" value="<?php echo $judge_name; ?>"/>
							</div>
						</div>
						<div class="span3">
							<div id="divyear" class="form-group">
								<label class="control-label">Year of Judgement</label>
								<input  class="form-control" type="text" id="year" name="year" value="<?php echo $year; ?>"/>
							</div>
						</div>
						<div class="span3">
							<div id="divbench" class="form-group">
								<label class="control-label">Number of Judges</label>
								<input  class="form-control" type="text" id="bench" name="bench" maxlength="3" value="<?php echo $bench; ?>"/>
							</div>
						</div>
						<!--
						<div class="span3">
							<div id="divstatus" class="form-group">
								<label  class="control-label" >Status</label>
								<select  class="form-control"  id="status" name="status">
									<option value="">Select</option>
									<?php 
									foreach ($status as $row) {
										$role = $this->session->userdata('role');

										if(('dbversion' == $row['NAME']))
										{
											if($role == 'Admin')
												echo "<option value='".$row['NAME']."'>". $row['DESCRIPTION'] ."</option>";
											else
												continue;
										}
										else
											echo "<option value='".$row['NAME']."'>". $row['DESCRIPTION'] ."</option>";

									}
								?>
								</select>
							</div>
						</div>-->
					</div> 

					<div class="clear-both" style="margin-top:20px;"></div>

							

					<div class="panel panel-default">
		                <div class="panel-heading">Statute and Concepts</div>
		                <div class="panel-body">
		                	<div class='row-fluid'>
					      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
					      			<input type="hidden" id="numberOfStatuateEntries" name="numberOfStatuateEntries" value="<?php echo count($statuatedetails); ?>"> </input>
					      			<table class="table table-bordered table-hover tableStatuate">
										<thead>
											<tr>
												<th width="2%"></th>
												<th width="15%">Statute <!--<span title="Add New Statuate" class="insertButton"  data-toggle="modal" data-target="#todoModal" style="cursor:pointer;color: #ed6a43;margin-left:5%;"><i class="fa fa-plus"></i></span>--></th>
												<th width="5%">Section & Subsection <!--<span  title="Add New Subsection" class="insertSubsectionButton"  data-toggle="modal" data-target="#modalValidate" style="cursor:pointer;color: #ed6a43;margin-left:5%;"><i class="fa fa-plus"></i></span>--></th>
												<th width="25%">Concept <!--<span  title="Add New Concept" class="insertConceptButton"  data-toggle="modal" data-target="#conceptModal" style="cursor:pointer;color: #ed6a43;margin-left:5%;"><i class="fa fa-plus"></i>--></span></th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$k = 1;
												foreach( $statuatedetails as $statuaterow ){
											?>
											<tr>
												<td><input class="case" type="checkbox"/></td>
												<td><input type="text" data-type="<?php echo $k; ?>" name="statuate[]" id="statuate_<?php echo $k; ?>" class="form-control autocomplete_statuate" autocomplete="off" value="<?php echo $statuaterow['statuate']; ?>">
												<input type="hidden" name="hiddenstatuate[]" id="hiddenstatuate_<?php echo $k; ?>" class="form-control" autocomplete="off" value="<?php echo $statuaterow['hiddenstatuate']; ?>"></td>
												<td>
												<input type="text" data-type="<?php echo $k; ?>" name="subsection[]" id="subsection_<?php echo $k; ?>" class="form-control autocomplete_subsection" autocomplete="off" value="<?php echo $statuaterow['sub_section']; ?>" ondrop="return false;" >
												<input type="hidden" name="hiddensubsection[]" id="hiddensubsection_<?php echo $k; ?>" class="form-control" autocomplete="off" value="<?php echo $statuaterow['hiddensubsection']; ?>">
												</td>
												<td><input type="text" data-type="<?php echo $k; ?>" name="concept[]" id="concept_<?php echo $k; ?>" class="form-control autocomplete_concept" autocomplete="off"  value="<?php echo $statuaterow['concept']; ?>" ondrop="return false;" ></td>
											</tr>
											<?php
												$k++;
												}

												if($k ==1)
												{
											?>
													<tr>
														<td><input class="case" type="checkbox"/></td>
														
														<td><input type="text" data-type="statuate" name="statuate[]" id="statuate_1" class="form-control autocomplete_process" autocomplete="off"></td>
														<td><input type="text" data-type="subsection" name="subsection[]" id="subsection_1" class="form-control autocomplete_process" autocomplete="off" ondrop="return false;" ></td>
														<td><input type="text" data-type="concept" name="concept[]" id="concept_1" class="form-control autocomplete_concept" autocomplete="off" ondrop="return false;" ></td>
													</tr>
											<?php
												}
											?>
										</tbody>
									</table>
									<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
							  			<button class="btn btn-danger delete" type="button">- Delete</button>
							  			<button class="btn btn-success addmore" type="button">+ Add More</button>
							  		</div>
					      		</div>
				      		</div>
		                </div>
		            </div>

		            <div class="clear-both" style="margin-top:20px;"></div>		


					<div class="panel panel-default">
		                <div class="panel-heading">List of Citation</div>
		                <div class="panel-body">
		                	<div class="row-fluid">
								<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
									<input type="hidden" id="numberOfCitationEntries" name="numberOfCitationEntries" value="<?php echo (count($citationdetails) != 0) ? count($citationdetails) : 1 ?>"> </input>
									<table class="table table-bordered table-hover tableCitation">
										<thead>
											<tr>
												<th></th>
												<th>Type of Citation</th>
												<th>Treatment</th>
												<th>Case Name</th>
												<th>Citation</th>
												
												<th>Note</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												foreach ($linkdetails as $linkrow) {
											?>
												<tr>
												<td></td>
												<td><?php echo $linkrow['type_of_citation']; ?></td>
												<td><?php echo ucfirst($linkrow['treatment']); ?></td>
												<td><?php echo $linkrow['casenumber']; ?></td>
												<td><?php echo $linkrow['actual_citation']; ?></td>
												<td><?php echo $linkrow['description']; ?></td>
												</tr>
											<?php		
												}
											?>



											<?php 
												$k = 1;
												foreach( $citationdetails as $citationrow ){
											?>
											<tr>
												<td><input class="case_citation" type="checkbox"/></td>
												<td>
												<!--
												<select  class="form-control"  data-type="typeCitation" id="typeCitation_<?php echo $k; ?>" name="typeCitation[]">
													<option value="">Select</option>
													<?php 
														foreach ($typeOfCitation as $row) {
															if($citationrow['type_of_citation'] == $row['CIID'])
																echo "<option selected value='".$row['CIID']."'>". $row['NAME'] ."</option>";
															else
																echo "<option value='".$row['CIID']."'>". $row['NAME'] ."</option>";
														}
													?>
												</select>-->
												<input type="text" data-type="<?php echo $k; ?>" name="typeCitation[]" id="typeCitation_<?php echo $k; ?>" class="form-control autocomplete_citationType" autocomplete="off" value="<?php echo $citationrow['type_of_citation']; ?>"/>
												</td>
												<td>
													<select  class="form-control"  data-type="<?php echo $k; ?>" id="treatment_<?php echo $k; ?>" name="treatment[]">
													<?php
														$treat = array('positive', 'negative', 'neutral');
														foreach ($treat as $row) {
															if($row == $citationrow['treatment'])
															{
																echo "<option selected value='".$row."'>".ucfirst($row)."</option>";
															}
															else
															{
																echo "<option value='".$row."'>".ucfirst($row)."</option>";
															}
														}
													?>
													</select>
												</td>
												<td><input type="text" data-type="<?php echo $k; ?>" name="listCaseName[]" id="listCaseName_<?php echo $k; ?>" class="form-control autocomplete_casename" autocomplete="off" value="<?php echo $citationrow['casenumber'];?>"/></td>

												<td><input type="text" data-type="citationNumber" name="citationNumber[]" id="citationNumber_<?php echo $k; ?>"  value="<?php echo $citationrow['actual_citation']; ?>" class="form-control autocomplete_citation" autocomplete="off"></td>
												
												<td><textarea  name="note[]" id="note_<?php echo $k; ?>" class="form-control"  style="height: 35px;"><?php echo $citationrow['description']?></textarea> </td>
											</tr>
											<?php 
												$k++;
											}
												if($k == 1)
												{
											?>
												<tr>
													<td><input class="case_citation" type="checkbox"/></td>
													
													<td>
													<input type="text" data-type="1" name="typeCitation[]" id="typeCitation_1" class="form-control autocomplete_citationType" autocomplete="off" value="" />
													<!--
													<select  class="form-control"  data-type="typeCitation" id="typeCitation_1" name="typeCitation[]">
														<option value="">Select</option>
														<?php 
															foreach ($typeOfCitation as $row) {
																echo "<option value='".$row['CIID']."'>". $row['NAME'] ."</option>";
															}
														?>
													</select>-->
													</td>
													<td>
													<select  class="form-control"  data-type="<?php echo $k; ?>" id="treatment_<?php echo $k; ?>" name="treatment[]">
													<?php
														$treat = array('positive', 'negative', 'neutral');
														foreach ($treat as $row) {
															echo "<option value='".$row."'>".ucfirst($row)."</option>";
														}
													?>
													</select>
												</td>
													<td><input type="text" data-type="1" name="listCaseName[]" id="listCaseName_1" class="form-control autocomplete_casename" autocomplete="off"/></td>
													<td><input type="text" data-type="citationNumber" name="citationNumber[]" id="citationNumber_1" class="form-control autocomplete_citation" autocomplete="off"></td>
													<td><textarea  name="note[]" id="note_1" class="form-control"  style="height: 35px;"></textarea> </td>
												</tr>
											<?php
												}
											?>
										</tbody>
									</table>
									<div class="clear-both" style="margin-top:20px;"></div>
									<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
							  			<button class="btn btn-danger typeDelete" type="button">- Delete</button>
							  			<button class="btn btn-success typeAddmore" type="button">+ Add More</button>
							  		</div>	
								</div>
							</div>
		            	</div>
		            </div>

					<div class="row-fluid" style="margin-top:20px;">
						<div class="span12">
							<label class="control-label">Facts of Case</label>
							<textarea id="facts_of_case" class="form-control myTextEditor"  placeholder="Facts of Case" name="facts_of_case" rows="4" cols="45"><?php echo $facts_of_case; ?></textarea>				
						</div>
					</div>

					<div class="row-fluid" style="margin-top:20px;">
						<div class="span12">
							<label class="control-label">Decision</label>
							<textarea id="case_note" class="form-control myTextEditor"  placeholder="Notes" name="case_note" rows="4" cols="45"><?php echo $case_note; ?></textarea>				
						</div>
					</div>
            	</div>
            </div>
			
			

		</div>
			<div class="clear-both" style="margin-top:20px;"></div>
			<!--<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<label>Status</label>
					<select  class="form-control"  id="status" name="status">
						<option value="">Select</option>
						<option value="draft">Draft</option>
						<option value="dbversion">DB Version</option>
						<option value="public">Public</option>
						<option value="private">Private</option>
					</select>
				</div>
			</div>-->
			<div class="clear-both" style="margin-top:20px;"></div>
		  		<?php 
		  			//if(($type != 'dbversion') || ($this->session->userdata('role') == 'Admin'))
		  			if($type != 'dbversion')
		  			{
		  		
		  				if($type != 'dbversion') {
		  		?>
		  		
		  		<div class="row-fluid">
		  			<div class="span10" style="text-align:center;">
		  				<label  style="margin-right: 15px;">
                         <input type="checkbox" name="chkPrivate" id="chkPrivate" value="public"><span style="font-weight:bold;"> Save it as Public</span></label>
                         <input type="hidden" name="status" id="status" value="private" />
		  			</div>
		  		</div>

		  			<?php
		  				}
		  			?>
		  		
		  		<div class="row-fluid">
					<div class="span10" style="text-align:center;">
						<button type="submit" class="btn btn-primary" id="save"  >
			                Update <i class="fa fa-close"></i>
			            </button>
			            
					</div>
				</div>
				<?php
					}
				?>
			</div>
			<!-- /#page-wrapper -->
		</div>
		<!-- Statuate Modal Begin here-->
		<div class="modal fade" id="todoModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title"  style="font-weight:bold;">Add Statute</h4>
					</div><!-- /.modal-header -->
					<div class="modal-body">
						<div class="row" style="margin:2%">
							<div class="col-md-12">

								<div style="margin-bottom: 15px; text-align:left; font-weight:bold;">
									<label for="todoTitle">Name</label>
									<input id="statuateName" type="text" class="form-control" name="statuateName" value="">
								</div>
								<div style="margin-bottom: 15px; text-align:left; font-weight:bold;">
									<label for="description">Description</label>
									<input id="statuateDes" type="text" class="form-control" name="statuateDes" value="">
								</div>
								
								<div class="clearfix"><br></div>
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-4"></div>
										<div class="col-md-8">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" name="saveStatuate" id="saveStatuate">Save</button>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div><!-- /.modal-body -->
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->	

	<!-- Statuate Modal End here-->

	<!-- Statuate sub Section Modal Begin here-->
	<div class="modal fade" id="modalValidate">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">New Subsection</h4>
              </div>
              <div class="modal-body">
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Statute</label>
                        <select class="form-control" id="statuatename" name="statuatename" >
                            <option value="">Select</option>
                            <?php
                                foreach ($StatuateSubsection as $k=>$v) {
                                    echo '<option value="'.$k.'">'.$v.'</option>';
                                }
                            ?>
                        </select>
                        
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Subsection Name</label>
                        <input  class="form-control" type="text" id="subsectionname" name="subsectionname" value=""/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Description</label>
                        <input  class="form-control" type="text" disabled="true" id="description" name="description" value=""/>
                    </div>
                </div>

                <div class="clearfix"><br></div>
                <div class="center modalButton"  style="text-align:center; display:none;">
                  <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                  <button type="button" class="btn btn-primary nonEisValidate" data-dismiss="modal" name="proceedButton" id="proceedButton">Save</button>
                </div>
                <div class="clearfix"></div>
              </div>
          </div><!--/.modal-content -->
          </div><!--/.modal-dialog -->
        </div> <!--/.modal -->
	<!-- Statuate sub Section Modal End here-->        
	<!-- Concept Modal Begin here-->
		<div class="modal fade" id="conceptModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title"  style="font-weight:bold;">Add Concept</h4>
					</div><!-- /.modal-header -->
					<div class="modal-body">
						<div class="row" style="margin:2%">
							<div class="col-md-12">

								<div style="margin-bottom: 15px; text-align:left; font-weight:bold;">
									<label for="conceptName">Name</label>
									<input id="conceptName" type="text" class="form-control" name="conceptName" value="">
								</div>
								<div style="margin-bottom: 15px; text-align:left; font-weight:bold;">
									<label for="conceptDescription">Description</label>
									<input id="conceptDescription" type="text" class="form-control" name="conceptDescription" value="">
								</div>
								
								<div class="clearfix"><br></div>
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-4"></div>
										<div class="col-md-8">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" name="saveConcept" id="saveConcept">Save</button>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div><!-- /.modal-body -->
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->	

	<!-- Concept Modal End here-->
	</form>		
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/jquery/jquery.js"></script>
	<script src="<?php echo base_url();?>assets/jquery/jquery-ui.min.js"></script>

	<script src="<?php echo base_url();?>assets/tinymce/js/tinymce/tinymce.min.js"></script>	
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/jquery/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url();?>assets/menu/js/menuscript.js"></script>
	
	<script src="<?php echo base_url();?>assets/calc/auto.js"></script>
	<script src="<?php echo base_url();?>assets/calc/generic.js"></script>
	<script src="<?php echo base_url();?>assets/calc/editNotation.js"></script>
	<script src="<?php echo base_url();?>assets/datatables/js/jquery.dataTables.js"></script>
	
	<!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/metisMenu/dist/metisMenu.min.js"></script>
    <script src="<?php echo base_url();?>assets/toaster/toastr.min.js"></script>
	
	<script>
	tinymce.init({  
		mode : "specific_textareas",
		plugins: "autoresize",
        editor_selector : "myTextEditor"
	});

	function viewCitation(notationid)
	{
		//window.location.href =  '<?php echo base_url('user/viewnotation');?>'+'?nid='+notationid;
		window.open('<?php echo base_url('user/viewnotation');?>'+'?nid='+notationid, '_self');
	}
	</script>

	<script>
	
	</script>
</body>
</html>