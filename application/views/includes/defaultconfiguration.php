<?php
    $role = $this->session->userdata('role');
    if($role == 'Admin')
    {
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <ul class="selvanav">
        <li  class="test">
            <a href="<?php echo site_url('admin/homepage');?>">Home</a>
        </li>
        <!--<li  class="test">
            <a href="<?php echo site_url('admin/citation');?>">Type of Citation</a>
        </li>-->
		<li  class="test">
            <a href="<?php echo site_url('admin/listofcourt');?>">List of Courts</a>
        </li>
        <li  class="test">
            <a href="<?php echo site_url('login');?>">Logout</a>
        </li>
    </ul>
</nav>

<?php
    } else {

?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <ul class="selvanav">
        <li  class="test">
            <a href="<?php echo site_url('user/homepage');?>">Home</a>
        </li>
        <li  class="test">
            <a href="<?php echo site_url('user/research');?>">Research Topic</a>
        </li>
        <li  class="test">
            <a href="<?php echo site_url('login');?>">Logout</a>
        </li>
    </ul>
</nav>
<?php } ?>