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

    <title>Add Client Master</title>
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
        #mceu_28{
            display: none;
        }

        #mceu_59{
            display: none;
        }*/
        .mce-path
        {
            display: none !important;    
        }
    </style>
</head>

<body>
    <form name="frmclient" action="addcliententity/insertClientEntities" method="post" onsubmit="return frmValidation()"  autocomplete="off">
    
    <div class="container-fluid">
        <?php $this->load->view('includes/defaultconfiguration');?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <center><label><b>Add Client Entity</b></label></center>
            </div>
        </div>      
        <div id="page-wrapper" style="margin: auto 20px !important;">

            <div class="panel panel-warning">
                <div class="panel-heading">Client</div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="span6"  id="divclientname">
                            <label class="control-label">Name</label>
                            <input  class="form-control" type="text" id="clientname" name="clientname" value=""/>
                        </div>

                        <div class="span6" id="divemail">
                            <label class="control-label">Email Id</label>
                            <input  class="form-control" type="text" id="email" name="email" value=""/>
                        </div>
                    </div>
                    <div class="row-fluid" style="margin-top:20px;">
                        <div class="span12"  id="divsupernote">
                            <label class="control-label">Super note</label>
                            <!--<input  class="form-control" type="text" disabled="true" id="supernote" name="supernote" value=""/>-->
                            <textarea id="supernote" class="form-control myTextEditor"  placeholder="Super Notes" name="supernote" rows="4" cols="45"></textarea> 
                        </div>
                    </div>

                    <!-- Entity Begins Here -->
            <table class="tblClientEntity"  style="width:100%;margin-top: 10px;">
                <tr>
                    <td>
                        <div class="panel panel-info">
                            <div class="panel-heading">Entities <span style="margin-left:90%; cursor:pointer;color: #21b384; font-size:14px;" title="Add Entity" class="addEntity"><i class="fa fa-plus"></i></span></div>
                            <div class="panel-body">
                                <input type="hidden" id="numberofClientEntity" name="numberofClientEntity" value="1" />
                                <div class="row-fluid">
                                    <div class="span6" id="divEntity">
                                        <label class="control-label">Entity Name</label>
                                        <input  class="form-control" type="text" id="clientname_1" name="entityname[]" value=""/>
                                    </div>

                                    <div class="span6">
                                        <label class="control-label">Entity Email Id</label>
                                        <input  class="form-control" type="text" id="email_1" name="entityemail[]" value=""/>
                                    </div>
                                </div>

                                <div class="row-fluid"  style="margin-top:20px;">
                                    <div class="span12">
                                        <label class="control-label">Super note</label>
                                        <textarea id="entitiessupernote_1" class="form-control myTextEditor"  placeholder="Super Notes" name="entitysupernote[]" rows="4" cols="45"></textarea> 
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </td>
                </tr>
            </table>
            <!-- Entity Ends here-->

            <!-- Case Begins Here -->
            <table class="tblClientCase"  style="width:100%;">
                <tr>
                    <td>
                        <div class="panel panel-danger">
                            <div class="panel-heading">Case Details <span style="margin-left:85%; cursor:pointer;color: #21b384; font-size:14px;" title="Add Case" class="addCase"><i class="fa fa-plus"></i></span></div>
                            <div class="panel-body">
                                <input type="hidden" id="numberofClientCase" name="numberofClientCase" value="1" />
                                <div class="row-fluid">
                                    <div class="span6">
                                        <label class="control-label">Entity</label>
                                        <input  class="autoEntity form-control" type="text" id="caseEntity_1" name="caseEntity[]" value=""/>
                                    </div>

                                    <div class="span6">
                                        <label class="control-label">Case Number</label>
                                        <input  class="autocasenumber form-control" type="text" id="casenumber_1" name="casenumber[]" value=""/>
                                    </div>
                                </div>
                                <div class="row-fluid"  style="margin-top:20px;">
                                    <div class="span12">
                                        <label class="control-label">Case Super note</label>
                                        <textarea id="casesupernote_1" class="form-control myTextEditor"  placeholder="Super Notes" name="casesupernote[]" rows="4" cols="45"></textarea> 
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </td>
                </tr>
            </table>
            <!-- Case Ends here-->

                </div>
            </div>       
            
            <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                <button class="btn btn-success addEntity" type="button" >+ Add Entity</button>
            </div>
            <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                <button class="btn btn-success addCase" type="button" >+ Add Case</button>
            </div>
                    <div class="clearfix"><br></div>
                    <div class="center"  style="text-align:center;">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    <div class="clearfix"></div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    </form>
    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/jquery/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/jquery/jquery-ui.min.js"></script>

    <script src="<?php echo base_url();?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/jquery/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url();?>assets/menu/js/menuscript.js"></script>
    
    <script src="<?php echo base_url();?>assets/calc/cliententity.js"></script>
    <script src="<?php echo base_url();?>assets/datatables/js/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/tokenfield/bootstrap-tokenfield.js"></script>
    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/metisMenu/dist/metisMenu.min.js"></script>
    
    
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>dist/js/sb-admin-2.js"></script>

    <script>
    tinymce.init({  
        mode : "specific_textareas",
        plugins: "autoresize",
        editor_selector : "myTextEditor"
    });
    </script>

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

        $('.autocasenumber').tokenfield({
            autocomplete: {
                //source: ['red','blue','green','yellow','violet','brown','purple','black','white','red','blue','green','yellow','violet','brown','purple','black','white'],
                source: function( request, response ) {
                 $.ajax({
                     url: "addcliententity/fetchCaseNumber",
                     dataType: "json",
                     data: {term: request.term},
                     success: function(data) {
                            response($.map(data, function(item) {
                                 return {
                                     label: item.casenumber,
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

$('#proceedButton').click(function () {

    var clientname = $('#clientname').val();
    var email = $('#email').val();
    var supernote = tinyMCE.get('supernote').getContent();
    var valid=true;
    
    var errorstr = '';
    
    if(clientname==''){
        valid = false;
        errorstr += "Enter valid Client Name!"+ "<BR/>";
        $('#divclientname').addClass('has-error');
    }
    
    if(email ==''){
        valid = false;
        errorstr += "Enter valid Email!"+ "<BR/>";
        $('#divemail').addClass('has-error');
    }
    
    //alert(isEmail(email));
    if(!validateEmails(email))
    {
        valid = false;
        errorstr += "Enter valid Email!"+ "<BR/>";
        $('#divemail').addClass('has-error');
    }

    if(supernote==''){
        valid = false;
        errorstr += "Enter valid supernote!"+ "<BR/>";
        $('#divsupernote').addClass('has-error');
    }
    
    if(!valid)
    {
        alert(errorstr);
    }
    
    return valid;
        
        
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
            "ajax": "cliententity/fetchClientDetails",
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