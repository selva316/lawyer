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

    <title>List of Statute Subsection</title>
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
   
</head>

<body>
    <div class="container-fluid">
        <?php $this->load->view('includes/defaultconfiguration');?>
        <!--<div class="panel panel-success titleClass">
        <div class="panel-heading">
            <center><label><b>List of Subsection</b></label></center></div>
        </div>-->
        <div id="page-wrapper" class="titleClass">
                <div class="row">
                    <div class="col-lg-12">
                        <div style="margin-left:30px;margin-bottom:10px;">
                            <button type="button" class="btn btn-large btn-success" id="finalize" data-toggle="modal" data-target="#modalValidate" > Add SubSection <i class="fa fa-close"></i> </button>
                        </div>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="panel panel-default">
                    <div class="panel-heading">List of Statute Subsection</div>
                    <div class="panel-body">
                        <table id="courtTypeList" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">
                                    <input id="checkAllStatuteSubsection" value="1" type="checkbox"></th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="panel-footer" id="divFooter">
                        <button style='margin-left:10px;' type='button' class='btn btn-danger btnDelete'> Delete</button>
                    </div>
                </div> 
               
            </div>
            <!-- /#page-wrapper -->

        </div>
        <div class="modal fade" id="modalValidate" style="margin-top:5%">
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
                                foreach ($result as $k=>$v) {
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

        <!-- Edit Court Type Modal-->
        <div class="modal fade" id="modalCourtType" style="margin-top:5%">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Subsection</h4>
              </div>
              <div class="modal-body">
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Statute</label>
                        <select class="form-control" id="editStatuatename" name="editStatuatename" >
                            <option value="">Select</option>
                            <?php
                                foreach ($result as $k=>$v) {
                                    echo '<option value="'.$k.'">'.$v.'</option>';
                                }
                            ?>
                        </select>
                        
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Name</label>
                        <input  class="form-control" type="text" id="editSubsectionname" name="editSubsectionname" value=""/>
                        <input  class="form-control" type="hidden" id="editSSID" name="editSSID" value=""/>
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
        
        $( "#subsectionname" ).blur(function() {
            $.ajax({
                type: 'post',
                dataType: "json",
                url: 'listofstatuatesubsection/checkSubsectionStatuateNameAvailable',
                data: {'statuatename':$("#statuatename").val(), 'subsectionname':$("#subsectionname").val()},
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
        if ( $("#subsectionname").val() == ""  || $("#subsectionname").val() == null) {
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
            url: 'listofstatuatesubsection/insertSubSection',
            data: {'statuatename':$("#statuatename").val(),'subsectionname':$("#subsectionname").val(),'description':$("#description").val()},
            success:function(data){
                //window.location.href="homepage";  
                $("#statuatename").val('');
                $("#subsectionname").val('');
                $("#description").val('');
                fnTableCalling();
            }
        });
    });
    
    $('#editButton').click(function () {
        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'listofstatuatesubsection/updateSubsection',
            data: {'editStatuatename':$("#editStatuatename").val(), 'editSubsectionname':$("#editSubsectionname").val(),'description':$("#editdescription").val(),'editSSID':$("#editSSID").val()},
            success:function(data){
                //window.location.href="homepage";                
                fnTableCalling();
            }
        });
    });

    /*
    $(document).on('click','.editCourtType',function(){

        $("#modalCourtType").modal('show');
        //var data = table.row(this).data();
        $("#editButton").css("display","none");

        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'listofstatuatesubsection/findSubsection',
            data: {'ssid':$(this).val()},
            success:function(jdata){
                var strData = String(jdata.data);
                var str = strData.split(",");
                if(str[0]!=''){
                    $("#editButton").css("display","block");

                }
                $("#editSSID").val(str[0]);
                $("#editStatuatename").val(str[1]);
                $("#editSubsectionname").val(str[2]);
                $("#editdescription").val(str[3]);
            }
        });

    });
    */

    $(document).on('click','.editSubsection',function(){

        var type = $(this).data('type');
        $("#modalCourtType").modal('show');
        //var data = table.row(this).data();
        $("#editButton").css("display","none");

        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'listofstatuatesubsection/findSubsection',
            data: {'ssid': $(this).data('type')},
            success:function(jdata){
                var strData = String(jdata.data);
                var str = strData.split(",");
                if(str[0]!=''){
                    $("#editButton").css("display","block");

                }
                $("#editSSID").val(str[0]);
                $("#editStatuatename").val(str[1]);
                $("#editSubsectionname").val(str[2]);
                $("#editdescription").val(str[3]);
            }
        });

    });

    $(document).on('click','.disableSubSection',function(){

        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'listofstatuatesubsection/disableSubSection',
            data: {'subsectionid':$(this).val()},
            success:function(jdata){
                fnTableCalling();
            }
        });

    });

    $(document).on('click', '.btnDelete', function(e) {
        var temp = [];
        $.each($("input[class='chkbox']:checked"), function(){            
            temp.push($(this).val());
        });

        if(temp.length > 0){
            $.ajax({
                url: 'listofstatuatesubsection/disableSubSection',
                dataType: "json",
                method: 'post',
                data: {
                   subsectionid: temp.join(",")
                },
                success : function(data) {
                    fnTableCalling();
                }
            });
        }
        else
            alert("No notation is selected!!!")
    });

    $(document).on('change', '#checkAllStatuteSubsection', function() {
        if(this.checked)
        {
            $("input[class='chkbox']").prop('checked', $(this).prop("checked"));
        }
        else
        {
            $("input[class='chkbox']").prop('checked', $(this).prop("checked"));
        }
    });

    function fnTableCalling()
    {
        $('#courtTypeList').dataTable().fnDestroy();
        table = $('#courtTypeList').DataTable({
            "ajax": "listofstatuatesubsection/fetchListOfStatuateSubsection",
            "columnDefs": [
                        { 
                            "visible": false
                        }
                    ],
            "columns": [
               { "data": "ssid" },  
               { "data": "name" },  
               { "data": "description" },
               { "data": "createdby" }
               //{ "data": "disable" }
            ],
            "initComplete": function(settings, json) {
                var cntTable = $(this).DataTable();
                var info = cntTable.page.info()
                if(info.recordsTotal>0)
                {
                    $("#divFooter").css("display","block");
                    $("#checkAllStatuteSubsection").prop("checked",false);
                    $("#checkAllStatuteSubsection").prop("disabled",false);
                }
                else
                {
                    $("#divFooter").css("display","none");
                    $("#checkAllStatuteSubsection").prop("checked",false);
                    $("#checkAllStatuteSubsection").prop("disabled",true);
                }
            }
        });
    }
    </script>
</body>

</html>