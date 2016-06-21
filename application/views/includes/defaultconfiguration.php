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
                    <a href="<?php echo site_url('admin/listofstatuate');?>">List of Statuate</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo site_url('admin/listofstatuatesubsection');?>">List of Sub Section</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo site_url('admin/listofconcept');?>">List of Concepts</a>
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
        <li   class="active">
            <a href="<?php echo site_url('admin/cliententity');?>">Client and Entities</a>
        </li>
        <li  class="active">
            <a href="<?php echo site_url('admin/userdetails');?>">User Details</a>
        </li>
        <li  class="active">
            <a href="<?php echo site_url('login/logout');?>">Logout</a>
        </li>
    </ul>
</nav>

<?php
    } else {

?>
<nav class="navbar navbar-inverse" role="navigation" style="margin-bottom: 0">
    <ul class="nav  navbar-nav" id="mainmenu">
        <li  class="active">
            <a href="<?php echo site_url('user/homepage');?>">Home</a>
        </li>
        <li  class="active">
            <a href="<?php echo site_url('user/research');?>">Research Topic</a>
        </li>
        <li  class="active">
            <a href="<?php echo site_url('login/logout');?>">Logout</a>
        </li>
    </ul>
</nav>
<?php } ?>