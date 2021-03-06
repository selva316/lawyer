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

    <title>Search Builder</title>
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
            <center><label><b>Search Builder</b></label></center></div>
        </div>-->
        <!--<div id="page-wrapper" class="titleClass"  style="min-height: 0px;">-->
        <div id="" class="titleClass"  style="min-height: 0px;">
            <div class='row-fluid'>
                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                    <input type="hidden" id="numberOfSearchEntries" name="numberOfSearchEntries" value="1"> </input>
                    <table class="table table-bordered table-hover tableSearchBuilder">
                        <thead>
                            <tr>
                                <th width="5%">Logical Ops</th>
                                <th width="15%">Fields</th>
                                <th width="25%">Search String</th>
                                <th  width="2%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td>
                                    <select name="fields[]" data-type="1" id="conditionalSearch_1" class="form-control">
                                        <option value="">All Fields</option>
                                        <option value="casename">Case Name</option>
                                        <option value="citation">Citation</option>
                                        <option value="judge_name">Judge Name</option>
                                        <option value="court_name">Court Name</option>
                                        <option value="year">Year</option>
                                        <option value="statuate">Statute</option>
                                        <option value="sub_section">Sub Section</option>
                                        <option value="concept">Concept</option>
                                    </select>
                                </td>
                                <td>
                                <input type="text" data-type="1" name="searchContent[]" id="searchcontent_1" class="form-control autocomplete_searchcontent" autocomplete="off" ondrop="return false;">
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                        <button class="btn btn-danger delete" type="button">- Delete</button>
                        <button class="btn btn-success addmore" type="button">+ Add More</button>
                    </div>
                </div>
            </div>
            <div class="clearfix"><br></div>
            <div class="row-fluid">
                <div class="span5"></div>
                <div class="span2">
                    <button class="btn btn-success searchBuilder" type="button">Search <i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
                <div class="span5"></div>
            </div>
        </div>
        <div id="searchResult" style="display: none;  margin-top: 10px;">
            <div class="panel panel-info">
                <div class="panel-heading">Search Result</div>
                <div class="panel-body">
                    <table id="searchBuilderTable" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Case Name</th>
                                <th>Citation</th>
                                <th>Court Name</th>
                                <th>Judge Name</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>      
    </div>
    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/jquery/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/jquery/jquery-ui.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/jquery/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url();?>assets/menu/js/menuscript.js"></script>
    
    <script src="<?php echo base_url();?>assets/calc/autoSearch.js"></script>
    <script src="<?php echo base_url();?>assets/datatables/js/jquery.dataTables.js"></script>
    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/metisMenu/dist/metisMenu.min.js"></script>
    
    
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>dist/js/sb-admin-2.js"></script>
    
    <script type="text/javascript">
    $(document).ready(function(){
        $("#page-wrapper").css('min-height','0px');
    });
        
    </script>
</body>

</html>