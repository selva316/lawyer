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

    <title>Research Topic</title>
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
							<button type="button" class="btn btn-large btn-success" id="finalize" data-toggle="modal" data-target="#modalValidate" > Add Research <i class="fa fa-close"></i> </button>
						</div>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
				<div class="panel panel-info">
					<div class="panel-heading">Research Topic</div>
					<div class="panel-body">
						<table id="researchList" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th width="5%">
                                    <input id="checkAllResearch" value="1" type="checkbox"></th>
									<th>Topic Name</th>
									<th>Belongs To</th>
									<th>Date</th>
									<th>Assign To</th>
									<th>Action</th>
								</tr>
							</thead>
							
						</table>
					</div>
					<div class="panel-footer" id="divFooter">
                        <button style='margin-left:10px;' type='button' class='btn btn-warning disableResearch'> Delete</button>
                    </div>
				</div>
			</div>
			<!-- /#page-wrapper -->

			<div class="modal fade" id="modalValidate" style="margin-top:5%;">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">New Research Topic</h4>
              </div>
              <div class="modal-body">
                
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Name</label>
                        <input  class="form-control" type="text" id="topicname" name="topicname" value=""/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Assign To</label>
                        <input  class="form-control" type="text" id="assignTo" name="assignTo" value=""/>
                    </div>
                </div>

                <div class="clearfix"><br></div>
                <div class="center modalButton"  style="text-align:center;">
                  <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                  <button type="button" class="btn btn-primary nonEisValidate" data-dismiss="modal" name="proceedButton" id="proceedButton">Save</button>
                </div>
                <div class="clearfix"></div>
              </div>
          </div><!--/.modal-content -->
          </div><!--/.modal-dialog -->
        </div> <!--/.modal -->

        <!--Begin Research Topic modal -->
		<div class="modal fade" id="researchModal"  style="margin-top:5%;">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Research Topic</h4>
              </div>
              <div class="modal-body">
                
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Name</label>
                        <input  class="form-control" type="text" id="edittopicname" name="edittopicname" value=""/>
                        <input  class="form-control" type="hidden" id="researchid" name="researchid" value=""/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Assign To</label>
                        <input  class="form-control" type="text" id="editassignTo" name="editassignTo" value=""/>
                    </div>
                </div>

                <div class="clearfix"><br></div>
                <div class="center modalButton"  style="text-align:center;">
                  <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                  <button type="button" class="btn btn-primary nonEisValidate" data-dismiss="modal" name="updateButton" id="updateButton">Update</button>
                </div>
                <div class="clearfix"></div>
              </div>
          </div><!--/.modal-content -->
          </div><!--/.modal-dialog -->
        </div> 
        <!--End Research Topic modal -->

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

		$( "#topicname" ).blur(function() {
            $.ajax({
                type: 'post',
                dataType: "json",
                url: 'research/checkTopicAvailable',
                data: {'topicname':$("#topicname").val()},
                success:function(data){
                    //alert(data);
                    if(data=="true"){
                        $("#assignTo").prop('disabled',false);
                        //$("#proceedButton").css("display","block");
                        $("#topicname").css("border","1px solid #ccc");
                        $("#topicname").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    }
                    else{
                        $("#topicname").css("border","1px solid #c7254e");
                        $("#topicname").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    }
                }
            });
        });

		$('#proceedButton').click(function () {
			//if($("#topicname").val != "" && $("#assignTo").val()!="")
			if($("#topicname").val != "")
			{
		        $.ajax({
		            type: 'post',
		            dataType: "json",
		            url: 'research/insertReseaarchTopic',
		            data: {'topicname':$("#topicname").val(),'assignTo':$("#assignTo").val()},
		            success:function(data){
		                //window.location.href="homepage";                
		                fnResearchCalling();
		                $("#topicname").val('');
		                $("#assignTo").val('');
		            }
		        });
			}
			else
			{
				alert("Topic name should not empty");
			}
	    });

		$('#updateButton').click(function () {
			if($("#edittopicname").val != "")
			{
		        $.ajax({
		            type: 'post',
		            dataType: "json",
		            url: 'research/updateReseaarchTopic',
		            data: {'topicname':$("#edittopicname").val(),'assignTo':$("#editassignTo").val(), 'rid':$("#researchid").val()},
		            success:function(data){
		                //window.location.href="homepage";                
		                fnResearchCalling();
		                $("#edittopicname").val('');
		                $("#editassignTo").val('');
		            }
		        });
			}
			else
			{
				alert("Topic name should not empty");
			}
	    });

		$('#editassignTo').tokenfield({
			autocomplete: {
			  	//source: ['red','blue','green','yellow','violet','brown','purple','black','white','red','blue','green','yellow','violet','brown','purple','black','white'],
			  	source: function( request, response ) {
	             $.ajax({
	                 url: "research/fetchUsers",
	                 dataType: "json",
	                 data: {term: request.term},
	                 success: function(data) {
	                        response($.map(data, function(item) {
	                             return {
	                                 label: item.fullname,
	                                 id: item.userid
	                                };
	                         }));
	                     }
	                 });
	            },
			  delay: 100,
			  minLength: 2
			},
			showAutocompleteOnFocus: true,
			delimiter: '!'
		});

		$('#assignTo').tokenfield({
			autocomplete: {
			  	//source: ['red','blue','green','yellow','violet','brown','purple','black','white','red','blue','green','yellow','violet','brown','purple','black','white'],
			  	source: function( request, response ) {
	             $.ajax({
	                 url: "research/fetchUsers",
	                 dataType: "json",
	                 data: {term: request.term},
	                 success: function(data) {
	                        response($.map(data, function(item) {
	                             return {
	                                 label: item.fullname,
	                                 id: item.userid
	                                };
	                         }));
	                     }
	                 });
	            },
			  delay: 100,
			  minLength: 2
			},
			showAutocompleteOnFocus: true,
			delimiter: '!'
		});

	});
	
	$(document).on('change', '#checkAllResearch', function() {
        if(this.checked)
        {
            $("input[class='chkbox']").prop('checked', $(this).prop("checked"));
        }
        else
        {
            $("input[class='chkbox']").prop('checked', $(this).prop("checked"));
        }
    });

	$(document).on('click','.viewResearchTopic', function(){
		var rid = $(this).val();
		window.open(
		  "<?php echo site_url('user/researchList')?>/?rid="+rid,
		  '_blank' // <- This is what makes it open in a new window.
		);
	});

	$(document).on('click','.editResearchGroup',function(){
			//var rid = $(this).val();
			var rid = $(this).data('type');
			
		    $.ajax({
		    	type:"POST",
		       url: "research/researchTopic",
		       dataType: "json",
		       data:{rid:rid},
		       success: function(data) {
		        	//alert(data.topic)  
		            console.log(data.name)
		            $('#editassignTo').tokenfield('setTokens', data.name);
		            $("#edittopicname").val(data.topic);
		            $("#researchid").val(rid);
		            //$('#userName').tokenfield('createToken', data.name);
		           }
		    });
			

		$("#researchModal").modal('show');
	});

	$(document).on('click', '.disableResearch', function(e) {
        var temp = [];
        $.each($("input[class='chkbox']:checked"), function(){            
            temp.push($(this).val());
        });

        if(temp.length > 0){
            $.ajax({
                url: 'research/disableResearch',
                dataType: "json",
                method: 'post',
                data: {
                   rid: temp.join(",")
                },
                success : function(data) {
                    fnResearchCalling();
                }
            });
        }
        else
            alert("No topic is selected!!!")
    });

	function fnResearchCalling()
	{
		$('#researchList').dataTable().fnDestroy();
        table = $('#researchList').DataTable({
            "ajax": "research/fetchResearchTopic",
            "columnDefs": [
                        { 
                            "visible": false
                        }
                    ],
            "columns": [
               { "data": "rid" },  
               { "data": "topic" },  
               { "data": "belongs_to" },  
               { "data": "timestamp" },
               { "data": "assign" },
               { "data": "action" }
            ],
            "initComplete": function(settings, json) {
                var cntTable = $(this).DataTable();
                var info = cntTable.page.info()
                if(info.recordsTotal>0)
                {
                    $("#divFooter").css("display","block");
                    $("#checkAllResearch").prop("checked",false);
                    $("#checkAllResearch").prop("disabled",false);
                }
                else
                {
                    $("#divFooter").css("display","none");
                    $("#checkAllResearch").prop("checked",false);
                    $("#checkAllResearch").prop("disabled",true);
                }
            }
        });
	}


	</script>
</body>

</html>