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

    <title>Research Notation</title>
    <!-- jQuery UI CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/jquery/css/jquery-ui.min.css" />
	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/dist/css/bootstrap.min.css" />
	<!-- Bootstrap Responsive CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/bootstrap-responsive.min.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/jquery/css/datepicker.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/datatables/css/jquery.dataTables.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/tokenfield/bootstrap-tokenfield.css" />
	
	<!-- MetisMenu CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/metisMenu/dist/metisMenu.min.css" />
	
	<link rel="stylesheet" href="<?php echo base_url();?>assets/menu/css/menu.css" />
	
    <!-- Timeline CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>dist/css/timeline.css" />
    <!-- Custom CSS -->
    
	<!-- Custom Fonts -->
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" />
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	
	<style>
		.ui-autocomplete {
			z-index: 9999;
		}
		/*
		.tokenfield{
		  height:100px;
		  width:100%; 
		  float:left;
		  border: 3px solid #66afe9;
		  z-index: 11001;
		}*/
		#mceu_29-0{
			display: none;
		}
	</style>
</head>

<body>
    <div class="container-fluid">
		<?php $this->load->view('includes/defaultconfiguration');?>
		<!--<div class="panel panel-success titleClass">
		<div class="panel-heading">
			<center><label><b>Research Topic</b></label></center></div>
		</div>	-->	
		<div id="page-wrapper" class="titleClass">
				<div class="row">
					<div class="col-lg-12">
						<div style="margin-left:30px;margin-bottom:10px;">
							<!--<a href="<?php echo site_url('user/notation');?>" class="btn btn-large btn-success">Add Research</a>-->
							<input type="hidden" name="researchid" id="researchid" value="<?php echo $researchid;?>" />
						</div>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
				<div class="panel panel-info">
					<div class="panel-heading">Research Notation</div>
					<div class="panel-body">
						<table id="researchList" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Case Name</th>
									<th>Citation</th>
									<th>Case Number</th>
									<th>Type</th>
									<th>Owner</th>
								</tr>
							</thead>
							
						</table>
					</div>
					
				</div>
			</div>
			<!-- /#page-wrapper -->

		</div>
		<!-- /#wrapper -->
    </div>
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
	<script src="<?php echo base_url();?>assets/tokenfield/bootstrap-tokenfield.js"></script>
	<!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/metisMenu/dist/metisMenu.min.js"></script>
	
	
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>dist/js/sb-admin-2.js"></script>
	<script>
	$(document).ready(function() {
		var table;
		var notationlist;
		fnResearchCalling();
	});

	function fnResearchCalling()
	{
		
		$('#researchList').dataTable().fnDestroy();
        table = $('#researchList').DataTable({
            "ajax":{
	            "type" : "POST",
	            "url":"fetchResearchNotation",
	            "data":{'researchid': $("#researchid").val()}
	        },
            "columnDefs": [
                        { 
                            "visible": false
                        }
                    ],
            "columns": [
               { "data": "casename" },  
               { "data": "citation" },  
               { "data": "case_number" },
               { "data": "type" },
               { "data": "owner" }
            ]
        });
        
	}

	</script>
</body>

</html>