<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>List of Courts</title>
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
    <div class="container-fluid">
        <?php $this->load->view('includes/defaultconfiguration');?>
        <div class="panel panel-success">
        <div class="panel-heading">
            <center><label><b>List of Courts</b></label></center></div>
        </div>      
        <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div style="margin-left:30px;margin-bottom:10px;">
                            <button type="button" class="btn btn-large btn-success" id="finalize" data-toggle="modal" data-target="#modalValidate" > Add Court Type <i class="fa fa-close"></i> </button>
                        </div>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="panel panel-default">
                    <div class="panel-heading">List of Courts</div>
                    <div class="panel-body">
                        <table id="courtTypeList" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    
                                    <th>Court ID</th>
                                    <th>Name</th>
                                    <th>Court Type</th>
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
                <h4 class="modal-title">New Court</h4>
              </div>
              <div class="modal-body">
                
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Court Name</label>
                        <input  class="form-control" type="text" id="courtname" name="courtname" value=""/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Court Type</label>
                        
                        <select class="form-control" disabled="true" type="text" id="courtType" name="courtType" >
                            <option value="">Choose a Court Type</option>
                            <?php
                                foreach ($result as $r) {
                                    echo "<option value='".$r['SHORTNAME']."'>". $r['NAME'] ."</option>";
                                }
                            ?>
                        </select>
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
                <h4 class="modal-title">Edit Court List</h4>
              </div>
              <div class="modal-body">
                
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Court Name</label>
                        <input  class="form-control" type="text" id="editCourtname" name="editCourtname" value=""/>
                        <input  class="form-control" type="hidden" id="editCNID" name="editCNID" value=""/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Court Type</label>
                        <select class="form-control" disabled="true" type="text" id="editCourtType" name="editCourtType" >
                            <option value="">Choose a Court Type</option>
                            <?php
                                foreach ($result as $r) {
                                    echo "<option value='".$r['SHORTNAME']."'>". $r['NAME'] ."</option>";
                                }
                            ?>
                        </select>
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
        
        $( "#courtname" ).blur(function() {
            $.ajax({
                type: 'post',
                dataType: "json",
                url: 'listofcourt/checkCourtNameAvailable',
                data: {'courtname':$("#courtname").val()},
                success:function(data){
                    //alert(data);
                    if(data=="true"){
                        $("#courtType").prop('disabled',false);
                        //$("#proceedButton").css("display","block");
                        $("#courtname").css("border","1px solid #ccc");
                        $("#courtname").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    }
                    else{
                        $("#courtname").css("border","1px solid #c7254e");
                        $("#courtname").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    }
                }
            });
        });


        $( "#courtType" ).change(function() {
            if($(this).val() != "")
                $(".modalButton").css("display","block");
            else
                $(".modalButton").css("display","none");
        });
    });

    $('#proceedButton').click(function () {
        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'listofcourt/insertCourtList',
            data: {'courtname':$("#courtname").val(),'courtType':$("#courtType").val()},
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
            url: 'listofcourt/updateCourtList',
            data: {'courtname':$("#editCourtname").val(),'courtType':$("#editCourtType").val(),'editCNID':$("#editCNID").val()},
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
            url: 'listofcourt/findCourtListDetails',
            data: {'courtId':$(this).val()},
            success:function(jdata){
                var strData = String(jdata.data);
                var str = strData.split(",");
                if(str[0]!=''){
                    $("#editButton").css("display","block");

                }
                $("#editCNID").val(str[0]);
                $("#editCourtname").val(str[1]);
                $("#editCourtType").val(str[2])
            }
        });

    });

    
    $(document).on('click','.disableCourtType',function(){

        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'listofcourt/disableCourtList',
            data: {'courtId':$(this).val()},
            success:function(jdata){
                fnTableCalling();
            }
        });

    });

    function fnTableCalling()
    {
        $('#courtTypeList').dataTable().fnDestroy();
        table = $('#courtTypeList').DataTable({
            "ajax": "listofcourt/fetchListCourt",
            "columnDefs": [
                        { 
                            "visible": false
                        }
                    ],
            "columns": [
               { "data": "cnid" },  
               { "data": "name" },  
               { "data": "court_type" },  
               { "data": "disable" }
            ]
        });
    }
    </script>
</body>

</html>