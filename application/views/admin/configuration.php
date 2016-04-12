<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Configuration Page</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<!--<link rel="stylesheet" href="<?php echo base_url();?>assets/bootgrid/jquery.bootgrid.css" />-->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap-responsive.min.css" />
		
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
	
	
	<?php 
	foreach($css_files as $file): ?>
		<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<?php endforeach; ?>
	<?php foreach($js_files as $file): ?>
		<script src="<?php echo $file; ?>"></script>
	<?php endforeach; ?>
	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>



<style type="text/css">
    .bs-example{
    	margin: 75px 20px 20px;
    }
</style>
</head>
<body>
<nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://iplanetstore.in/" target="_blank">iPlanet Store</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="nav navbar-nav">
                <li><a href="homepage">Home</a></li>
                <li class="active"><a href="configuration">Configuration</a></li>
                <li><a href="http://www.tutorialrepublic.com/contact-us.php" target="_blank">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
	<div class="bs-example" id="divbread">
		<ul class="breadcrumb">
			<li><a href="#divfullfillment">Fullfillment</a></li>
			<li><a href="#divdisposition">Disposition</a></li>
			<li><a href="#divproduct">Product Condition</a></li>
			<li><a href="#divstatus">Product Status</a></li>
		</ul>
    </div>
	<div id="divfullfillment">
		<div class="panel panel-default">
			<div class="panel-heading">Fullfillment</div>
			<div class="panel-body">This page is temporarily disabled by the site administrator for some reason.<br> <a href="#">Click here</a> to enable the page.
				<?php echo $output; ?>
			</div>
		</div>
	</div>
	
	<div id="divdisposition">
		<div class="panel panel-default">
			<div class="panel-heading">Disposition</div>
			<div class="panel-body">This page is temporarily disabled by the site administrator for some reason.<br> <a href="#">Click here</a> to enable the page.
				<?php echo $output; ?>
			</div>
		</div>
	</div>
	
	<div id="divproduct">
		<div class="panel panel-default">
			<div class="panel-heading">Product Condition</div>
			<div class="panel-body">This page is temporarily disabled by the site administrator for some reason.<br> <a href="#">Click here</a> to enable the page.
				<?php echo $output; ?>
			</div>
			<div style="text-align:right;" class="panel-footer"><a href="#divbread">Go Top</a></div>
		</div>
	</div>
	
	<div id="divstatus">
		<div class="panel panel-default">
			<div class="panel-heading">Product Status</div>
			<div class="panel-body">This page is temporarily disabled by the site administrator for some reason.<br> <a href="#">Click here</a> to enable the page.
				<?php echo $output; ?>
			</div>
			<div style="text-align:right;" class="panel-footer"><a href="#divbread">Go Top</a></div>
		</div>
	</div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <footer>
                <p>© Copyright 2013 Tutorial Republic</p>
            </footer>
        </div>
    </div>
</div>
</body>
</html>                                		