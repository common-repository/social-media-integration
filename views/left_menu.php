<?php
/**
 * Created by PhpStorm.
 * User: DeveloperH
 * Date: 1/27/16
 * Time: 3:06 PM
 */?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <ul class="sidebar-menu">

            <li class="active">
                <a href="javascript:void(0)">
                    <i class="fa fa-dashboard"></i> <span><?php _e('Dashboard')?></span> <small class="label pull-right bg-green"><?php _e('Soon')?></small>
                </a>
            </li>
            <li>
                <a href="admin.php?page=social-integration&model=facebook">
                    <i class="fa fa-facebook"></i> <span><?php _e('Facebook')?></span>
                </a>
            </li>
            <li >
                <a href="admin.php?page=social-integration&model=twitter">
                    <i class="fa fa-twitter"></i> <span><?php _e('Twitter')?></span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)">
                    <i class="fa fa-google-plus"></i> <span><?php _e('Google+')?></span> <small class="label pull-right bg-green"><?php _e('Soon')?></small>
                </a>
            </li>

            <li><a href="javascript:void(0)"><i class="fa fa-book"></i> <span><?php _e('Help')?></span><small class="label pull-right bg-green"><?php _e('Soon')?></small></a></li>
            <li >
                <a href="admin.php?page=social-integration&model=to_developer">
                    <i class="fa fa-paper-plane-o"></i> <span><?php _e('talk to Developer')?></span>
                </a>
            </li>
            <li >
                <a href="admin.php?page=social-integration&model=thanks">
                    <i class="fa fa-heart"></i> <span><?php _e('Special Thanks')?></span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
