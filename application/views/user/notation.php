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
	
	<style>
		.ui-autocomplete {
			z-index: 9999;
		}

		#mceu_29-0{
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
							</div>
						</div>
						<div class="span3">
							<div id="divcitation" class="form-group">
								<label class="control-label">Citation</label>
								<input  class="form-control" type="text" id="citation" name="citation" value=""/>
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
								<input  class="form-control" type="text" id="judge_name" name="judge_name" value=""/>
							</div>
						</div>
						<div class="span3">
							<div id="divyear" class="form-group">
								<label class="control-label">Year of Judgement</label>
								<input  class="form-control" type="text" id="year" name="year" value=""/>
							</div>
						</div>
						<div class="span3">
							<div id="divbench" class="form-group">
								<label class="control-label">Type of Bench</label>
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

					<div class="row-fluid" style="margin-top:20px;">
						<div class="span8">
							<textarea id="facts_of_case" class="form-control myTextEditor"  placeholder="Facts of Case" name="facts_of_case" rows="4" cols="45"></textarea>				
						</div>
					</div>

            	</div>
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
										<th width="15%">Statute <span title="Add New Statuate" class="insertButton"  data-toggle="modal" data-target="#todoModal" style="cursor:pointer;color: #ed6a43;margin-left:5%;"><i class="fa fa-plus"></i></span></th>
										<th width="15%">Section & Subsection <span  title="Add New Subsection" class="insertSubsectionButton"  data-toggle="modal" data-target="#modalValidate" style="cursor:pointer;color: #ed6a43;margin-left:5%;"><i class="fa fa-plus"></i></span></th>
										<th width="15%">Concept <span  title="Add New Concept" class="insertConceptButton"  data-toggle="modal" data-target="#conceptModal" style="cursor:pointer;color: #ed6a43;margin-left:5%;"><i class="fa fa-plus"></i></span></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td></td>
										<td>
										<input type="text" data-type="1" name="statuate[]" id="statuate_1" class="form-control autocomplete_statuate" autocomplete="off">
										<input type="hidden" name="hiddenstatuate[]" id="hiddenstatuate_1" class="form-control" autocomplete="off">
										</td>
										<td><input type="text" data-type="1" name="subsection[]" id="subsection_1" class="form-control autocomplete_subsection" autocomplete="off" ondrop="return false;" onpaste="return false;">
										<input type="hidden" name="hiddensubsection[]" id="hiddensubsection_1" class="form-control" autocomplete="off">
										</td>
										<td><input type="text" data-type="1" name="concept[]" id="concept_1" class="form-control autocomplete_concept" autocomplete="off" ondrop="return false;" onpaste="return false;"></td>
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
							<table class="table table-bordered table-hover tableCitation">
								<thead>
									<tr>
										<th></th>
										<th>Type of Citation</th>
										<th>Citation Number</th>
										<th>Note</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><input class="case_citation" type="checkbox"/></td>
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
										<td><input type="text" data-type="citationNumber" name="citationNumber[]" id="citationNumber_1" class="form-control autocomplete_citation" autocomplete="off"></td>
										<td><textarea  name="note[]" id="note_1" class="form-control"></textarea> </td>
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
                         <input type="checkbox" name="chkPrivate" id="chkPrivate" value="Private"><span style="font-weight:bold;"> Save it as Private</span></label>
                         <input type="hidden" name="status" id="status" value="public" />
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
						<h4 class="modal-title"  style="font-weight:bold;">Add Statuate</h4>
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
                        <label class="control-label">Statuate</label>
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
		                        <label for="constatuate">Statuate</label>
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
	<script src="<?php echo base_url();?>assets/datatables/js/jquery.dataTables.js"></script>
	
	<!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/metisMenu/dist/metisMenu.min.js"></script>
	
	<script>
	tinymce.init({  
		mode : "specific_textareas",
		plugins: "autoresize",
        editor_selector : "myTextEditor"
	});
	</script>

	<script>
	var interval = null;
	$(document).ready(function() {
		$('#example').DataTable( {
			columnDefs: [ {
				targets: [ 0 ],
				orderData: [ 0, 1 ]
			}, {
				targets: [ 1 ],
				orderData: [ 1, 0 ]
			}, {
				targets: [ 3 ],
				orderData: [ 3, 0 ]
			}]
		});
		/*
		$('.form_datetime').datepicker({
		    //format: 'YYYY-MM-DD',
		    changeMonth: false,
        	changeYear: true,
		    autoclose : true
		});
		*/
		$(".form_datetime").datepicker( {
		    format: "yyyy",
		    startView: "year", 
		    minView: "year"
		});

		interval = setInterval(ajaxCreateCitation, 60000);
	
		//$("#court_name")
	});

	$(document).on('change', '#chkPrivate', function() {
        if(this.checked)
        {
            $("#status").val('private');
        }
        else
        {
            $("#status").val('public');
        }
    });

	function split(val) {
		return val.split(/,\s*/);
	}
	function extractLast(term) {
		return split(term).pop();
	}

	$(document).on('focus','.autocomplete_txt',function(){
		var type = $(this).data('type');
		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : 'notation/ajax',
					dataType: "json",
					method: 'post',
					data: {
					   name_startsWith: request.term,
					   type: type
					},
					 success: function( data ) {
						 response( $.map( data, function( item ) {
							return {
								label: item,
								value: item,
								data : item
							}
						}));
					}
				});
			},
			autoFocus: true,	      	
			minLength: 0,
			select: function( event, ui ) {
				
				$('#court_name').val(ui.item.data);
			}		      	
		});
	});
	
	$(document).on('blur','#citation',function(){
		if($("#casename").val() != '' && $("#citation").val() != '')
		{
			
			$.ajax({
				url : 'notation/caseame_and_citation_avilabilty',
				dataType: "text",
				method: 'post',
				data: {
				   casename: $("#casename").val(),
				   citation: $("#citation").val()
				},
				success: function( data ) {
					if(data != ''){
						clearInterval(interval); 
						$("#divhref").html(data);	
					}
					
				}
			});
		}
	});
	
	$(document).on('blur','#casename',function(){
		if($("#casename").val() != '' && $("#citation").val() != '')
		{
			
			$.ajax({
				url : 'notation/caseame_and_citation_avilabilty',
				dataType: "text",
				method: 'post',
				data: {
				   casename: $("#casename").val(),
				   citation: $("#citation").val()
				},
				success: function( data ) {
					if(data != ''){
						clearInterval(interval); 
						$("#divhref").html(data);	
					}
				}
			});
		}
	});

	
	/*
	$(document).on('focus','.autocomplete_citation',function(){
		var type = $(this).data('citationNumber');
		
		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : 'notation/citationTypeAjax',
					dataType: "json",
					method: 'post',
					data: {
					   name_startsWith: request.term,
					   type: type
					},
					 success: function( data ) {
						 response( $.map( data, function( item ) {
							return {
								label: item,
								value: item,
								data : item
							}
						}));
					}
				});
			},
			autoFocus: true,	      	
			minLength: 0			
		});
	});*/


	$(document).on('focus','.autocomplete_process',function(){
		type = $(this).data('type');
		var url = '';
		if(type =='statuate' )
		{
			autoTypeNo=0;
			url = 'notation/statuateAjax'
		}
		
		if(type =='subsection' )
		{
			autoTypeNo=1; 	
			url = 'notation/subSectionAjax'
		}
		
		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : url,
					dataType: "json",
					method: 'post',
					data: {
					   name_startsWith: request.term,
					   type: type
					},
					 success: function( data ) {
						 response( $.map( data, function( item ) {
						 	var code = item.split("|");
							return {
								label: item,
								value: code[autoTypeNo],
								data : item
							}
						}));
					}
				});
			},
			autoFocus: true,	      	
			minLength: 0,
			select: function( event, ui ) {
				var names = ui.item.data.split("|");						
				id_arr = $(this).attr('id');
		  		id = id_arr.split("_");
				$('#statuate_'+id[1]).val(names[0]);
				$('#subsection_'+id[1]).val(names[1]);

			}		      	
		});
	
	});

	/*
	$(document).on('focus','.autocomplete_statuate',function(){
		
		type = $(this).data('type');
		url = 'notation/statuateAjax';
		autoTypeNo=0;

		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : url,
					dataType: "json",
					method: 'post',
					data: {
					   name_startsWith: request.term,
					   type: type
					},
					 success: function( data ) {
						 response( $.map( data, function( item ) {
						 	var code = item.split("|");
							return {
								label: item,
								value: code[autoTypeNo],
								data : item
							}
						}));
					}
				});
			},
			autoFocus: true,	      	
			minLength: 0,
			select: function( event, ui ) {
				var names = ui.item.data.split("|");						
				id_arr = $(this).attr('id');
		  		id = id_arr.split("_");
		  		//hiddenconceptstatuate_
				$('#conceptstatuate_'+id[1]).val(names[0]);
				$('#conceptsubsection_'+id[1]).val(names[1]);
				$('#hiddenconceptstatuate_'+id[1]).val(names[2]);
			}
		});
	});*/
	
	
	$(document).on('focus','.autocomplete_clonesubsection',function(){
		
		if($("#constatuate").val()!='')
		{
			url = 'notation/fetchUserSubSection';
			autoTypeNo=0;

			$(this).autocomplete({
				source: function( request, response ) {
					$.ajax({
						url : url,
						dataType: "json",
						method: 'post',
						data: {
						   name_startsWith: request.term,
						   statuate: $("#hiddenconceptstatuate").val()
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
							 	var code = item.split("|");
								return {
									label: item,
									value: code[autoTypeNo],
									data : item
								}
							}));
						}
					});
				},
				autoFocus: true,	      	
				minLength: 0,
				select: function( event, ui ) {
					var names = ui.item.data.split("|");						
					id_arr = $(this).attr('id');
			  		id = id_arr.split("_");
			  		//$('#subsection_'+id[1]).val(names[0]);
					$('#conceptsubsection').val(names[0]);
					$("#hiddenconceptsubsection").val(names[1]);
				}
			});	
		}
	});

	$(document).on('focus','.autocomplete_clonestatuate',function(){
		
		url = 'notation/fetchUserStatuate';
		autoTypeNo=0;

		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : url,
					dataType: "json",
					method: 'post',
					data: {
					   name_startsWith: request.term
					},
					 success: function( data ) {
						 response( $.map( data, function( item ) {
						 	var code = item.split("|");
							return {
								label: item,
								value: code[autoTypeNo],
								data : item
							}
						}));
					}
				});
			},
			autoFocus: true,	      	
			minLength: 0,
			select: function( event, ui ) {
				var names = ui.item.data.split("|");						
				id_arr = $(this).attr('id');
		  		id = id_arr.split("_");
		  		
				$('#constatuate').val(names[0]);
				//$('#conceptsubsection').val(names[1]);
				$('#hiddenconceptstatuate').val(names[1]);
				//$("#hiddenconceptsubsection").val(names[3]);
			}
		});
	});


	function saveAsDraft()
	{
		if($("#ntype").val() != '')
		{
			var casename  = $("#casename").val();
			var citation = $("#citation").val();
			var judge_name = $("#judge_name").val();
			var court_name = $("#court_name").val();
			var casenumber = $("#casenumber").val();
			var year = $("#year").val();

			var bench = $("#bench").val();
			var facts_of_case = $("#facts_of_case").text();
			var status = $("#status").val();

			$.ajax({
				url : 'notation/autoSaveAsDraft',
				dataType: "text",
				method: 'post',
				data: {
				   ntype: $("#ntype").val(),
				   casename: casename, 
				   citation:citation, 
				   judge_name: judge_name, 
				   court_name:court_name, 
				   casenumber:casenumber, 
				   year:year, 
				   bench:bench, 
				   facts_of_case:facts_of_case, 
				   status:status
				},
				success : function(data) {
					
				}
			});

		}
	}

	function ajaxCreateCitation(){
		
		var citation = $("#citation").val();
		var casename = $("#casename").val();
		if(citation != '' && casename !='')
		{
			casename  = $("#casename").val();
			citation = $("#citation").val();
			var judge_name = $("#judge_name").val();
			var court_name = $("#court_name").val();
			var casenumber = $("#casenumber").val();
			var year = $("#year").val();

			var bench = $("#bench").val();
			var facts_of_case = tinymce.get('facts_of_case').getContent(); //$("#facts_of_case").val();
			var status = $("#status").val();
			var notationid = $("#ntype").val();

			$(".blockUIOverlay").show();
    		$(".blockUILoading").show();

			$.ajax({
				url : 'notation/autoSave',
				dataType: "text",
				method: 'post',
				data: {
				   casename: casename, 
				   citation:citation, 
				   judge_name: judge_name, 
				   court_name:court_name, 
				   casenumber:casenumber, 
				   year:year, 
				   bench:bench, 
				   facts_of_case:facts_of_case, 
				   status:status, 
				   notationid:notationid
				},
				success: function( msg ) {
					//alert(msg);
					$("#ntype").val(msg);
					//clearInterval(interval);
				}
			});
			$(".blockUIOverlay").hide();
    		$(".blockUILoading").hide();
		}
	}

	$(document).on('change','#court_type',function(){
		$("#court_name").val('');	
	});

	/*
	$(document).on('change','#casename',function(){
		if($("#casename").val() != "")
		{
			$.ajax({
				url : 'notation/caseNameAvailable',
				dataType: "json",
				method: 'post',
				data: {
				   casename: $("#casename").val(),
				},
				success: function( data ) {
					if(data == "false"){
						$("#casename").val('');
						$("#ntype").val('');
					}
				}
			});	
		}
	});
	*/	
	$(document).on('keyup.autocomplete','#casename',function(){
		var casename = $(this).val();
		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : 'notation/fetchcasename',
					dataType: "json",
					method: 'post',
					data: {
					   casename: casename
					},
					 success: function( data ) {
						 response( $.map( data, function( item ) {
							return {
								label: item,
								value: item,
								data : item
							}
						}));
					}
				});
			},
			autoFocus: true,	      	
			minLength: 2
		});
	});

	$(document).on('keyup.autocomplete','#year',function(){
		var year = $(this).val();
		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : 'notation/fetchYear',
					dataType: "json",
					method: 'post',
					data: {
					   year: year
					},
					 success: function( data ) {
						 response( $.map( data, function( item ) {
							return {
								label: item,
								value: item,
								data : item
							}
						}));
					}
				});
			},
			autoFocus: true,	      	
			minLength: 1
		});
	});
	/*
	$(document).on("keyup.autocomplete","#citation",function(e){

	       var term =  $(this ).val();
	       $( this ).autocomplete({
    	   source : function( request, response ) {
            $.ajax({
                url: 'notation/fetchAllCitation',
                dataType: "json",
                data: {term: extractLast(term)},
                success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.citation,
                                 //email: item.email
                                };
                        }));
                    }
                });
            },
			focus : function() {
				// prevent value inserted on focus
				return true;
			},
			select : function(event, ui) {
				var terms = split( this.value );
			      // remove the current input
			      terms.pop();
			      // add the selected item
			      terms.push( ui.item.value );
			      // add placeholder to get the comma-and-space at the end
			      terms.push( "" );
			      this.value = terms.join( ", " );
			     
			      //setSubject(this.value);
			      return false;

			},
	      minLength: 2

	    });

	});
	*/

	/*
	$(document).on('blur','#citation',function(){
		if($("#citation").val() != "")
		{
			$.ajax({
				url : 'notation/citationAvailable',
				dataType: "json",
				method: 'post',
				data: {
				   citation: $("#citation").val(),
				},
				success: function( data ) {
					if(data == "false"){
						$("#citation").val('');
						$("#ntype").val('');
					}
					
				}
			});	
		}
	});
	*/
	/*
	$(document).on("keyup.autocomplete",".autocomplete_citation",function(e){

	       var term =  $(this).val();
	       $( this ).autocomplete({
    	   source : function( request, response ) {
            $.ajax({
                url: 'notation/fetchAllCitation',
                dataType: "json",
                data: {term: extractLast(term)},
                success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.citation,
                                 //email: item.email
                                };
                        }));
                    }
                });
            },
			focus : function() {
				// prevent value inserted on focus
				return false;
			},
			select : function(event, ui) {
				var terms = split( this.value );
			      // remove the current input
			      terms.pop();
			      // add the selected item
			      terms.push( ui.item.value );
			      // add placeholder to get the comma-and-space at the end
			      terms.push( "" );
			      this.value = terms.join( ", " );
			     
			      //setSubject(this.value);
			      return false;

			},
	      minLength: 2

	    });
	});
	*/

	function viewCitation(notationid)
	{
		window.open('<?php echo base_url('user/viewnotation');?>'+'?nid='+notationid, '_blank')
	}

	$(document).on('click', '#saveStatuate', function(e) {
		var errorMessage = '';
		if ( $("#statuateName").val() == ""  || $("#statuateName").val() == null) {
			errorMessage = errorMessage + 'Name cannot be empty!!\n' ;
		}

		if ( $("#statuateDes").val() == ""  || $("#statuateDes").val() == null) {
			errorMessage = errorMessage + 'Description cannot be empty!!\n' ;
		}

		if ( errorMessage != "" ) {
			alert(errorMessage);
			return;
		}

		$.ajax({
			url : '../admin/listofstatuate/insertStatuate',
			type : 'POST',
			async: false,
			cache: false,
			data : {
			  	statuatename: $("#statuateName").val(),
			  	description: $("#statuateDes").val()
			},
			success: function(dat) {
							  	
			  	$("#statuateName").val('');
			  	$("#statuateDes").val('');
			  	$("#todoModal").modal('hide');
			  	$('#statuatename')
				    .find('option')
				    .remove()
				    .end()
				    .append('<option value="">Select</option>');

				$.ajax({
					url : '../admin/listofstatuatesubsection/fetchUserListOfStatuateSubSection',
					type : 'POST',
					async: false,
					cache: false,
					dataType: "json",
					success: function(data) {
						$.each(data, function(key, item) {
						    
						    $('#statuatename').append($('<option>', { 
						        value: item.STID,
						        text : item.DESCRIPTION 
						    }));
						});
					}
				});
			}
		});
	});
	
	/*Concept function begin*/
	$(document).on('click', '#saveConcept', function(e) {
		var errorMessage = '';

		if ( $("#constatuate").val() == ""  || $("#constatuate").val() == null) {
			errorMessage = errorMessage + 'Statuate cannot be empty!!\n' ;
		}

		/*
		if ( $("#conceptsubsection").val() == ""  || $("#conceptsubsection").val() == null) {
			errorMessage = errorMessage + 'Subsection cannot be empty!!\n' ;
		}
		*/

        var si = $('.tableNewConcept tr').length - 1;
        
        var temp = [];
        for(i=1;i<=si;i++)
        {
        	var conceptcontrol = "#conceptName_"+i;
        	if ( $(conceptcontrol).val() == ""  || $(conceptcontrol).val() == null) {
            	continue;
        	}
        	temp.push($(conceptcontrol).val());
        }

        if(temp.length == 0)
		{
			errorMessage = errorMessage + 'Concept should not be empty!!\n' ;
		}


		if ( errorMessage != "" ) {
			alert(errorMessage);
			return;
		}

		$.ajax({
			url : '../admin/listofconcept/insertConcept',
			type : 'POST',
			async: false,
			cache: false,
			data : {
			  	statuate: $("#hiddenconceptstatuate").val(),
			  	subsection: $("#hiddenconceptsubsection").val(),
			  	concept: temp.join(",")
			},
			success: function(dat) {
							  	
			  	$("#constatuate").val('');
			  	$("#conceptsubsection").val('');

			  	$("#hiddenconceptstatuate").val('');
			  	$("#hiddenconceptsubsection").val('');
			  	$("#conceptName_1").val('');

            	for(j=2;j<=si;j++)
		        {
		        	var rowtr = "#rowcon_"+j;
		        	$(rowtr).remove();
		        }

			  	$("#conceptModal").modal('hide');
			}
		});
	});
	/*Concept function end*/
	/*
	$(document).on('click', '#saveConcept', function(e) {
		var errorMessage = '';

		if ( $("#conceptName").val() == ""  || $("#conceptName").val() == null) {
			errorMessage = errorMessage + 'Name cannot be empty!!\n' ;
		}

		if ( $("#conceptDescription").val() == ""  || $("#conceptDescription").val() == null) {
			errorMessage = errorMessage + 'Description cannot be empty!!\n' ;
		}


        var si = $('.tableNewConcept tr').length - 1;
        
        var temp = [];
        for(i=1;i<=si;i++)
        {
        	var conceptcontrol = "#hiddenconceptstatuate_"+i;
        	if ( $(conceptcontrol).val() == ""  || $(conceptcontrol).val() == null) {
            	continue;
        	}
        	temp.push($(conceptcontrol).val());
        }

        if(temp.length == 0)
		{
			errorMessage = errorMessage + 'Statuate should not be empty!!\n' ;
		}


		if ( errorMessage != "" ) {
			alert(errorMessage);
			return;
		}

		$.ajax({
			url : '../admin/listofconcept/insertConcept',
			type : 'POST',
			async: false,
			cache: false,
			data : {
			  	conceptname: $("#conceptName").val(),
			  	description: $("#conceptDescription").val(),
			  	statuate: temp.join(",")
			},
			success: function(dat) {
							  	
			  	$("#conceptName").val('');
			  	$("#description").val('');

			  	$("#rhiddenconceptstatuate_1").val('');
			  	$("#conceptstatuate_1").val('');
			  	$("#conceptsubsection_1").val('');

            	for(j=2;j<=si;j++)
		        {
		        	var rowtr = "#rowcon_"+j;
		        	$(rowtr).remove();
		        }

			  	$("#conceptModal").modal('hide');
			}
		});
	});
	*/
	$(document).on('blur','#statuateName',function(){
		if($("#statuateName").val() != '')
		{
			$.ajax({
				url : '../admin/listofstatuate/checkStatuateNameAvailable',
				dataType: "json",
				method: 'post',
				data: {
				   statuatename: $("#statuateName").val(),
				},
				success: function( data ) {
					//alert(data);
					if(data=="true"){
						$("#statuateAction").css("display","block");
					}
					else{
						$("#statuateAction").css("display","none");	
					}
				}
			});
		}
	});

	$(document).on('blur','#subsectionname',function(){
		if($("#subsectionname").val() != '')
		{
			$.ajax({
				url : '../admin/listofstatuatesubsection/checkSubsectionStatuateNameAvailable',
				dataType: "json",
				method: 'post',
				data: {
				   'statuatename':$("#statuatename").val(), 'subsectionname':$("#subsectionname").val()
				},
				success: function( data ) {
					
					if(data=="true"){
                    
                        $("#description").prop('disabled',false);
                        //$("#proceedButton").css("display","block");
                        $("#subsectionname").css("border","1px solid #ccc");
                        $("#subsectionname").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                        $("#subsectionAction").css("display","block");
                    }
                    else{
                    	$("#description").val('');
                    	$("#description").prop('disabled',true);
                        $("#subsectionname").css("border","1px solid #c7254e");
                        $("#subsectionname").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                        $("#subsectionAction").css("display","none");	
                    }
				}
			});
		}
	});

	$('#saveSubsection').click(function () {

        var errorMessage = '';
        if ( $("#statuatename").val() == ""  || $("#statuatename").val() == null) {
            errorMessage = errorMessage + 'Statuate name cannot be empty!!\n' ;
        }
        
        var si = $('.tableNewSubSection tr').length - 1;
        
        var temp = [];
        for(i=1;i<=si;i++)
        {
        	var subcontrol = "#subsectionname_"+i;
        	if ( $(subcontrol).val() == ""  || $(subcontrol).val() == null) {
            	continue;
        	}
        	temp.push($(subcontrol).val());
        }

        if(temp.length == 0)
		{
			errorMessage = errorMessage + 'Sub Section should not be empty!!\n' ;
		}

        /*if ( $("#subsectionname").val() == ""  || $("#subsectionname").val() == null) {
            errorMessage = errorMessage + 'Name cannot be empty!!\n' ;
        }
        if ( $("#description").val() == ""  || $("#description").val() == null) {
            errorMessage = errorMessage + 'Description cannot be empty!!\n' ;
        }
        */

        if ( errorMessage != "" ) {
            alert(errorMessage);
            return;
        }

        //$("#modalValidate").modal('hide');
        
        $.ajax({
            type: 'post',
            dataType: "json",
            url: '../admin/listofstatuatesubsection/insertSubSection',
            data: {'statuatename':$("#statuatename").val(),'subsectionname':temp.join(",")},
            success:function(data){
            	$("#statuatename").val('');
            	$("#rowss_1").val('');

            	for(j=2;j<=si;j++)
		        {
		        	var rowtr = "#rowss_"+j;
		        	$(rowtr).remove();
		        }
                $("#modalValidate").modal('hide');
            }
        });
    });
	
	$( "#conceptName" ).blur(function() {
        $.ajax({
            type: 'post',
            dataType: "json",
            url: '../admin/listofconcept/checkConceptNameAvailable',
            data: {'conceptname':$("#conceptName").val()},
            success:function(data){
                //alert(data);
                if(data=="true"){
                    $("#conceptDescription").prop('disabled',false);
                    //$("#proceedButton").css("display","block");
                    $("#conceptName").css("border","1px solid #ccc");
                    $("#conceptName").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    $("#conceptAction").css("display","block");
                }
                else{
                    $("#conceptDescription").prop('disabled',true);
                    $("#conceptName").css("border","1px solid #c7254e");
                    $("#conceptName").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    $("#conceptAction").css("display","none");
                }
            }
        });
    });

	</script>
</body>
</html>