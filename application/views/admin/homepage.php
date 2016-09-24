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

    <title>Admin Homepage</title>
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
    <!-- Custom CSS -->
    
	<!-- Custom Fonts -->
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" />
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	
	<style>
			
		.tab-pane{
			margin-top: 10px;
		}
	</style>
</head>

<body>
    <div class="container-fluid">
		<?php  $this->load->view('includes/defaultconfiguration');?>
		
		<div id="page-wrapper" class="titleClass">
				<div class="row">
					<div class="col-lg-12">
						<div style="margin-left:30px;margin-bottom:10px;">
							<!--<a href="<?php echo site_url('user/notation');?>" class="btn btn-large btn-success">Add Notation</a>-->
						</div>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
				<div class="row-fluid">
					<div class="span12">
						<div id="rootwizard">
							<ul class="nav nav-pills">
								<li id="draftNotation" class="active"><a href="#tab1" data-toggle="tab">Draft Notation</a></li>
								<li id="userNotation" class=""><a href="#tab2" data-toggle="tab">Notation List</a></li>
								<!--<li id="editedNotation" class=""><a href="#tab3" data-toggle="tab">Notation Edited by Users</a></li>-->
								<li class=""><a href="#tab4" data-toggle="tab">Reported Errors/Comments</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab1">
									<div class="panel panel-info">
										<div class="panel-heading">Draft Notation List</div>
										<div class="panel-body">
											<table id="example" class="display" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th width="5%">
														<input id="checkAllDraft" checked value="1" type="checkbox"></th>
														<th>Case Name</th>
														<th>Citation</th>
														<th>Court Name</th>
														<th>Type</th>
														<th>Owner</th>
														<!--<th>Action</th>-->
													</tr>
												</thead>
												
											</table>
										</div>
										<div class="panel-footer" id="divDraftFooter">
											<button style='margin-left:10px;' type='button' class='btn btn-info btnDraft'> Accept Draft</button>

											<button style='margin-left:10px;' type='button' class='btn btn-warning btnDelete'> Delete</button>

										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab2">
									<div class="panel panel-success">
										<div class="panel-heading">User Notation</div>
										<div class="panel-body">
											<table id="notationlist" class="display" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th width="5%">
														<input id="checkAllNotation" checked value="1" type="checkbox"></th>
														<th>Case Name</th>
														<th>Citation</th>
														<th>Case Number</th>
														<th>Type</th>
														<th>Owner</th>
													</tr>
												</thead>
												
											</table>
										</div>
										<div class="panel-footer" id="divNotationFooter">
											<button style='margin-left:10px;' type='button' class='btn btn-info btnSaveAsDraft'> Mark Edit Copy</button>

											<button style='margin-left:10px;' type='button' class='btn btn-success btnDbVersion'> Make DB Version</button>

											<button style='margin-left:10px;' type='button' class='btn btn-danger btnPublic' > Make Public</button>

											<button style='margin-left:10px;' type='button' class='btn btn-warning btnNotationDelete'> Delete</button>

										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab3">
									Third
								</div>
								<div class="tab-pane" id="tab4">
									Fourth
								</div>
							</div>
						</div>
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
	

	
	<!-- Bootstrap Wizard JavaScript -->
    <script src="<?php echo base_url();?>assets/bootstrap/bootstrap-wizard.js"></script>
	
	<!-- Prettify JavaScript -->	
	<script src="<?php echo base_url();?>assets/prettify/run_prettify.js"></script>

	<script src="<?php echo base_url();?>assets/calc/auto.js"></script>
	<script src="<?php echo base_url();?>assets/datatables/js/jquery.dataTables.js"></script>
	
	<!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/metisMenu/dist/metisMenu.min.js"></script>
	
	
	<script>
	var table;
	var notationlist;

	$(document).ready(function() {

		$("[rel='tooltip'], .tooltip").tooltip();

		$('#rootwizard').bootstrapWizard({'tabClass': 'nav nav-pills'});	
		window.prettyPrint && prettyPrint();
	
		var tabSelection = "#"+$("#tabVal").val();
		//$(".nav-pills>li.active").removeClass("active");
		//$(tabSelection).addClass('active');
		fnDraftNotationList();
		fnNotationList();
		/*
        $(".btnDbVersion").click(function(){
        	alert($(this).val());
        	
        	$.ajax({
				url : 'notation/dbVersion',
				dataType: "text",
				method: 'post',
				data: {
				   hashid: $("#hashid").val()
				},
				success : function(data) {
					fnNotationList();
				}
			});
        });*/

	});

	/*
	$(document).on('click', '.btnDbVersion', function(e) {
		//alert($(this).val());
		$.ajax({
			url : '../user/notation/changeDbVersion',
			dataType: "text",
			method: 'post',
			data: {
			   hashid: $(this).val()
			},
			success : function(data) {
				fnNotationList();
			}
		});
	});
	*/

	$(document).on('click', '.btnDbVersion', function(e) {
		var temp = [];
        $.each($("input[class='chkNotationbox']:checked"), function(){            
            temp.push($(this).val());
        });

        if(temp.length > 0){
        	$.ajax({
				url : '../user/notation/changeDbVersion',
				dataType: "text",
				method: 'post',
				data: {
				   hashid: temp.join(",")
				},
				success : function(data) {
					fnNotationList();
				}
			});
        }
        else
        	alert("No notation is selected");
	});

	$(document).on('click', '.btnPublic', function(e) {
		var temp = [];
        $.each($("input[class='chkNotationbox']:checked"), function(){            
            temp.push($(this).val());
        });

        if(temp.length > 0){
			$.ajax({
				url : '../user/notation/changePublicVersion',
				dataType: "text",
				method: 'post',
				data: {
				   hashid: temp.join(",")
				},
				success : function(data) {
					fnNotationList();
				}
			});
		}
        else
        	alert("No notation is selected");
	});

	/*
	$(document).on('click', '.btnDraft', function(e) {
		//alert($(this).val());
		$.ajax({
			url : '../user/notation/changeDraftVersion',
			dataType: "text",
			method: 'post',
			data: {
			   hashid: $(this).val()
			},
			success : function(data) {
				fnDraftNotationList();
			}
		});
	});
	*/

	/*
	$(document).on('click', '.btnDelete', function(e) {
		var x = confirm("Are you sure you want to delete?");
		if (x)
		{
		    $.ajax({
				url : '../user/notation/deleteNotation',
				dataType: "text",
				method: 'post',
				data: {
				   hashid: $(this).val()
				},
				success : function(data) {
					fnNotationList();
				}
			});
		}
		else
		{
		    return false;
		}
	});
	*/

	$(document).on('click', '.btnDraft', function(e) {
		var temp = [];
        $.each($("input[class='chkbox']:checked"), function(){            
            temp.push($(this).val());
        });

        if(temp.length > 0){
        	$.ajax({
				url : '../user/notation/changeDraftVersion',
				dataType: "text",
				method: 'post',
				data: {
				   hashid: temp.join(",")
				},
				success : function(data) {
					fnDraftNotationList();
					fnNotationList();
				}
			});
        }
        else
        	alert("No notation is selected!!!")
	});

	$(document).on('click', '.btnSaveAsDraft', function(e) {
		var temp = [];
        $.each($("input[class='chkNotationbox']:checked"), function(){            
            temp.push($(this).val());
        });

        if(temp.length > 0){
			$.ajax({
				url : '../user/notation/changeEditCopyVersion',
				dataType: "text",
				method: 'post',
				data: {
				   hashid: temp.join(",")
				},
				success : function(data) {
					fnDraftNotationList();
				}
			});
		}
		else
        	alert("No notation is selected!!!")
	});

	$(document).on('click', '.btnDelete', function(e) {
		var x = confirm("Are you sure you want to delete?");
		if (x)
		{
			var temp = [];
	        $.each($("input[class='chkbox']:checked"), function(){            
	            temp.push($(this).val());
	        });

	        if(temp.length > 0){
			    $.ajax({
					url : '../user/notation/deleteNotation',
					dataType: "text",
					method: 'post',
					data: {
					   hashid: temp.join(",")
					},
					success : function(data) {
						fnDraftNotationList();
						fnNotationList();
					}
				});
			}
	        else
	        	alert("No notation is selected!!!")
		}
		else
		{
		    return false;
		}
	});

	$(document).on('click', '.btnNotationDelete', function(e) {
		var x = confirm("Are you sure you want to delete?");
		if (x)
		{
			var temp = [];
	        $.each($("input[class='chkNotationbox']:checked"), function(){            
	            temp.push($(this).val());
	        });

	        if(temp.length > 0){
			    $.ajax({
					url : '../user/notation/deleteNotation',
					dataType: "text",
					method: 'post',
					data: {
					   hashid: temp.join(",")
					},
					success : function(data) {
						fnDraftNotationList();
						fnNotationList();
					}
				});
			}
	        else
	        	alert("No notation is selected!!!")
		}
		else
		{
		    return false;
		}
	});

	function fnNotationList()
	{
		$('#notationlist').dataTable().fnDestroy();
        notationlist = $('#notationlist').DataTable({
            "ajax": "homepage/fetchUserNotation",
            "columnDefs": [
                        { 
                            "visible": false
                        }
                    ],
            "columns": [
               { "data": "notation" },  
               { "data": "casename" },  
               { "data": "citation" },  
               //{ "data": "date_of_creation" },
               { "data": "case_number" },
               { "data": "type" },
               { "data": "owner" }
            ],
            "initComplete": function(settings, json) {
            	var cntTable = $(this).DataTable();
	            var info = cntTable.page.info()
	            if(info.recordsTotal>0)
	            {
	            	$("#divNotationFooter").css("display","block");

	            	$("#checkAllNotation").prop("checked",false);
                	$("#checkAllNotation").prop("disabled",false);
	            }
	            else
	            {
	            	$("#divNotationFooter").css("display","none");

	            	$("#checkAllNotation").prop("checked",false);
                	$("#checkAllNotation").prop("disabled",true);
	            }
            }
        });

	}

	function fnDraftNotationList()
	{
		$('#example').dataTable().fnDestroy();
        table = $('#example').DataTable({
            "ajax": "homepage/fetchDraftNotation",
            "columnDefs": [
                        { 
                            "visible": false
                        }
                    ],
            "columns": [
               { "data": "notation" },  
               { "data": "casename" },  
               { "data": "citation" },  
               { "data": "case_number" },
               { "data": "type" },
               { "data": "owner" }
               //{ "data": "action" }
            ],
            "initComplete": function(settings, json) {
            	var cntTable = $(this).DataTable();
	            var info = cntTable.page.info()
	            if(info.recordsTotal>0)
	            {
	            	$("#divDraftFooter").css("display","block");

	            	$("#checkAllDraft").prop("checked",false);
                	$("#checkAllDraft").prop("disabled",false);
	            }
	            else
	            {
	            	$("#divDraftFooter").css("display","none");

	            	$("#checkAllDraft").prop("checked",false);
                	$("#checkAllDraft").prop("disabled",true);
	            }
            }
        });
	}


	$(document).on('change', '#checkAllDraft', function() {
        if(this.checked)
        {
            $("input[class='chkbox']").prop('checked', $(this).prop("checked"));
        }
        else
        {
            $("input[class='chkbox']").prop('checked', $(this).prop("checked"));
        }
    });

    $(document).on('change', '#checkAllNotation', function() {
        if(this.checked)
        {
            $("input[class='chkNotationbox']").prop('checked', $(this).prop("checked"));
        }
        else
        {
            $("input[class='chkNotationbox']").prop('checked', $(this).prop("checked"));
        }
    });
	</script>
</body>

</html>