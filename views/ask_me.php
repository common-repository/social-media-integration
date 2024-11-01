<?php
/**
 * Created by PhpStorm.
 * User: DeveloperH
 * Date: 2/11/16
 * Time: 2:15 PM
 */
?>
<div class="content-wrapper">
    <section class="content">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><?php _e('Ask Developer') ?></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <form role="form" id="ask-developer">
                    <!-- text input -->
                    <div class="form-group">
                        <p style="display: none;">
                            <i class="fa fa-times-circle-o"></i>
                            <?php _e('You cant leave it empty');?>
                        </p>
                        <label for="name"><?php _e('Full Name') ?></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="<?php _e('name ...') ?>">
                        <input type="hidden" name="action" value="send_to_developer" />
                    </div>
                    <div class="form-group">
                        <p style="display: none;">
                            <i class="fa fa-times-circle-o"></i>
                            <?php _e('You cant leave it empty');?>
                        </p>
                        <label for="email"><?php _e('E-Mail') ?></label>
                        <input type="email" name="email"  id="email" class="form-control" placeholder="<?php _e('E-Mail') ?>" >
                    </div>
                    <div class="form-group">
                        <p style="display: none;">
                            <i class="fa fa-times-circle-o"></i>
                            <?php _e('You cant leave it empty');?>
                        </p>
                        <label for="url"><?php _e('Website') ?></label>
                        <input type="url" name="url" id="url" class="form-control" placeholder="<?php _e('Website') ?>" >
                    </div>
                    <!-- select -->
                    <div class="form-group">
                        <p style="display: none;">
                            <i class="fa fa-times-circle-o"></i>
                            <?php _e('You cant leave it empty');?>
                        </p>
                        <label for="request"><?php _e('My request for') ?></label>
                        <select class="form-control" name="request" id="request">
                            <option value="Feature">Feature</option>
                            <option value="Issue">Issue</option>
                            <option value="Enhancement">Enhancement</option>
                            <option value="Special Request">Special Request</option>
                            <option value=Other">Other</option>
                        </select>
                    </div>

                    <!-- textarea -->
                    <div class="form-group">
                        <p style="display: none;">
                            <i class="fa fa-times-circle-o"></i>
                            <?php _e('You cant leave it empty');?>
                        </p>
                        <label for="subject"><?php _e('Subject') ?></label>
                        <textarea class="form-control" name="subject" id="subject" rows="3" placeholder="<?php _e('Subject') ?>"></textarea>
                    </div>
                    <div class="callout callout-info show-msg" style="margin-bottom: 0!important;opacity: 0;height: 0;width: 0">
                        <h4><i class="fa fa-info"></i> <?php _e('Note');?>:</h4>
                        <?php _e('Your request is sent, We will contact you as soon as possible ');?>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div>
    </section>
</div>
<script>
    jQuery(document).on('submit','#ask-developer',function (){
        var data=jQuery("#ask-developer").serialize(),error=true;
        if(jQuery("#name").val()==''){
            jQuery("#name").parent().parent().addClass('has-error');
            error=false;
        }else{
            jQuery("#name").parent().parent().removeClass('has-error');
        }
        if(jQuery("#email").val()==''){
            jQuery("#email").parent().parent().addClass('has-error');
            error=false;
        }else{
            jQuery("#email").parent().parent().removeClass('has-error');
        }
        if(jQuery("#url").val()==''){
            jQuery("#url").parent().parent().addClass('has-error');
            error=false;
        }else{
            jQuery("#url").parent().parent().removeClass('has-error');
        }
        if(jQuery("#request").val()==''){
            jQuery("#request").parent().parent().addClass('has-error');
            error=false;
        }else{
            jQuery("#request").parent().parent().removeClass('has-error');
        }
        if(jQuery("#subject").val()==''){
            jQuery("#subject").parent().parent().addClass('has-error');
            error=false;
        }else{
            jQuery("#subject").parent().parent().removeClass('has-error');
        }
        if(!error){
            return false;
        }
        jQuery.ajax({
                url:"admin-ajax.php",
                data:data,
                type:'POST'
            })
            .done(function() {

                jQuery( ".show-msg" ).animate({
                    width: [ "100%", "swing" ],
                    height: [ "79px", "swing" ],
                    opacity: ".8"
                }, 3000, "linear", function() {

                });
            })
            .fail(function() {

            })
            .always(function() {

            });
        return false;
    });
</script>
