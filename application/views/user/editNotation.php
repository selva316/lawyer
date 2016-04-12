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
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" />
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	
	<style>
		
		.navbar{
			border:none;
		}
		
		.nav {
			font-size:14px;
			padding-left:40%;
		}
	</style>
</head>

<body>
	<form name="frminvoice" action="editnotation/update" method="post" onsubmit="return frmvalidation()">
    <div class="container-fluid">
    	<?php $this->load->view('includes/defaultconfiguration');?>

		<div class="panel panel-success">
			<div class="panel-heading">
				<center><label><b>Edit Notation</b></label></center>
			</div>
		</div>		
		<div id="page-wrapper" style="margin: auto 20px;">
			<div class="panel panel-default">
                <div class="panel-heading">Case Information</div>
                <div class="panel-body">
            		<div class="row-fluid">
						<div class="span3">
							<label class="control-label">Case Name</label>
							<input  class="form-control" type="text" disabled="true" value="<?php echo $casename; ?>"/>
							<input type="hidden" name="casename" id="casename" value="<?php echo $casename; ?>"/>
							<input type="hidden" name="ntype" id="ntype" value="<?php echo $hashnotationid; ?>"/>
						</div>
						<div class="span3">
							<label class="control-label">Citation</label>
							<input  class="form-control" type="text"  disabled="true"  value="<?php echo $citation; ?>"/>
							<input type="hidden" name="citation" id="citation" value="<?php echo $citation; ?>"/>
						</div>
						<div class="span3">
							<div id="divcasenumber" class="form-group">
								<label class="control-label">Court assigned case number</label>
								<input  class="form-control" type="text" id="casenumber" name="casenumber" value="<?php echo $casenumber; ?>"/>
							</div>
							<!--<label class="control-label">Court Type</label>
							<select  class="form-control" id="court_type" name="court_type">
								<option value="">Select</option>
								<?php 
									foreach ($courtDetails as $row) {
										if($court_type == $row['SHORTNAME'])
											echo "<option selected value='".$row['SHORTNAME']."'>". $row['NAME'] ."</option>";
										else
											echo "<option value='".$row['SHORTNAME']."'>". $row['NAME'] ."</option>";
									}
								?>
							</select>-->
						</div>
						<div class="span3">
							<label class="control-label">Court Name</label>
							<input  class="form-control autocomplete_txt"  data-type="court_name" type="text" id="court_name" name="court_name" autocomplete="off" value="<?php echo $court_name; ?>"/>
						</div>
					</div>   

					<div class="row-fluid"  style="margin-top:20px;">
						<div class="span3">
							<div id="divjudge_name" class="form-group">
								<label class="control-label">Name of Judge</label>
								<input  class="form-control" type="text" id="judge_name" name="judge_name" value="<?php echo $judge_name; ?>"/>
							</div>
						</div>
						<div class="span3">
							<div id="divyear" class="form-group">
								<label class="control-label">Year of Judgement</label>
								<input  class="form-control form_datetime" type="text" id="year" name="year" value="<?php echo date('d-m-Y',$year); ?>"/>
							</div>
						</div>
						<div class="span3">
							<div id="divbench" class="form-group">
								<label class="control-label">Type of Bench</label>
								<input  class="form-control" type="text" id="bench" name="bench" value="<?php echo $bench; ?>"/>
							</div>
						</div>
						<div class="span3">
							<label  class="control-label" >Status</label>
							<select  class="form-control"  id="status" name="status">
								<option value="">Select</option>
								<?php 
									foreach ($status as $row) {
										$role = $this->session->userdata('role');
										if($type == $row['NAME'])
										{
											if(('dbversion' == $row['NAME']))
											{
												if($role == 'Admin')
													echo "<option selected value='".$row['NAME']."'>". $row['DESCRIPTION'] ."</option>";
												else
													continue;
											}
											else
												echo "<option selected value='".$row['NAME']."'>". $row['DESCRIPTION'] ."</option>";
										}
										else{
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
									}
								?>
							</select>
						</div>
					</div> 

					<div class="row-fluid" style="margin-top:20px;">
						<div class="span8">
							<textarea id="facts_of_case" class="form-control"  placeholder="Facts of Case" name="facts_of_case" rows="4" cols="45"><?php echo $facts_of_case; ?></textarea>				
						</div>
					</div>

            	</div>
            </div>
			
			<div class="clear-both" style="margin-top:20px;"></div>

			<div class="panel panel-default">
                <div class="panel-heading">Statute and Concepts</div>
                <div class="panel-body">
                	<div class='row-fluid'>
			      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
			      			<table class="table table-bordered table-hover tableStatuate">
								<thead>
									<tr>
										<th width="2%"></th>
										<th width="15%">Statute</th>
										<th width="25%">Section & Subsection</th>
										<th width="5%">Concept</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$k = 0;
										foreach( $statuatedetails as $statuaterow ){
									?>
									<tr>
										<td><input class="case" type="checkbox"/></td>
										<td><input type="text" data-type="statuate" name="statuate[]" id="statuate_<?php echo $k; ?>" class="form-control autocomplete_process" autocomplete="off" value="<?php echo $statuaterow['statuate']; ?>"></td>
										<td><input type="text" data-type="subsection" name="subsection[]" id="subsection_<?php echo $k; ?>" class="form-control autocomplete_process" autocomplete="off"  value="<?php echo $statuaterow['sub_section']; ?>" ondrop="return false;" onpaste="return false;"></td>
										<td><input type="text" data-type="concept" name="concept[]" id="concept<?php echo $k; ?>" class="form-control autocomplete_concept" autocomplete="off"  value="<?php echo $statuaterow['concept']; ?>" ondrop="return false;" onpaste="return false;"></td>
									</tr>
									<?php
										$k++;
										}
									?>
								</tbody>
							</table>
			      		</div>
		      			<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
				  			<button class="btn btn-danger delete" type="button">- Delete</button>
				  			<button class="btn btn-success addmore" type="button">+ Add More</button>
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
							<table class="table table-bordered table-hover tableCitation">
								<thead>
									<tr>
										<th></th>
										<th>Type of Citation</th>
										<th>Citation Number</th>
									</tr>
								</thead>
								<tbody>
									
									<?php 
										$k = 0;
										foreach( $citationdetails as $citationrow ){
									?>
									<tr>
										<td><input class="case_citation" type="checkbox"/></td>
										<td>
										<select  class="form-control"  data-type="typeCitation" id="typeCitation_<?php echo $k; ?>" name="typeCitation[]">
											<?php 
												foreach ($typeOfCitation as $row) {
													if($citationrow['type_of_citation'] == $row['CIID'])
														echo "<option selected value='".$row['CIID']."'>". $row['NAME'] ."</option>";
													else
														echo "<option value='".$row['CIID']."'>". $row['NAME'] ."</option>";
												}
											?>
										</select>
										</td>
										<td><input type="text" data-type="citationNumber" name="citationNumber[]" id="citationNumber_<?php echo $k; ?>"  value="<?php echo $citationrow['actual_citation']; ?>" class="form-control autocomplete_citation" autocomplete="off"></td>
										
									</tr>
									<?php 
										$k++;
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
						<button type="submit" class="btn btn-primary" id="save"  >
			                Update <i class="fa fa-close"></i>
			            </button>
			            
					</div>
				</div>
			</div>
			<!-- /#page-wrapper -->
		</div>
	</form>		
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/jquery/jquery.js"></script>
	<script src="<?php echo base_url();?>assets/jquery/jquery-ui.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/jquery/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url();?>assets/menu/js/menuscript.js"></script>
	
	<script src="<?php echo base_url();?>assets/calc/auto.js"></script>
	<script src="<?php echo base_url();?>assets/datatables/js/jquery.dataTables.js"></script>
	
	<!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/metisMenu/dist/metisMenu.min.js"></script>
	
	<script>
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
		

		$('.form_datetime').datepicker({
		    //format: 'YYYY-MM-DD',
		    dateFormat: 'dd-mm-yy',
		    autoclose : true
		});
		//setInterval(ajaxCreateCitation, 60000);
		//$("#court_name")
	});

	$(document).on('focus','.autocomplete_txt',function(){
		var type = $(this).data('type');
		var court_type = $("#court_type").val();
		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : 'notation/ajax',
					dataType: "json",
					method: 'post',
					data: {
					   name_startsWith: request.term,
					   type: type,
					   court_type:court_type
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

	$(document).on('focus','.autocomplete_concept',function(){
		var type = $(this).data('type');
		
		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : 'notation/conceptAjax',
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
	});

	
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
	});


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


	function ajaxCreateCitation(){
		
		var citation = $("#citation").val();
		var caseName = $("#casename").val();
		if(citation != '' && caseName !='')
		{
			alert(citation)
		}
	}

	$(document).on('change','#court_type',function(){
		$("#court_name").val('');	
	});

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
						$("#ntype").val();
					}
					else
					{
						$("#ntype").val("Draft");	
					}
				}
			});	
		}
	});

	$(document).on('change','#citation',function(){
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
						$("#ntype").val();
					}
					else
					{
						$("#ntype").val("Draft");	
					}
				}
			});	
		}
	});

	$(document).on('click','#save',function(){
		if($("#citation").val() != "" && $("#casename").val() !="")
		{

		}
	});
	</script>
</body>

</html>
