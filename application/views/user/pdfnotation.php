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

    <title>View Notation</title>
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
		.ui-autocomplete {
			z-index: 9999;
		}

		#mceu_29-0{
			display: none;
		}
	</style>
</head>

<body>
    <div class="container-fluid">
    	<?php $this->load->view('includes/defaultconfiguration');?>

		<!--<div class="panel panel-success">
			<div class="panel-heading">
				<center><label><b>View Notation</b></label></center>
			</div>
		</div>	-->	
		<div id="page-wrapper" style="margin: auto 20px;">
			<div class="panel panel-info">
                <div class="panel-heading">Case Information</div>
                <div class="panel-body">
            		<div class="row-fluid">
						<div class="span3">
							<label class="control-label">Case Name: <?php echo $casename; ?></label>
							<input type="hidden" name="casename" id="casename" value="<?php echo $casename; ?>"/>
							<input type="hidden" name="ntype" id="ntype" value="<?php echo $notationid; ?>"/>
							<input type="hidden" name="hashid" id="hashid" value="<?php echo $hashnotationid; ?>"/>
						</div>
						<div class="span3">
							<label class="control-label">Citation: <?php echo $citation; ?></label>
							<input type="hidden" name="citation" id="citation" value="<?php echo $citation; ?>"/>
						</div>
						<div class="span3">
							<label class="control-label">Court assigned case number: <?php echo $casenumber; ?></label>
						</div>
						<div class="span3">
							<label class="control-label">Court Name: <?php echo $court_name; ?></label>
						</div>
					</div>   

					<div class="row-fluid"  style="margin-top:20px;">
						<div class="span3">
							<label class="control-label">Judge Name: <?php echo ucfirst($judge_name); ?></label>
						</div>
						<div class="span3">
							<label class="control-label">Year of Judgement: <?php echo $year; ?></label>
						</div>
						<div class="span3">
							<label class="control-label">Type of Bench: <?php echo $bench; ?></label>
						</div>
						
						<div class="span3">
							<label  class="control-label" >Status: <?php echo ucfirst($type);?></label>
						</div>
					</div> 

					<div class="row-fluid" style="margin-top:20px;">
						<div class="span8">
							<label  class="control-label" >Notes:</label>
							<?php echo $facts_of_case; ?>
						</div>
					</div>

            	</div>
            </div>
			
			<div class="clear-both" style="margin-top:20px;"></div>

			<div class="panel panel-success">
                <div class="panel-heading">Statute and Concepts</div>
                <div class="panel-body">
                	<div class='row-fluid'>
			      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
			      			<table class="table table-bordered table-hover tableStatuate">
								<thead>
									<tr>
										<th width="2%">ID</th>
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
										<td><?php echo ($k+1); ?></td>
										<td><?php echo $statuaterow['statuate']; ?></td>
										<td><?php echo $statuaterow['sub_section']; ?></td>
										<td><?php echo $statuaterow['concept']; ?></td>
									</tr>
									<?php
										$k++;
										}
									?>
								</tbody>
							</table>
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
										<th>ID</th>
										<th>Type of Citation</th>
										<th>Citation Number</th>
										<th>Notes</th>
									</tr>
								</thead>
								<tbody>
									
									<?php 
										$k = 0;
										foreach( $citationdetails as $citationrow ){
									?>
									<tr>
										<td><?php echo ($k + 1); ?></td>
										<td><?php 
												foreach ($typeOfCitation as $row) {
													//echo $row['NAME'];
													if($citationrow['type_of_citation'] == $row['CIID'])
													{
														 echo $row['NAME'];
													}
												}
											?>
										</td>
										<td><?php echo $citationrow['actual_citation'];?> </td>
										<td><?php echo $citationrow['description'];?></td>
									</tr>
									<?php 
										$k++;
										}
									?>
								</tbody>
							</table>
								
						</div>
					</div>
            	</div>
            </div>
            <?php // print_r($this->session); ?>
            <?php if($type != 'private' && $type != 'draft'){ ?>

	            <div class="row-fluid" style="margin-bottom:10px;">
					<?php if($type != 'draft'){ ?>
					<div class="span3" style="text-align:center;">
						<button type="button" class="btn btn-primary" id="saveAsPrivate">
			                Keep Private<i class="fa fa-close"></i>
			            </button>
					</div>
					<?php } ?>
					<div class="span3" style="text-align:center;">
						<button type="button" class="btn btn-primary" id="editNotation">
			                Edit Notation<i class="fa fa-close"></i>
			            </button>
					</div>
					
					<?php if($this->session->userdata('role') == "Admin" && $type != 'dbversion') { ?>
					<div class="span3" style="text-align:center;">
						<button type="button" class="btn btn-primary" id="dbVersion">
			                Database Version<i class="fa fa-close"></i>
			            </button>
					</div>
					<?php } ?>

					<div class="span3" style="text-align:center;">
						<button type="button" class="btn btn-primary" id="tag" data-toggle="modal" data-target="#modalValidate" >
			                Tag a Notation<i class="fa fa-close"></i>
			            </button>
					</div>
				</div>
            <?php
            }
			?>      
		</div>
			
			</div>
			<!-- /#page-wrapper -->


		<div class="modal fade" id="modalValidate">
            <div class="modal-dialog">
	            <div class="modal-content">
	              <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title">Research topic to tag</h4>
	              </div>
	              <div class="modal-body">
	                
	                <div class="row-fluid">
	                    <div class="span12">
	                        <label class="control-label">Select Research Topic</label>
	                        <input  class="form-control autocomplete_tag" type="text" id="topicname" name="topicname"  autocomplete="off"  value=""/>
	                        <input  class="form-control" type="hidden" id="rid" name="rid"  autocomplete="off"  value=""/>
	                    </div>
	                </div>

					<div class="row-fluid" style="margin-top:20px;">
						<div class="span12">
							<label class="control-label">Tag Notes</label>
							<textarea id="tagNote" class="form-control myTextEditor"  placeholder="Note" name="tagNote" rows="4" cols="45"></textarea>				
						</div>
					</div>

	                <div class="clearfix"><br></div>
	                <div class="center modalButton"  style="text-align:center;">
	                  <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
	                  <button type="button" class="btn btn-primary nonEisValidate" data-dismiss="modal" name="tagButton" id="tagButton">Save</button>
	                </div>
	                <div class="clearfix"></div>
	              </div>
	            </div><!--/.modal-content -->
            </div><!--/.modal-dialog -->
        </div> <!--/.modal -->

		</div>
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
	<script src="<?php echo base_url();?>assets/datatables/js/jquery.dataTables.js"></script>
	
	<!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/metisMenu/dist/metisMenu.min.js"></script>
	
</body>

</html>
