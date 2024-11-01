<?php
/**
 * Created by PhpStorm.
 * User: DeveloperH
 * Date: 1/27/16
 * Time: 3:27 PM
 */

?>
<div class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php $view->load('header')?>
        <?php $view->load('left_menu')?>
        <?if(!isset($data)) $data=[];?>
        <?php $view->load($page, $data)?>
        <?php $view->load('right_menu')?>
        <?php $view->load('footer')?>


    </div>

</div>
