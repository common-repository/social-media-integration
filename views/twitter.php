<?php
/**
 * Created by PhpStorm.
 * User: DeveloperH
 * Date: 1/27/16
 * Time: 4:10 PM
 */
if (!isset($user_pages)) {
    $user_pages=[];
}
if(!isset($user_info['work'])){
    $user_info['work'][0]['position']['name']='';
}

if(!isset($user_info['last_name'])){
    $user_info['last_name']='';
}

if(!isset($user_info['middle_name'])){
    $user_info['middle_name']='';
}

if (!isset($user_info)) {
    $user_info['picture']['url']=PLUGIN_URL.'img/avatar6.png';
    $user_info['first_name']=__('You are not connected to twitter');

    $user_info['education']=[];
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php _e('Twitter')?>
            <small><?php _e('Version')?> 0.3</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> <?php _e('Home')?></a></li>
            <li class="active"><?php _e('Twitter')?></li>
            <li><a id="logout-twitter" class="btn btn-danger"><?php _e('Logout Twitter')?></a></li>
        </ol>
    </section>

    <!-- Main content -->

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">

                        <img class="profile-user-img img-responsive img-circle"
                             src="<?php echo $user_info['picture']['url']?>"
                             alt="<?php echo $user_info['name']?>"/>
                        <h3 class="profile-username text-center">
                            <?php echo $user_info['first_name']?>
                            <?php echo $user_info['middle_name']?>
                            <?php echo $user_info['last_name']?> </h3>
                        <p class="text-muted text-center"><?php echo $user_info['work'][0]['position']['name']?></p>


                        <form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="LT3UY7CKNKKVL">
                            <table>
                                <tr><td><input type="hidden" name="on0" value="Your donation"><?php _e('Your donation will fund Social Integration Plugin Development')?>.</td></tr><tr><td><select class="select2" name="os0">
                                            <option value="Donor"><?php _e('Donor')?> $5.00 USD</option>
                                            <option value="Supporter"><?php _e('Supporter')?> $10.00 USD</option>
                                            <option value="Friend of SI"><?php _e('Friend of SI')?> $35.00 USD</option>
                                            <option value="Best Friend"><?php _e('Best Friend')?> $100.00 USD</option>
                                            <option value="Webmaster Idol"><?php _e('Webmaster Idol')?> $259.00 USD</option>
                                        </select> </td></tr>
                            </table>
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                        </form>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php _e('About Me');?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-map-marker margin-r-5"></i>  <?php _e('Location')?></strong>

                        <p class="text-muted"><?php echo $user_info['hometown']['name']?></p>
                        <hr>
                        <strong><i class="fa fa-book margin-r-5"></i> <?php _e('Education');?></strong>
                        <?php foreach($user_info['education'] as $key=>$val){?>
                            <p class="text-muted">
                                <?php _e('School')?>:<?php echo $val['school']['name']; ?><br>
                                <?php _e('Type')?>:<?php echo $val['type']; ?>
                            </p>
                        <?php }?>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#pages" data-toggle="tab"><?php _e('Pages')?></a></li>
                        <li><a href="#posts" data-toggle="tab"><?php _e('Posts');?></a></li>
                        <li><a href="#settings" data-toggle="tab"><?php _e('Settings');?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="pages">
                            <!-- Post -->

                            <div class="post">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm"
                                         src="<?php echo $user_info['picture']['url']?>"
                                         alt="<?php echo $user_info['screen_name']?>"/>
                                    <span class='username'>
                                      <a href="javascript:void(0)"><?php echo $user_info['screen_name']?></a>
                                    </span>
                                    <span class='description'><?php _e('Statuses count'); echo ' '.$user_info['statuses_count']?></span>
                                </div><!-- /.user-block -->
                                <p> <?php echo $user_info['description']?></p>
                                <ul class="list-inline">
                                    <li><a href="javascript:void(0)" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> <?php _e('Followers');echo "({$user_info['followers']})"?></a></li>
                                    <li><a href="javascript:void(0)" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> <?php _e('Friends');echo "({$user_info['friends']})"?></a></li>

                                </ul>


                            </div>


                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="posts">
                            <!-- The timeline -->
                            <ul class="timeline timeline-inverse">
                                <!-- timeline time label -->
                                <?php foreach ($blog_posts as $post_key) {?>
                                    <li class="time-label">
                        <span class="bg-red">
                         <?php echo date('Y M d',strtotime($post_key['date']));?>
                        </span>
                                    </li>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <li id="article_<?php echo  $post_key['id'];?>">
                                        <i class="fa fa-rocket bg-blue"></i>
                                        <div class="timeline-item">
                                            <input type="hidden" id="title_<?php echo  $post_key['id'];?>" value="<?php echo $post_key['title'];?>">
                                            <input type="hidden" id="message_<?php echo  $post_key['id'];?>" value="<?php echo $post_key['message'];?>">
                                            <input type="hidden" id="img_<?php echo  $post_key['id'];?>" value="<?php echo $post_key['img'];?>">
                                            <input type="hidden" id="url_<?php echo  $post_key['id'];?>" value="<?php echo $post_key['url'];?>">
                                        <span class="time">
                                            <i class="fa fa-clock-o"></i> <?php echo date('h:i',strtotime($post_key['date']));?></span>
                                            <h3 class="timeline-header">
                                                <a href="<?php echo $post_key['url'];?>" target="_blank">
                                                    <?php echo $post_key['title'];?>
                                                </a>
                                            </h3>
                                            <div class="timeline-body">
                                                <?php echo $post_key['message'];?>
                                                <?php if ($post_key['img']!=''){?>
                                                    <img src="<?php echo $post_key['img']?>" alt="<?php echo $post_key['title']?>" class="margin"/>
                                                <?php }?>
                                            </div>
                                            <div class="timeline-footer">
                                                <a class="btn btn-primary btn-xs post_id" data-id="<?php echo  $post_key['id'];?>"><?php _e('Send To twitter') ?></a>
                                            </div>
                                        </div>
                                    </li>
                                <?php }?>

                                <li id="load-more-li">
                                    <a href="javascript:void(0)" id="load-more" data-offset="10"><i class="fa fa-clock-o bg-gray"> <?php _e('Load More')?></i></a>
                                </li>
                            </ul>
                        </div><!-- /.tab-pane -->

                        <div class="tab-pane" id="settings">

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
                                        <input type="text" class="form-control" id="access_token" name="access_token" value="<?php echo $socialKeys['access_token'] ?>" placeholder="<?php _e('Access Token')?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label"><?php _e('Token Secret')?></label>
                                    <div class="col-sm-10">
                                        <p style="display: none;">
                                            <i class="fa fa-times-circle-o"></i>
                                            <?php _e('You cant leave it empty');?>
                                        </p>
                                        <input type="text" class="form-control" id="token_secret" name="token_secret" value="<?php echo $socialKeys['token_secret'] ?>" placeholder="<?php _e('Token Secret')?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label"><?php _e('Consumer Key')?></label>
                                    <div class="col-sm-10">
                                        <p style="display: none;">
                                            <i class="fa fa-times-circle-o"></i>
                                            <?php _e('You cant leave it empty');?>
                                        </p>
                                        <input type="text" class="form-control" id="consumer_key"  value="<?php echo $socialKeys['consumer_key'] ?>" name="consumer_key" placeholder="<?php _e('Consumer Key')?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputExperience" class="col-sm-2 control-label"><?php _e('Consumer Secret')?></label>
                                    <div class="col-sm-10">
                                        <p style="display: none;">
                                            <i class="fa fa-times-circle-o"></i>
                                            <?php _e('You cant leave it empty');?>
                                        </p>
                                        <input class="form-control" id="consumer_secret" name="consumer_secret" value="<?php echo $socialKeys['consumer_secret']?>" placeholder="<?php _e('Consumer Secret')?>"/>
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
                                <?php _e('Twitter credential is saved ');?>
                            </div>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
        </div><!-- /.row -->

    </section><!-- /.content -->
</div>
<script>
    jQuery(document).ready(function(){
        jQuery(".select2").select2();
    });
    jQuery(document).on('click','#load-more',function (){
        var offset=jQuery(this).attr('data-offset'),
            data={
                'offset':offset,
                'action':'get_posts',
                'social_name':'twitter'
            };
        jQuery.ajax({
                url:"admin-ajax.php",
                data:data,
                type:'POST',
                dataType:'json'
            })
            .done(function(posts) {


                jQuery.each(posts.data,function(key,val){
                    var html='<li id="article_'+val.id+'"><i class="fa fa-rocket bg-blue"></i><div class="timeline-item">'+
                        '<input type="hidden" id="title_'+val.id+'" value="'+val.title+'">'+
                        '<input type="hidden" id="message_'+val.id+'" value="'+val.message+'">'+
                        '<input type="hidden" id="img_'+val.id+'" value="'+val.img+'">'+
                        '<input type="hidden" id="url_'+val.id+'" value="'+val.url+'">'+
                        '<span class="time">'+
                        '<i class="fa fa-clock-o"></i>'+val.date+'</span>'+
                        '<h3 class="timeline-header">'+
                        '<a href="'+val.url+'" target="_blank">'+val.title+'</a></h3>'+
                        '<div class="timeline-body">'+val.message;
                    if(val.img!=false)
                        html+='<img src="'+val.img+'" alt="'+val.title+'" class="margin"/>';

                    html+='</div>'+
                        '<div class="timeline-footer">'+
                        '<a class="btn btn-primary btn-xs post_id" data-id="'+val.id+'"><?php _e('Send To Twitter') ?></a>'+
                        '</div>'+
                        '</div>'+
                        '</li>';
                    jQuery("#load-more-li").before(html);


                });
                jQuery(".select2").select2();
            });

    });
    jQuery(document).on('click','.post_id',function (){
        var postID=jQuery(this).attr('data-id'),
            title=jQuery('#title_'+postID).val(),
            message=jQuery('#message_'+postID).val(),
            url=jQuery('#url_'+postID).val(),
            img=jQuery('#img_'+postID).val(),
            page=jQuery('#pages_'+postID).val(),
            tokens=[],
            data={
                'id':postID,
                'title':title,
                'message':message,
                'url':url,
                'img':img,
                'page':page,
                'action':'send_to_twitter'
            };
        jQuery("#pages_"+postID).find("option:selected").each(function(){
            tokens.push(jQuery(this).attr('data-token'));
        });
        data['token']=tokens;
        jQuery.ajax({
                url:"admin-ajax.php",
                data:data,
                type:'POST',
                dataType:'json'
            })
            .done(function(posts) {
                if(posts.success){
                    jQuery('#article_'+postID).remove();
                }
            });



    });
    jQuery(document).on('click','#logout-twitter',function (){
        jQuery.ajax({
                url:"admin-ajax.php",
                data:{action:'twitter_logout'},
                type:'POST'
            })
            .done(function() {

                window.location.reload();

            })
            .fail(function() {

            })
            .always(function() {

            });
        return false;
    });
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
