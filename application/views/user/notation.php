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

    <title>Create Notation</title>
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
	<form name="frmNotation" id="frmNotation" action="notation/save" method="post" onsubmit="return frmvalidation()"  autocomplete="off">
    <div class="container-fluid">
    	<?php $this->load->view('includes/defaultconfiguration');?>
    	
    	<div class="blockUIOverlay" style="display:none; z-index: 1000; border: medium none; width: 100%; height: 100%; top: 0px; left: 0px; background-color: #5f5c5c; opacity: 0.6; cursor: wait; position: absolute;"></div>
      	<div class="blockUILoading" style="display:none; z-index: 1011; position: absolute; top: 45%; left: 50%; text-align: center; cursor: wait;">
             <div class="loading-message loading-message-boxed"><img style="width: 20px;" src="<?php echo base_url();?>img/spinner-big.gif"><span>&nbsp;&nbsp;Processing...</span></div>
      	</div>

		<div class="panel panel-success">
			<div class="panel-heading">
				<center><label><b>Create Notation</b></label></center>
			</div>
		</div>		
		<div id="page-wrapper" style="margin: auto 20px;">
			<div class="panel panel-default">
                <div class="panel-heading">Case Information</div>
                <div class="panel-body">

            		<div class="row-fluid">
						<div class="span3">
							<div id="divcasename" class="form-group">
								<label class="control-label">Case Name</label>
								<input  class="form-control" type="text" id="casename" name="casename" value=""/>
								<input type="hidden" name="ntype" id="ntype" value=""/>
								<input type="hidden" name="statusType" id="statusType" value=""/>
							</div>
						</div>
						<div class="span3">
							<div id="divcitation" class="form-group">
								<label class="control-label">Citation</label>
								<input  class="form-control" type="text" id="citation" name="citation" value=""/>
								<input  class="form-control" type="hidden" id="dubcitation" name="dubcitation" value=""/>
							</div>
							<div class="form-group" id="divhref">
								
							</div>
						</div>
						<div class="span3">
							<div id="divcasenumber" class="form-group">
								<label class="control-label">Court assigned case number</label>
								<input  class="form-control" type="text" id="casenumber" name="casenumber" value=""/>
							</div>
							<!--
							<label class="control-label">Court Type</label>
							<select  class="form-control" id="court_type" name="court_type">
								<option value="">Select</option>
								<?php 
									foreach ($courtDetails as $row) {
										echo "<option value='".$row['SHORTNAME']."'>". $row['NAME'] ."</option>";
									}
								?>
							</select>-->
						</div>
						<div class="span3">
							<div id="divcourt_name" class="form-group">
								<label class="control-label">Court Name</label>
								<input  class="form-control autocomplete_txt"  data-type="court_name" type="text" id="court_name" name="court_name" autocomplete="off" value=""/>
							</div>
						</div>
					</div>   

					<div class="row-fluid"  style="margin-top:20px;">
						<div class="span3">
							<div id="divjudge_name" class="form-group">
								<label class="control-label">Name of Judge</label>
								<input  class="form-control autocomplete_judge" type="text" id="judge_name" name="judge_name" value=""/>
							</div>
						</div>
						<div class="span3">
							<div id="divyear" class="form-group">
								<label class="control-label">Year of Judgement</label>
								<input class="form-control" type="text" id="year" name="year" value=""/>
							</div>
						</div>
						<div class="span3">
							<div id="divbench" class="form-group">
								<label class="control-label">Number of Judges</label>
								<input  class="form-control" type="text" id="bench" name="bench" maxlength="3" value=""/>
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

					<div class="panel panel-info">
		                <div class="panel-heading">Statute and Concepts</div>
		                <div class="panel-body">
		                	<div class='row-fluid'>
					      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
					      			<table class="table table-bordered table-hover tableStatuate">
										<thead>
											<tr>
												<th width="2%"></th>
												<th width="15%">Statute <!--<span title="Add New Statuate" class="insertButton"  data-toggle="modal" data-target="#todoModal" style="cursor:pointer;color: #ed6a43;margin-left:5%;"><i class="fa fa-plus"></i></span>--></th>
												<th width="5%">Section & Subsection <!--<span  title="Add New Subsection" class="insertSubsectionButton"  data-toggle="modal" data-target="#modalValidate" style="cursor:pointer;color: #ed6a43;margin-left:5%;"><i class="fa fa-plus"></i></span>--></th>
												<th width="25%">Concept <!--<span  title="Add New Concept" class="insertConceptButton"  data-toggle="modal" data-target="#conceptModal" style="cursor:pointer;color: #ed6a43;margin-left:5%;"><i class="fa fa-plus"></i></span>--></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td></td>
												<td>
												<input type="text" data-type="1" name="statuate[]" id="statuate_1" class="form-control autocomplete_statuate" autocomplete="off">
												<input type="hidden" name="hiddenstatuate[]" id="hiddenstatuate_1" class="form-control" autocomplete="off">
												</td>
												<td><input type="text" data-type="1" name="subsection[]" id="subsection_1" class="form-control autocomplete_subsection" autocomplete="off" ondrop="return false;" >
												<input type="hidden" name="hiddensubsection[]" id="hiddensubsection_1" class="form-control" autocomplete="off">
												</td>
												<td><input type="text" data-type="1" name="concept[]" id="concept_1" class="form-control autocomplete_concept" autocomplete="off" ondrop="return false;" ></td>
											</tr>
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

		            <div class="panel panel-danger">
		                <div class="panel-heading">List of Citation</div>
		                <div class="panel-body">
		                	<div class="row-fluid">
								<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
									<input type="hidden" id="numberOfCitationEntries" name="numberOfCitationEntries" value="1"> </input>
									<table class="table table-bordered table-hover tableCitation">
										<thead>
											<tr>
												<th></th>
												<th>Type of Citation</th>
												<th>Case Name</th>
												<th>Citation</th>
												<th>Note</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<!--<td><input class="case_citation" type="checkbox"/></td>-->
												<td></td>
												<td>
												<select  class="form-control"  data-type="typeCitation" id="typeCitation_1" name="typeCitation[]">
													<option value="">Select</option>
													<?php 
														foreach ($typeOfCitation as $row) {
															echo "<option value='".$row['CIID']."'>". $row['NAME'] ."</option>";
														}
													?>
												</select>
												</td>
												<td><input type="text" data-type="1" name="listCaseName[]" id="listCaseName_1" class="form-control autocomplete_casename" autocomplete="off"/></td>
												<td><input type="text" data-type="1" name="citationNumber[]" id="citationNumber_1" class="form-control autocomplete_citation" autocomplete="off"/></td>
												<td><textarea  name="note[]" id="note_1" class="form-control" style="height: 35px;"></textarea> </td>
											</tr>
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


		            <div class="clear-both" style="margin-top:20px;"></div>

					<div class="row-fluid" style="margin-top:20px;">
						<div class="span12">
							<label class="control-label">Facts of Case</label>
							<textarea id="facts_of_case" class="form-control myTextEditor"  placeholder="Facts of Case" name="facts_of_case" ></textarea>				
						</div>
					</div>

					<div class="row-fluid" style="margin-top:20px;">
						<div class="span12">
							<label class="control-label">Notes</label>
							<textarea id="case_note" class="form-control myTextEditor"  placeholder="Notes" name="case_note" ></textarea>				
						</div>
					</div>
            	</div>
            </div>
			
			

			
			
            <!--
			<div class="panel panel-warning">
                <div class="panel-heading">Phrase and Legal Definitions</div>
                <div class="panel-body">
                	<div class="row-fluid">
						<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
							<table class="table table-bordered table-hover tablePhrase">
								<thead>
									<tr>
										<th></th>
										<th>Phrase</th>
										<th>Legal Definitions</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><input class="case_phrase" type="checkbox"/></td>
										<td><input type="text" data-type="phrase" name="phrase[]" id="phrase_1" class="form-control" autocomplete="off"></td>
										<td><textarea  name="legal[]" id="legal_1" class="form-control"></textarea> </td>
									</tr>
								</tbody>
							</table>
							<div class="clear-both" style="margin-top:20px;"></div>
							<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
					  			<button class="btn btn-danger phraseDelete" type="button">- Delete</button>
					  			<button class="btn btn-success phraseAddmore" type="button">+ Add More</button>
					  		</div>	
						</div>
					</div>
            	</div>
            </div>-->
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
		  		<div class="row-fluid">
		  			<div class="span10" style="text-align:center;">
		  				<label  style="margin-right: 15px;">
                         <input type="checkbox" name="chkPrivate" id="chkPrivate" value="public"><span style="font-weight:bold;"> save it as Public</span></label>
                         <input type="hidden" name="status" id="status" value="private" />
		  			</div>
		  		</div>
		  		<div class="row-fluid">
					<div class="span10" style="text-align:center;">
						<button type="submit" class="btn btn-primary" id="save"  >
			                Save <i class="fa fa-close"></i>
			            </button>
			            
					</div>
				</div>
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
									<label for="statuateDes">Description</label>
									<input id="statuateDes" type="text" class="form-control" name="statuateDes" value="">
								</div>
								
								<div class="clearfix"><br></div>
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-4"></div>
										<div class="col-md-8" id="statuateAction" style="display:none;">
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
                <div class="row-fluid" style="margin-top: 10px;">
                	<div class="span12">
                		<table class="table table-bordered table-striped tableNewSubSection">
							<thead>
								<tr>
									<th colspan="2">Subsection Name</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<!--<td><input class="case_sub" type="checkbox"/></td>-->
									<td>
									<input type="text" name="subsectionname[]" id="subsectionname_1" class="form-control" autocomplete="off"></td>
									
								</tr>
							</tbody>
						</table>
						<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				  			<!---<button type="button" class="btn btn-danger deleteSub"><i class="fa fa-trash-o" aria-hidden="true"></i></button>-->
				  			<button type="button" class="btn btn-success addSub"><i class="fa fa-plus" aria-hidden="true"></i></button>
				  		</div>
                	</div>
                </div>
                <!--
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Subsection Name</label>
                        <input  class="form-control" type="text" id="subsectionname" name="subsectionname" value=""/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <label  for="description" class="control-label">Description</label>
                        <input  class="form-control" type="text" disabled="true" id="description" name="description" value=""/>
                    </div>
                </div>-->

                <div class="clearfix"><br></div>
                <div class="center modalButton" id="subsectionAction"  style="text-align:center;">
                  <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                  <button type="button" class="btn btn-primary nonEisValidate" name="saveSubsection" id="saveSubsection">Save</button>
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
			            <div class="row-fluid">
		                    <div class="span12">
		                        <label for="constatuate">Statute</label>
		                        <input id="constatuate" type="text" class="form-control autocomplete_clonestatuate" name="constatuate" value="">
		                        <input type="hidden" name="hiddenconceptstatuate" id="hiddenconceptstatuate" class="form-control" value="">
		                        
		                    </div>
			            </div>

			            <div class="row-fluid">
		                    <div class="span12">
		                        <label for="conceptsubsection">Subsection</label>
		                        <input id="conceptsubsection" type="text" class="form-control autocomplete_clonesubsection" name="conceptsubsection" value="">
		                        <input type="hidden" name="hiddenconceptsubsection" id="hiddenconceptsubsection" class="form-control" value="">
		                    </div>
			            </div>

			            <div class="row-fluid" style="margin-top: 10px;">
		                	<div class="span12">
		                		<table class="table table-bordered table-striped tableNewConcept">
									<thead>
										<tr>
											<th>Name</th>
										</tr>
									</thead>
									<tbody>
										<tr id="rowcon_1">
											<td>
											<input type="text" placeholder="Concept Name" data-type="1" name="conceptName[]" id="conceptName_1" class="form-control " autocomplete="off"></td>
											<!--<td>
											<input type="text" placeholder="Description" name="conceptDescription[]" id="conceptDescription_1" class="form-control" autocomplete="off"></td>-->
											
										</tr>
									</tbody>
								</table>
								<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						  			<button type="button" class="btn btn-success addConceptStatuate"><i class="fa fa-plus" aria-hidden="true"></i></button>
						  		</div>
		                	</div>
		                </div>

			            <div class="clearfix"><br></div>

			            <div class="row-fluid">
			            	<div class="span4"></div>
		                    <div class="span4" id="conceptAction">
		                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary" name="saveConcept" id="saveConcept">Save</button>
		                    </div>
		                    <div class="span4"></div>
			            </div>
					</div><!-- /.modal-body -->
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->	

	<!-- Concept Modal End here-->
	
	<!-- Concept Modal Begin here
		<div class="modal fade" id="conceptModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title"  style="font-weight:bold;">Add Concept</h4>
					</div>
					<div class="modal-body">
			            <div class="row-fluid">
		                    <div class="span12">
		                        <label for="conceptName">Name</label>
		                        <input id="conceptName" type="text" class="form-control" name="conceptName" value="">
		                    </div>
			            </div>

			            <div class="row-fluid">
		                    <div class="span12">
		                        <label for="conceptDescription">Description</label>
		                        <input id="conceptDescription" type="text" class="form-control" name="conceptDescription" value="">
		                    </div>
			            </div>

			            <div class="row-fluid" style="margin-top: 10px;">
		                	<div class="span12">
		                		<table class="table table-bordered table-striped tableNewConcept">
									<thead>
										<tr>
											<th>Statuate</th>
											<th>Subsection</th>
										</tr>
									</thead>
									<tbody>
										<tr id="rowcon_1">
											<td>
											<input type="hidden" name="hiddenconstatuate[]" id="hiddenconceptstatuate_1" class="form-control">
											<input type="text" data-type="1" name="constatuate[]" id="conceptstatuate_1" class="form-control autocomplete_statuate" autocomplete="off"></td>
											<td>
											<input type="text" name="conceptsubsection[]" id="conceptsubsection_1" class="form-control" autocomplete="off"></td>
											
										</tr>
									</tbody>
								</table>
								<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						  			<button type="button" class="btn btn-success addConceptStatuate"><i class="fa fa-plus" aria-hidden="true"></i></button>
						  		</div>
		                	</div>
		                </div>

			            <div class="clearfix"><br></div>

			            <div class="row-fluid">
			            	<div class="span4"></div>
		                    <div class="span4" id="conceptAction">
		                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary" name="saveConcept" id="saveConcept">Save</button>
		                    </div>
		                    <div class="span4"></div>
			            </div>
					</div>
				</div>
			</div>
		</div>

	 Concept Modal End here-->
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
	<script src="<?php echo base_url();?>assets/calc/addNotation.js"></script>
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
		window.open('<?php echo base_url('user/viewnotation');?>'+'?nid='+notationid, '_self')
	}
	</script>
</body>
</html>