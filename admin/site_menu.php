<section class="sidebar">
    <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li id="dashActive"><a href="<?php echo baseUrl('admin/view/dashboard.php'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-laptop"></i>
                <span>General Settings</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li id="countryActive"><a href="<?php echo baseUrl('admin/view/country/list.php'); ?>"><i class="fa fa-circle-o"></i> Country List</a></li>
                <li id="bannerActive"><a href="<?php echo baseUrl('admin/view/banner/list.php'); ?>"><i class="fa fa-circle-o"></i> Banner List</a></li>
                <li id="clientsActive"><a href="<?php echo baseUrl('admin/view/clients/list.php'); ?>"><i class="fa fa-circle-o"></i> Clients List</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-newspaper-o"></i>
                <span>Service Settings</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li id="serviceActive"><a href="<?php echo baseUrl('admin/view/service/list.php'); ?>"><i class="fa fa-circle-o"></i> Service List</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-newspaper-o"></i>
                <span>News Settings</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li id="newsActive"><a href="<?php echo baseUrl('admin/view/news/list.php'); ?>"><i class="fa fa-circle-o"></i> News List</a></li>
            </ul>
        </li>
        <li id="contactActive"><a href="<?php echo baseUrl('admin/view/contact/list.php'); ?>"><i class="fa fa-comment"></i> Contact Information</a></li>

    </ul>
</section>