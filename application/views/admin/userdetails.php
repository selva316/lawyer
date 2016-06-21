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

    <title>List of Users</title>
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
            <center><label><b>List of Users</b></label></center></div>
        </div>      
        <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div style="margin-left:30px;margin-bottom:10px;">
                            <button type="button" class="btn btn-large btn-success" id="finalize" data-toggle="modal" data-target="#desModal" > Add User <i class="fa fa-close"></i> </button>
                        </div>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="panel panel-default">
                    <div class="panel-heading">List of Users</div>
                    <div class="panel-body">
                        <table id="courtTypeList" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Email ID</th>
                                    <th>Mobile</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                </div>
                </div> 
               
            </div>
            <!-- /#page-wrapper -->

            <!-- Description Modal -->
    <div id="desModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add User</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row-fluid">
                        <div class="span12">
                                <label class="control-label">User Name <span style="color:red">*</span></label>
                                <input type="text" id="username" placeholder="User Name" class="form-control" name="username" />
                        </div>
                    </div>

                    <div class="row-fluid" id="passwordDiv">
                        <div class="span12">
                            <label class="control-label">Password <span style="color:red">*</span></label>
                            <input type="password" id="password" placeholder="Password" disabled="true" class="form-control" name="password" />
                        </div>  
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <label class="control-label">Role <span style="color:red">*</span></label>
                            <select id="userrole"  disabled="true" name="userrole" class="form-control">
                                <option value="">Choose a Role</option>
                                <?php
                                    foreach ($roleresult as $r) {
                                        echo "<option value='".$r['ROLE_ID']."'>". $r['ROLE_NAME'] ."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <label class="control-label">First Name <span style="color:red">*</span></label>
                            <input type="text" id="firstname" placeholder="First Name" class="form-control" name="firstname"  disabled="true"/>
                        </div>
                    </div>
                    
                    <div class="row-fluid">
                        <div class="span12">
                            <label class="control-label">Last Name <span style="color:red">*</span></label>
                            <input type="text" id="lastname" placeholder="Last Name" class="form-control" name="lastname" disabled="true" />
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <label class="control-label">Email ID <span style="color:red">*</span></label>
                            <input type="text" id="emailid" placeholder="Email ID" class="form-control" name="emailid" disabled="true" />
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <label class="control-label">Mobile<span style="color:red">*</span></label>
                            <input type="text" id="mobile" placeholder="Mobile" class="form-control" name="mobile" disabled="true" />
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div id="saveBtn">
                        
                        <button type="button" id="saveAction" style="display: none;" class="btn btn-default">Save</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Description Modal -->

    <!-- Edit Modal -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit User</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row-fluid">
                        <div class="span12">
                                <label class="control-label">User Name <span style="color:red">*</span></label>
                                <input type="text" id="editusername"   disabled="true" placeholder="User Name" class="form-control" name="editusername" />
                                <input type="hidden" id="edituserid" class="form-control" name="userid" value="" />
                        </div>
                    </div>
                    <!--
                    <div class="row-fluid" id="passwordDiv">
                        <div class="span12">
                            <label class="control-label">Password <span style="color:red">*</span></label>
                            <input type="password" id="editpassword" placeholder="Password" class="form-control" name="editpassword" />
                        </div>  
                    </div>-->

                    <div class="row-fluid">
                        <div class="span12">
                            <label class="control-label">Role <span style="color:red">*</span></label>
                            <select id="edituserrole"  name="edituserrole" class="form-control">
                                <option value="">Choose a Role</option>
                                <?php
                                    foreach ($roleresult as $r) {
                                        echo "<option value='".$r['ROLE_ID']."'>". $r['ROLE_NAME'] ."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <label class="control-label">First Name <span style="color:red">*</span></label>
                            <input type="text" id="editfirstname" placeholder="First Name" class="form-control" name="editfirstname" />
                        </div>
                    </div>
                    
                    <div class="row-fluid">
                        <div class="span12">
                            <label class="control-label">Last Name <span style="color:red">*</span></label>
                            <input type="text" id="editlastname" placeholder="Last Name" class="form-control" name="editlastname" />
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <label class="control-label">Email ID <span style="color:red">*</span></label>
                            <input type="text" id="editemailid" placeholder="Email ID" class="form-control" name="editemailid" />
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <label class="control-label">Mobile<span style="color:red">*</span></label>
                            <input type="text" id="editmobile" placeholder="Mobile" class="form-control" name="editmobile" />
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div id="editBtn">
                        
                        <button type="button" id="editAction" class="btn btn-default">Update</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->

        </div>
        

        

        <!-- Edit Court Type Modal-->
        <div class="modal fade" id="modalCourtType">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Userdetails</h4>
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

    
    $(document).on('click','.editUsers',function(){
        
         $.ajax({
            type: 'post',
            dataType: "json",
            url: 'userdetails/fetchUserIdDetails',
            data: {'userid':$(this).val()},
            success:function(data){
               
               $("#edituserid").val(data.userid);
               $("#editusername").val(data.username);
               $("#editpassword").val();
               $("#edituserrole").val(data.role);
               $("#editfirstname").val(data.fname);
               $("#editlastname").val(data.lname);
               $("#editemailid").val(data.emailid);
               $("#editmobile").val(data.mobile);
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

    
    $(document).on('click','.disableUser',function(){

        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'userdetails/disableUser',
            data: {'userid':$(this).val()},
            success:function(jdata){
                fnTableCalling();
            }
        });

    });

    function fnTableCalling()
    {
        $('#courtTypeList').dataTable().fnDestroy();
        table = $('#courtTypeList').DataTable({
            "ajax": "userdetails/fetchListOfUser",
            "columnDefs": [
                        { 
                            "visible": false
                        }
                    ],
            "columns": [
               { "data": "userid" },
               { "data": "name" },
               { "data": "emailid" },
               { "data": "mobile" },
               { "data": "role" }, 
               { "data": "disable" }
            ]
        });
    }

    $(document).on('click','#saveAction',function(){
    
        var errorMessage = '';
        if ( $("#username").val() == ""  || $("#username").val() == null) {
            errorMessage = errorMessage + 'Username cannot be empty!!\n' ;
        }
        if ( $("#password").val() == ""  || $("#password").val() == null) {
            errorMessage = errorMessage + 'Password cannot be empty!!\n' ;
        }
        if ( $("#userrole").val() == ""  || $("#userrole").val() == null) {
            errorMessage = errorMessage + 'User role cannot be empty!!\n' ;
        }
        if ( $("#firstname").val() == ""  || $("#firstname").val() == null) {
            errorMessage = errorMessage + 'First name cannot be empty!!\n' ;
        }
        if ( $("#lastname").val() == ""  || $("#lastname").val() == null) {
            errorMessage = errorMessage + 'Last name cannot be empty!!\n' ;
        }
        if ( $("#emailid").val() == ""  || $("#emailid").val() == null) {
            errorMessage = errorMessage + 'Email ID cannot be empty!!\n' ;
        }

        if(!isEmail($.trim($("#emailid").val())))
        {
            errorMessage = errorMessage + 'Not a valid Email ID!!\n' ;   
        }

        if ( $("#mobile").val() == ""  || $("#mobile").val() == null) {
            errorMessage = errorMessage + 'Mobile cannot be empty!!\n' ;
        }

        if ( errorMessage != "" ) {
            alert(errorMessage);
            return;
        }

        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'userdetails/insertUser',
            data: {'username':$("#username").val(),'password':$("#password").val(),'userrole':$("#userrole").val(),'firstname':$("#firstname").val(),'lastname':$("#lastname").val(),'emailid':$("#emailid").val(),'mobile':$("#mobile").val()},
            success:function(data){
                //window.location.href="homepage";
                $("#username").val('');
                $("#password").val('');
                $("#userrole").val('');
                $("#firstname").val('');
                $("#lastname").val('');
                $("#emailid").val('');
                $("#mobile").val('');
                $("#desModal").modal('hide');
                fnTableCalling();
            }
        });
    });

    $(document).on('click','#editAction',function(){
    
        var errorMessage = '';
        if ( $("#editusername").val() == ""  || $("#editusername").val() == null) {
            errorMessage = errorMessage + 'Username cannot be empty!!\n' ;
        }
        
        if ( $("#edituserrole").val() == ""  || $("#edituserrole").val() == null) {
            errorMessage = errorMessage + 'User role cannot be empty!!\n' ;
        }
        if ( $("#editfirstname").val() == ""  || $("#editfirstname").val() == null) {
            errorMessage = errorMessage + 'First name cannot be empty!!\n' ;
        }
        if ( $("#editlastname").val() == ""  || $("#editlastname").val() == null) {
            errorMessage = errorMessage + 'Last name cannot be empty!!\n' ;
        }
        if ( $("#editemailid").val() == ""  || $("#editemailid").val() == null) {
            errorMessage = errorMessage + 'Email ID cannot be empty!!\n' ;
        }

        if(!isEmail($.trim($("#editemailid").val())))
        {
            errorMessage = errorMessage + 'Not a valid Email ID!!\n' ;   
        }

        if ( $("#editmobile").val() == ""  || $("#editmobile").val() == null) {
            errorMessage = errorMessage + 'Mobile cannot be empty!!\n' ;
        }

        if ( errorMessage != "" ) {
            alert(errorMessage);
            return;
        }

        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'userdetails/updateUser',
            data: {'userid':$("#edituserid").val(),'username':$("#editusername").val(),'userrole':$("#edituserrole").val(),'firstname':$("#editfirstname").val(),'lastname':$("#editlastname").val(),'emailid':$("#editemailid").val(),'mobile':$("#editmobile").val()},
            success:function(data){
                //window.location.href="homepage";
                $("#editusername").val('');
                $("#editpassword").val('');
                $("#edituserrole").val('');
                $("#editfirstname").val('');
                $("#editlastname").val('');
                $("#editemailid").val('');
                $("#editmobile").val('');
                $("#editModal").modal('hide');
                fnTableCalling();
            }
        });
    });

    $( "#username" ).blur(function() {
        $.ajax({
            type: 'post',
            dataType: "text",
            url: 'userdetails/userAvailable',
            data: {'username': $("#username").val()},
            success:function(data){
                
                if(data=="true"){
                    $("#password").prop('disabled',false);
                    $("#userrole").prop('disabled',false);

                    $("#firstname").prop('disabled',false);
                    $("#lastname").prop('disabled',false);
                    $("#emailid").prop('disabled',false);
                    $("#mobile").prop('disabled',false);

                    $("#saveAction").css("display","block");
                    $("#username").css("border","1px solid #ccc");
                    $("#username").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                }
                else{
                    $("#username").css("border","1px solid #c7254e");
                    $("#username").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    

                    $("#password").prop('disabled',true);
                    $("#userrole").prop('disabled',true);

                    $("#firstname").prop('disabled',true);
                    $("#lastname").prop('disabled',true);
                    $("#emailid").prop('disabled',true);
                    $("#mobile").prop('disabled',true);
                    $("#saveAction").css("display","none");
                }
                
            }
        });
    });

    function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }
    </script>
</body>

</html>