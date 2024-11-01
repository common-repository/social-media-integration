<?php
/**
 * Created by PhpStorm.
 * User: DeveloperH
 * Date: 2/15/16
 * Time: 10:36 AM
 */
?>
<div class="content-wrapper">
    <section class="content">
        <div class="callout callout-danger">
            <h4><?php _e('We are sorry !!')?></h4>
            <p><?php ($php_version)?_e('Your PHP version is not compatible with social SDKs'):null;?></p>
            <p><?php ($mbstring)?_e('mbstring is not installed (mbstring is php extension)'):null;?></p>
            <p>
                <?php _e('Please contact you host administrator to');
                echo "<br/>";
                ($php_version)?_e('update your php version to 5.4 or above '):null;
                echo "<br/>";
                ($mbstring)?_e('install/enable mbstring extension'):null;?>
            </p>
        </div>
        </section>
    </div>
