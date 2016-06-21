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

    <title>List of Statuate</title>
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
</head>

<body>
    <div class="container-fluid">
        <?php $this->load->view('includes/defaultconfiguration');?>
        <div class="panel panel-success">
        <div class="panel-heading">
            <center><label><b>List of Statuate</b></label></center></div>
        </div>      
        <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div style="margin-left:30px;margin-bottom:10px;">
                            <button type="button" class="btn btn-large btn-success" id="finalize" data-toggle="modal" data-target="#modalValidate" > Add Statuate <i class="fa fa-close"></i> </button>
                        </div>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="panel panel-default">
                    <div class="panel-heading">List of Statuate</div>
                    <div class="panel-body">
                        <table id="courtTypeList" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Statuate ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                </div>
                </div> 
               
            </div>
            <!-- /#page-wrapper -->

        </div>
        <div class="modal fade" id="modalValidate">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">New Statuate</h4>
              </div>
              <div class="modal-body">
                
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Name</label>
                        <input  class="form-control" type="text" id="statuatename" name="statuatename" value=""/>
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

        <!-- Edit Court Type Modal-->
        <div class="modal fade" id="modalCourtType">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Statuate</h4>
              </div>
              <div class="modal-body">
                
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Name</label>
                        <input  class="form-control" type="text" id="editStatuatename" name="editStatuatename" value=""/>
                        <input  class="form-control" type="hidden" id="editSTID" name="editSTID" value=""/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Description</label>
                        <input  class="form-control" type="text" id="editdescription" name="editdescription" value=""/>
                    </div>
                </div>

                <div class="clearfix"><br></div>
                <div class="center modalButton"  style="text-align:center;">
                  <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                  <button type="button" class="btn btn-primary nonEisValidate" data-dismiss="modal" name="editButton" id="editButton">Update</button>
                </div>
                <div class="clearfix"></div>
              </div>
          </div><!--/.modal-content -->
          </div><!--/.modal-dialog -->
        </div> <!--/.modal -->
        <!-- End Edit Court Type Modal-->

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
    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/metisMenu/dist/metisMenu.min.js"></script>
    
    
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>dist/js/sb-admin-2.js"></script>
    <script>
    var table;
    $(document).ready(function() {
        
        fnTableCalling();
        
        $( "#statuatename" ).blur(function() {
            $.ajax({
                type: 'post',
                dataType: "json",
                url: 'listofstatuate/checkStatuateNameAvailable',
                data: {'statuatename':$("#statuatename").val()},
                success:function(data){
                    //alert(data);
                    if(data=="true"){
                        $("#description").prop('disabled',false);
                        //$("#proceedButton").css("display","block");
                        $("#statuatename").css("border","1px solid #ccc");
                        $("#statuatename").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    }
                    else{
                        $("#description").prop('disabled',true);
                        $("#statuatename").css("border","1px solid #c7254e");
                        $("#statuatename").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    }
                }
            });
        });


        $( "#description" ).change(function() {
            if($(this).val() != "")
                $(".modalButton").css("display","block");
            else
                $(".modalButton").css("display","none");
        });
    });

    $('#proceedButton').click(function () {

        var errorMessage = '';
        if ( $("#statuatename").val() == ""  || $("#statuatename").val() == null) {
            errorMessage = errorMessage + 'Name cannot be empty!!\n' ;
        }
        if ( $("#description").val() == ""  || $("#description").val() == null) {
            errorMessage = errorMessage + 'Description cannot be empty!!\n' ;
        }
        

        if ( errorMessage != "" ) {
            alert(errorMessage);
            return;
        }

        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'listofstatuate/insertStatuate',
            data: {'statuatename':$("#statuatename").val(),'description':$("#description").val()},
            success:function(data){
                //window.location.href="homepage";                
                fnTableCalling();
            }
        });
    });
    
    $('#editButton').click(function () {
        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'listofstatuate/updateStatuate',
            data: {'editStatuatename':$("#editStatuatename").val(),'description':$("#editdescription").val(),'editSTID':$("#editSTID").val()},
            success:function(data){
                //window.location.href="homepage";                
                fnTableCalling();
            }
        });
    });

    $(document).on('click','.editCourtType',function(){

        $("#modalCourtType").modal('show');
        //var data = table.row(this).data();
        $("#editButton").css("display","none");

        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'listofstatuate/findStatuate',
            data: {'statuateid':$(this).val()},
            success:function(jdata){
                var strData = String(jdata.data);
                var str = strData.split(",");
                if(str[0]!=''){
                    $("#editButton").css("display","block");

                }
                $("#editSTID").val(str[0]);
                $("#editStatuatename").val(str[1]);
                $("#editdescription").val(str[2])
            }
        });

    });

    
    $(document).on('click','.disableStatuate',function(){

        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'listofstatuate/disableStatuate',
            data: {'statuateid':$(this).val()},
            success:function(jdata){
                fnTableCalling();
            }
        });

    });

    function fnTableCalling()
    {
        $('#courtTypeList').dataTable().fnDestroy();
        table = $('#courtTypeList').DataTable({
            "ajax": "listofstatuate/fetchListOfStatuate",
            "columnDefs": [
                        { 
                            "visible": false
                        }
                    ],
            "columns": [
               { "data": "stid" },  
               { "data": "name" },  
               { "data": "description" },
               { "data": "createdby" },  
               { "data": "disable" }
            ]
        });
    }
    </script>
</body>

</html>