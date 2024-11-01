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
            <p><?php _e('You are not connected to');echo ' '.$model;?></p>
            <p><?php _e('Please click')?> <a href="<?php echo $link?>"><?php _e('here')?></a> <?php _e('to access'); echo ' '.$model;?> </p>
        </div>

        <?php if($model=='twitter'){?>
            <div class="box box-warning">
                <form class="form-horizontal" id="settings-form">
                    <p><?php _e('Please use this callback URL for your twitter application');echo ' http://'.$_SERVER['SERVER_NAME'].'/wp-admin/admin.php?page=social-integration-twitter';?></p>
                    <input type="hidden" name="social" value="twitter" />
                    <input type="hidden" name="action" value="save_settings" />
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label"><?php _e('Access Token')?></label>
                        <div class="col-sm-10">
                            <p style="display: none;">
                                <i class="fa fa-times-circle-o"></i>
                                <?php _e('You cant leave it empty');?>
                            </p>
                            <input type="text" class="form-control" id="access_token" name="access_token" value="<?php echo isset($socialKeys['access_token'])?$socialKeys['access_token']:'' ?>" placeholder="<?php _e('Access Token')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label"><?php _e('Token Secret')?></label>
                        <div class="col-sm-10">
                            <p style="display: none;">
                                <i class="fa fa-times-circle-o"></i>
                                <?php _e('You cant leave it empty');?>
                            </p>
                            <input type="text" class="form-control" id="token_secret" name="token_secret" value="<?php echo isset($socialKeys['token_secret'])?$socialKeys['token_secret']:''; ?>" placeholder="<?php _e('Token Secret')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label"><?php _e('Consumer Key')?></label>
                        <div class="col-sm-10">
                            <p style="display: none;">
                                <i class="fa fa-times-circle-o"></i>
                                <?php _e('You cant leave it empty');?>
                            </p>
                            <input type="text" class="form-control" id="consumer_key"  value="<?php echo isset($socialKeys['consumer_key'])?$socialKeys['consumer_key']:''; ?>" name="consumer_key" placeholder="<?php _e('Consumer Key')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label"><?php _e('Consumer Secret')?></label>
                        <div class="col-sm-10">
                            <p style="display: none;">
                                <i class="fa fa-times-circle-o"></i>
                                <?php _e('You cant leave it empty');?>
                            </p>
                            <input class="form-control" id="consumer_secret" name="consumer_secret" value="<?php echo isset($socialKeys['consumer_secret'])?$socialKeys['consumer_secret']:''?>" placeholder="<?php _e('Consumer Secret')?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-danger"><?php _e('Save')?></button>
                        </div>
                    </div>
                </form>
                <div class="callout callout-info show-msg" style="margin-bottom: 0!important;opacity: 0;height: 0;width: 0">
                    <h4><i class="fa fa-info"></i> <?php _e('Note');?>:</h4>
                    <?php _e('Twitter credential is saved, Please reload page and click on the link above. ');?>
                </div>
            </div>
            <script>
                jQuery(document).on('submit','#settings-form',function (){
                    var data=jQuery("#settings-form").serialize(),error=true;
                    if(jQuery("#appid").val()==''){
                        jQuery("#appid").parent().parent().addClass('has-error');
                        error=false;
                    }else{
                        jQuery("#appid").parent().parent().removeClass('has-error');
                    }
                    if(jQuery("#secret").val()==''){
                        jQuery("#secret").parent().parent().addClass('has-error');
                        error=false;
                    }else{
                        jQuery("#secret").parent().parent().removeClass('has-error');
                    }
                    if(jQuery("#namespace").val()==''){
                        jQuery("#namespace").parent().parent().addClass('has-error');
                        error=false;
                    }else{
                        jQuery("#namespace").parent().parent().removeClass('has-error');
                    }
                    if(jQuery("#url").val()==''){
                        jQuery("#url").parent().parent().addClass('has-error');
                        error=false;
                    }else{
                        jQuery("#url").parent().parent().removeClass('has-error');
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
        <?php }?>
        <?php if($model=='facebook'){?>
            <div class="callout callout-warning">
                <h4><?php _e('Please  !!')?></h4>
                <p><?php _e('Make sure give you app full access');?></p>
                <p><?php _e('Please go to your app details the find configure app center permission then select all available permission')?> </p>
            </div>
            <div class="box box-warning">
                <form class="form-horizontal" id="settings-form">
                    <p><?php _e('Please use this callback URL for your application');echo ' http://'.$_SERVER['SERVER_NAME'].'/wp-admin/admin.php?page=social-integration&model=facebook';?></p>
                    <input type="hidden" name="social" value="facebook" />
                    <input type="hidden" name="action" value="save_settings" />
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label"><?php _e('App ID')?></label>
                        <div class="col-sm-10">
                            <p style="display: none;">
                                <i class="fa fa-times-circle-o"></i>
                                <?php _e('You cant leave it empty');?>
                            </p>
                            <input type="text" class="form-control" id="appid" name="appid" value="<?php echo isset($socialKeys['appid'])?$socialKeys['appid']:''; ?>" placeholder="<?php _e('App ID')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label"><?php _e('App Secret')?></label>
                        <div class="col-sm-10">
                            <p style="display: none;">
                                <i class="fa fa-times-circle-o"></i>
                                <?php _e('You cant leave it empty');?>
                            </p>
                            <input type="text" class="form-control" id="secret" name="secret" value="<?php echo isset($socialKeys['secret'])?$socialKeys['secret']:''; ?>" placeholder="<?php _e('App Secret')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label"><?php _e('Namespace')?></label>
                        <div class="col-sm-10">
                            <p style="display: none;">
                                <i class="fa fa-times-circle-o"></i>
                                <?php _e('You cant leave it empty');?>
                            </p>
                            <input type="text" class="form-control" id="namespace"  value="<?php echo isset($socialKeys['namespace'])?$socialKeys['namespace']:''; ?>" name="namespace" placeholder="<?php _e('Namespace')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label"><?php _e('Valid OAuth redirect URIs')?></label>
                        <div class="col-sm-10">
                            <p style="display: none;">
                                <i class="fa fa-times-circle-o"></i>
                                <?php _e('You cant leave it empty');?>
                            </p>
                            <textarea class="form-control" id="url" name="url" placeholder="<?php _e('Valid OAuth redirect URIs')?>"><?php echo isset($socialKeys['url'])?$socialKeys['url']:''; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-danger"><?php _e('Save')?></button>
                        </div>
                    </div>
                </form>
                <div class="callout callout-info show-msg" style="margin-bottom: 0!important;opacity: 0;height: 0;width: 0">
                    <h4><i class="fa fa-info"></i> <?php _e('Note');?>:</h4>
                    <?php _e('Facebook credential is saved, Please reload page and click on the link above. ');?>
                </div>
            </div>
            <script>
                jQuery(document).on('submit','#settings-form',function (){
                    var data=jQuery("#settings-form").serialize(),error=true;
                    if(jQuery("#appid").val()==''){
                        jQuery("#appid").parent().parent().addClass('has-error');
                        error=false;
                    }else{
                        jQuery("#appid").parent().parent().removeClass('has-error');
                    }
                    if(jQuery("#secret").val()==''){
                        jQuery("#secret").parent().parent().addClass('has-error');
                        error=false;
                    }else{
                        jQuery("#secret").parent().parent().removeClass('has-error');
                    }
                    if(jQuery("#namespace").val()==''){
                        jQuery("#namespace").parent().parent().addClass('has-error');
                        error=false;
                    }else{
                        jQuery("#namespace").parent().parent().removeClass('has-error');
                    }
                    if(jQuery("#url").val()==''){
                        jQuery("#url").parent().parent().addClass('has-error');
                        error=false;
                    }else{
                        jQuery("#url").parent().parent().removeClass('has-error');
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
        <?php }?>
    </section>
</div>
