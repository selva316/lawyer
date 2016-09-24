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

    <title>Client Master</title>
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
        <!--<div class="panel panel-success titleClass">
        <div class="panel-heading">
            <center><label><b>Client Master</b></label></center></div>
        </div>  -->    
        <div id="page-wrapper" class="titleClass">
            <div class="row">
                <div class="col-lg-12">
                    <div style="margin-left:30px;margin-bottom:10px;">
                        <button type="button" class="btn btn-large btn-success" id="finalize" > Add Client <i class="fa fa-close"></i> </button>
                    </div>

                </div>
                <!-- /.col-lg-12 -->
            </div>
                <!-- /.row -->
            <div class="panel panel-default">
                <div class="panel-heading">Client Master</div>
                <div class="panel-body">
                    <table id="clientEntityList" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Client ID</th>
                                <th>Client Name</th>
                                <th>Belongs To</th>
                                <th>Created On</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div> 
               
        </div>
<!-- /#page-wrapper -->
    </div>

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
    var table;
    $(document).ready(function() {
        
        fnTableCalling();
        
        $( "#clientname" ).blur(function() {
            $.ajax({
                type: 'post',
                dataType: "json",
                url: 'cliententity/checkClientNameAvailable',
                data: {'clientname':$("#clientname").val()},
                success:function(data){
                    //alert(data);
                    if(data=="true"){
                        $("#email").prop('disabled',false);
                        $("#supernote").prop('disabled',false);
                        //$("#proceedButton").css("display","block");
                        $("#clientname").css("border","1px solid #ccc");
                        $("#clientname").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    }
                    else{
                        $("#email").prop('disabled',true);
                        $("#supernote").prop('disabled',true);
                        $("#clientname").css("border","1px solid #c7254e");
                        $("#clientname").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    }
                }
            });
        });


        $( "#email" ).change(function() {
            if($(this).val() != "")
                $(".modalButton").css("display","block");
            else
                $(".modalButton").css("display","none");
        });
    });

    $("#finalize").click(function(){
        window.location.href = "addcliententity"
    });

    $('#proceedButton').click(function () {

        var errorMessage = '';
        if ( $("#clientname").val() == ""  || $("#clientname").val() == null) {
            errorMessage = errorMessage + 'Name cannot be empty!!\n' ;
        }
        if ( $("#email").val() == ""  || $("#email").val() == null) {
            errorMessage = errorMessage + 'Email cannot be empty!!\n' ;
        }
        if ( $("#supernote").val() == ""  || $("#supernote").val() == null) {
            errorMessage = errorMessage + 'Notes cannot be empty!!\n' ;
        }

        if ( errorMessage != "" ) {
            alert(errorMessage);
            return;
        }

        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'cliententity/insertClient',
            data: {'clientname':$("#clientname").val(),'email':$("#email").val(),'supernote':$("#supernote").val()},
            success:function(data){
                //window.location.href="homepage";
                $("#clientname").val('');
                $("#email").val('');
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

    $(document).on('click','.editClientEntity',function(){

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
        $('#clientEntityList').dataTable().fnDestroy();
        table = $('#clientEntityList').DataTable({
            "ajax": "cliententity/fetchClientDetails",
            "columnDefs": [
                        { 
                            "visible": false
                        }
                    ],
            "columns": [
               { "data": "clientid" },  
               { "data": "name" },  
               { "data": "createdby" },
               { "data": "createdon" }
               //{ "data": "disable" }
            ]
        });
    }
    </script>
</body>

</html>