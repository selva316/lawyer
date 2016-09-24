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

    <title>List of Concept & Statute Link</title>
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
    <link rel="stylesheet"  href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" />
    <style>
        .ui-autocomplete {
            z-index: 9999;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <?php $this->load->view('includes/defaultconfiguration');?>
        <!--<div class="panel panel-success titleClass">
        <div class="panel-heading">
            <center><label><b>List of Concepts</b></label></center></div>
        </div> -->     
        <div id="page-wrapper" class="titleClass">
                <div class="row">
                    <div class="col-lg-12">
                        <div style="margin-left:30px;margin-bottom:10px;">
                            <button type="button" class="btn btn-large btn-success" id="finalize" data-toggle="modal" data-target="#conceptModal" > Concept, Statuate Link <i class="fa fa-plus"></i> </button>
                        </div>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="panel panel-default">
                    <div class="panel-heading">List of Concept</div>
                    <div class="panel-body">
                        <table id="courtTypeList" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Concept ID</th>
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
        <!-- Concept Modal Begin here -->
        <div class="modal fade" id="modalValidate">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">New Concept</h4>
              </div>
              <div class="modal-body">
                
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Name</label>
                        <input  class="form-control" type="text" id="conceptname" name="conceptname" value=""/>
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
                  
                  <button type="button" class="btn btn-primary nonEisValidate" data-dismiss="modal" name="proceedButton" id="proceedButton">Save</button>
                </div>
                <div class="clearfix"></div>
              </div>
          </div>
          </div>
        </div> 
        <!-- Concept Modal End here-->

        <!-- Concept Modal Begin here-->
        <div class="modal fade" id="conceptModal"  style="margin-top:5%">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"  style="font-weight:bold;">Statute, Concept Link</h4>
                    </div><!-- /.modal-header -->
                    <div class="modal-body">
                        <div class="row-fluid">
                            <div class="span12">
                                <label for="constatuate">Statute</label>
                                <input id="constatuate" type="text" class="form-control autocomplete_clonestatuate" name="constatuate" value="">
                                <input type="hidden" name="hiddenconceptstatuate" id="hiddenconceptstatuate" class="form-control" value="">
                                
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span12">
                                <label for="conceptsubsection">Subsection</label>
                                <input id="conceptsubsection" type="text" class="form-control autocomplete_clonesubsection" name="conceptsubsection" value="">
                                <input type="hidden" name="hiddenconceptsubsection" id="hiddenconceptsubsection" class="form-control" value="">
                            </div>
                        </div>

                        <div class="row-fluid" style="margin-top: 10px;">
                            <div class="span12">
                                <table class="table table-bordered table-striped tableNewConcept">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="rowcon_1">
                                            <td>
                                            <input type="hidden" id="hiddenconceptname_1" name="hiddenconceptname[]"/>
                                            <input type="text" placeholder="Concept Name" data-type="1" name="conceptName[]" id="conceptName_1" class="form-control autocomplete_cloneconcept" autocomplete="off"></td>
                                            <!--<td>
                                            <input type="text" placeholder="Description" name="conceptDescription[]" id="conceptDescription_1" class="form-control" autocomplete="off"></td>-->
                                            
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <button type="button" class="btn btn-success addConceptStatuate"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"><br></div>

                        <div class="row-fluid">
                            <div class="span4"></div>
                            <div class="span4" id="conceptAction">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" name="saveConcept" id="saveConcept">Save</button>
                            </div>
                            <div class="span4"></div>
                        </div>
                    </div><!-- /.modal-body -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->  

    <!-- Concept Modal End here-->
    
        <!-- Edit Court Type Modal-->
        <div class="modal fade" id="modalCourtType"  style="margin-top:5%">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Concept</h4>
              </div>
              <div class="modal-body">
                
                <div class="row-fluid">
                    <div class="span12">
                        <label class="control-label">Name</label>
                        <input  class="form-control" type="text" id="editConceptname" name="editConceptname" value=""/>
                        <input  class="form-control" type="hidden" id="editCID" name="editCID" value=""/>
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
    
    <script>
    var table;
    $(document).ready(function() {
        
        fnTableCalling();
        
        $(document).on('focus','.autocomplete_clonestatuate',function(){
        
            url = 'listofconcept/fetchUserStatuate';
            autoTypeNo=0;

            $(this).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url : url,
                        dataType: "json",
                        method: 'post',
                        data: {
                           name_startsWith: request.term
                        },
                         success: function( data ) {
                             response( $.map( data, function( item ) {
                                var code = item.split("|");
                                return {
                                    label: item,
                                    value: code[autoTypeNo],
                                    data : item
                                }
                            }));
                        }
                    });
                },
                autoFocus: true,            
                minLength: 0,
                select: function( event, ui ) {
                    var names = ui.item.data.split("|");                        
                    id_arr = $(this).attr('id');
                    id = id_arr.split("_");
                    
                    $('#constatuate').val(names[0]);
                    //$('#conceptsubsection').val(names[1]);
                    $('#hiddenconceptstatuate').val(names[1]);
                    //$("#hiddenconceptsubsection").val(names[3]);
                }
            });
        });

        $(document).on('focus','.autocomplete_clonesubsection',function(){
            
            if($("#constatuate").val()!='')
            {
                url = 'listofconcept/fetchUserSubSection';
                autoTypeNo=0;

                $(this).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url : url,
                            dataType: "json",
                            method: 'post',
                            data: {
                               name_startsWith: request.term,
                               statuate: $("#hiddenconceptstatuate").val()
                            },
                             success: function( data ) {
                                 response( $.map( data, function( item ) {
                                    var code = item.split("|");
                                    return {
                                        label: item,
                                        value: code[autoTypeNo],
                                        data : item
                                    }
                                }));
                            }
                        });
                    },
                    autoFocus: true,            
                    minLength: 0,
                    select: function( event, ui ) {
                        var names = ui.item.data.split("|");                        
                        id_arr = $(this).attr('id');
                        id = id_arr.split("_");
                        //$('#subsection_'+id[1]).val(names[0]);
                        $('#conceptsubsection').val(names[0]);
                        $("#hiddenconceptsubsection").val(names[1]);
                    }
                }); 
            }
        });

        
        $(document).on('focus','.autocomplete_cloneconcept',function(){
            
            var type = $(this).data('type');
            var conceptName = "#conceptName_"+type
            var hiddenconceptname = "#hiddenconceptname_"+type
            $(this).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        //url : 'listofconceptstatuatelink/conceptAjax',
                        url : 'listofconcept/fetchUserConcept',
                        dataType: "json",
                        method: 'post',
                        data: {
                           name_startsWith: request.term,
                           type: type
                        },
                         success: function( data ) {
                             response( $.map( data, function( item ) {
                                var code = item.split("|");
                                return {
                                    label: item,
                                    value: code[0],
                                    data : item
                                }
                            }));
                        }
                    });
                },
                autoFocus: true,            
                minLength: 0,
                select: function( event, ui ) {
                        var names = ui.item.data.split("|");                        
                        id_arr = $(this).attr('id');
                        id = id_arr.split("_");
                        
                        //$('#subsection_'+id[1]).val(names[0]);
                        $(conceptName).val(names[0]);
                        $(hiddenconceptname).val(names[1]);
                    }               
            });
        });    

        $( "#conceptname" ).blur(function() {
            $.ajax({
                type: 'post',
                dataType: "json",
                url: 'listofconcept/checkConceptNameAvailable',
                data: {'conceptname':$("#conceptname").val()},
                success:function(data){
                    //alert(data);
                    if(data=="true"){
                        $("#description").prop('disabled',false);
                        //$("#proceedButton").css("display","block");
                        $("#conceptname").css("border","1px solid #ccc");
                        $("#conceptname").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    }
                    else{
                        $("#description").prop('disabled',true);
                        $("#conceptname").css("border","1px solid #c7254e");
                        $("#conceptname").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
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
        if ( $("#conceptname").val() == ""  || $("#conceptname").val() == null) {
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
            url: 'listofconcept/newConcept',
            data: {'conceptname':$("#conceptname").val(),'description':$("#description").val()},
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
            url: 'listofconcept/updateConcept',
            data: {'editConceptname':$("#editConceptname").val(),'description':$("#editdescription").val(),'editCID':$("#editCID").val()},
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
            url: 'listofconcept/findConcept',
            data: {'conceptid':$(this).val()},
            success:function(jdata){
                var strData = String(jdata.data);
                var str = strData.split(",");
                if(str[0]!=''){
                    $("#editButton").css("display","block");

                }
                $("#editCID").val(str[0]);
                $("#editConceptname").val(str[1]);
                $("#editdescription").val(str[2])
            }
        });

    });

    /*Concept function begin*/
    $(document).on('click', '#saveConcept', function(e) {
        var errorMessage = '';

        if ( $("#constatuate").val() == ""  || $("#constatuate").val() == null) {
            errorMessage = errorMessage + 'Statuate cannot be empty!!\n' ;
        }

        /*
        if ( $("#conceptsubsection").val() == ""  || $("#conceptsubsection").val() == null) {
            errorMessage = errorMessage + 'Subsection cannot be empty!!\n' ;
        }
        */

        var si = $('.tableNewConcept tr').length - 1;
        
        var temp = [];
        for(i=1;i<=si;i++)
        {
            //var conceptcontrol = "#conceptName_"+i;
            var conceptcontrol = "#hiddenconceptname_"+i;
            if ( $(conceptcontrol).val() == ""  || $(conceptcontrol).val() == null) {
                continue;
            }
            temp.push($(conceptcontrol).val());
        }

        if(temp.length == 0)
        {
            errorMessage = errorMessage + 'Concept should not be empty!!\n' ;
        }


        if ( errorMessage != "" ) {
            alert(errorMessage);
            return;
        }

        $.ajax({
            url : 'listofconcept/insertConcept',
            type : 'POST',
            async: false,
            cache: false,
            data : {
                statuate: $("#hiddenconceptstatuate").val(),
                subsection: $("#hiddenconceptsubsection").val(),
                concept: temp.join(",")
            },
            success: function(dat) {
                                
                $("#constatuate").val('');
                $("#conceptsubsection").val('');

                $("#hiddenconceptstatuate").val('');
                $("#hiddenconceptsubsection").val('');
                $("#conceptName_1").val('');

                for(j=2;j<=si;j++)
                {
                    var rowtr = "#rowcon_"+j;
                    $(rowtr).remove();
                }

                $("#conceptModal").modal('hide');
                fnTableCalling();
            }
        });
    });
    /*Concept function end*/

    $(document).on('click','.disableConcept',function(){

        $.ajax({
            type: 'post',
            dataType: "json",
            url: 'listofconcept/disableConcept',
            data: {'cid':$(this).val()},
            success:function(jdata){
                fnTableCalling();
            }
        });

    });

    function fnTableCalling()
    {
        $('#courtTypeList').dataTable().fnDestroy();
        table = $('#courtTypeList').DataTable({
            "ajax": "listofconcept/fetchListOfConcept",
            "columnDefs": [
                        { 
                            "visible": false
                        }
                    ],
            "columns": [
               { "data": "cid" },  
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