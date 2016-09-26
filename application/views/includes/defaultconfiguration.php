<style type="text/css">
    .clsMenuFixed
    {
        position: fixed;
        z-index: 99999;
        width: 98%;
    }

    .titleClass{
        margin-top: 5%;
    }
</style>

<div class="clsMenuFixed">
<?php
    $role = $this->session->userdata('role');
    if($role == 'Admin')
    {
?>
<nav class="navbar navbar-inverse" role="navigation" style="margin-bottom: 0">
    <ul class="nav  navbar-nav" id="mainmenu">
        <li  class="active">
            <a href="<?php echo site_url('admin/homepage');?>">Home</a>
        </li>
        <!--<li  class="active">
            <a href="<?php echo site_url('admin/citation');?>">Type of Citation</a>
        </li>-->
        <li class="dropdown active">
            <a data-toggle="dropdown" class="dropdown-toggle" id="introJsAdminMenu" href="#">Master<span class="caret"></span></a>
            <ul role="menu" class="dropdown-menu">
                <li>
                    <a href="<?php echo site_url('admin/listofcourt');?>">List of Courts</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo site_url('admin/listofstatuate');?>">List of Statute</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo site_url('admin/listofstatuatesubsection');?>">List of Sub Section</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo site_url('admin/listofconcept');?>">List of Concepts</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo site_url('admin/listofconceptstatuatelink');?>">List of Concepts Statute Link</a>
                </li>
                <!--<li class="dropdown-submenu"><a tabindex="-1" href="/#">Reports</a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="/Report/topClientsAging">Top 40 Clients Aging</a></li>
                        <li class="divider"></li>
                        <li><a href="/Report/monthlyReport">Monthly Performance Report</a></li>
                        <li class="divider"></li>
                        <li><a href="/Report/weeklyReport">Weekly Collections Report</a></li>
                    </ul>
                </li>-->
            </ul>    
        </li>
        
        <li class="active">
            <a href="<?php echo site_url('user/notation');?>">Add Notation</a>
        </li>
        <li   class="active">
            <a href="<?php echo site_url('admin/cliententity');?>">Client and Entities</a>
        </li>
        <li  class="active">
            <a href="<?php echo site_url('user/research');?>">Research Topic</a>
        </li>
        <li  class="active">
            <a href="<?php echo site_url('admin/userdetails');?>">User Details</a>
        </li>
        <li  class="active">
            <a href="<?php echo site_url('admin/searchbuilder');?>">Search Builder</a>
        </li>
        
    </ul>

    <div style="position: absolute; left: 0px; margin-left: 2%; top: 5px; width: 10%;">
        <span style="cursor: default; color: rgb(10, 218, 222); font-weight: bold; font-size: 32px;">easyCite</span>
    </div>

    <div style="position: absolute; left: 0; margin-left: 70%;  top: 15px; text-align: right; width: 28%;">
        <span style="cursor:default; color: #0adade; font-size: 14px; font-weight: bold; "><font color="#fff">Welcome </font><?php echo $this->session->userdata('loginname'); ?></span>
        <span style="cursor:pointer; color: #fff; margin-left: %;" title="Logout"><a style="color:#fff;" href="<?php echo site_url('login/logout');?>"><i aria-hidden="true" class="fa fa-sign-out"></i></a></span>
    </div>
</nav>

<?php
    } else {

?>
<nav class="navbar navbar-inverse" role="navigation" style="margin-bottom: 0">
    <ul class="nav  navbar-nav" id="mainmenu">
        <li  class="active">
            <a href="<?php echo site_url('user/homepage');?>">Home</a>
        </li>
        
        <li class="active">
            <a href="<?php echo site_url('user/notation');?>">Add Notation</a>
        </li>
        <li   class="active">
            <a href="<?php echo site_url('admin/cliententity');?>">Client and Entities</a>
        </li>
        <li  class="active">
            <a href="<?php echo site_url('user/research');?>">Research Topic</a>
        </li>

    </ul>
        <div style="position: absolute; left: 0px; margin-left: 2%; top: 5px; width: 10%;">
            <span style="cursor: default; color: rgb(10, 218, 222); font-weight: bold; font-size: 32px;">easyCite</span>
        </div>

        <div style="position: absolute; left: 0; margin-left: 70%;  top: 15px; text-align: right; width: 28%;">
            <span style="cursor:default; color: #0adade; font-size: 14px; font-weight: bold; "><font color="#fff">Welcome </font><?php echo $this->session->userdata('loginname'); ?></span>
            <span style="cursor:pointer; color: #fff; margin-left: %;" title="Logout"><a style="color:#fff;" href="<?php echo site_url('login/logout');?>"><i aria-hidden="true" class="fa fa-sign-out"></i></a></span>
        </div>
        
</nav>
<?php } ?>
</div>