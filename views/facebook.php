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
if (!isset($user_info)) {
    $user_info['picture']['url']=PLUGIN_URL.'img/avatar6.png';
    $user_info['first_name']=__('You are not connected to facebook');
    $user_info['education']=[];
    $user_info['groups']=[];
    $user_info['events']=[];
}
if(!isset($user_info['groups'])){
    $user_info['groups']=[];
}
if(!isset( $user_info['events'])){
    $user_info['events']=[];
}
if(!isset( $user_info['education'])){
    $user_info['education']=[];
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php _e('Facebook')?>
            <small><?php _e('Version')?> 0.5</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> <?php _e('Home')?></a></li>
            <li class="active"><?php _e('Facebook')?></li>
            <li><a id="logout-facebook" class="btn btn-danger"><?php _e('Logout Facebook')?></a></li>
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
                            <h3><?php _e('Facebook Pages')?></h3>
                            <!-- Post -->
                            <?php foreach($user_pages as $key){?>
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm"
                                             src="<?php echo $key['picture']['url']?>"
                                             alt="<?php echo $key['name']?>"/>
                                    <span class='username'>
                                      <a href="javascript:void(0)"><?php echo $key['name']?></a>
                                    </span>
                                        <span class='description'><?php echo $key['category']?></span>
                                    </div><!-- /.user-block -->
                                    <p> <?php echo $key['about']?></p>
                                    <ul class="list-inline">
                                        <li><a href="javascript:void(0)" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> <?php _e('Talking about');echo "({$key['talking_about_count']})"?></a></li>
                                        <li><a href="javascript:void(0)" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> <?php _e('like');echo "({$key['likes']})"?></a></li>

                                    </ul>


                                </div>
                            <?php }?>
                            <h3><?php _e('Facebook Groups')?></h3>
                            <?php foreach($user_info['groups'] as $group){?>
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm"
                                             src="<?php echo $group['cover']['source']?>"
                                             alt="<?php echo $group['name']?>"/>
                                    <span class='username'>
                                      <a href="javascript:void(0)"><?php echo $group['name']?></a>
                                    </span>
                                        <span class='description'><?php _e('Owner');echo ' : '.$group['owner']['name']?></span>
                                    </div><!-- /.user-block -->
                                    <p> <?php echo $group['description']?></p>
                                    <ul class="list-inline">
                                        <li><a href="javascript:void(0)" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> <?php _e('Member Request Count');echo "({$group['member_request_count']})"?></a></li>
                                        <li><a href="javascript:void(0)" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> <?php _e('Group Unread');echo "({$group['unread']})"?></a></li>

                                    </ul>


                                </div>
                            <?php }?>
                            <h3><?php _e('Facebook Events')?></h3>
                            <?php foreach($user_info['events'] as $event){?>
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm"
                                             src="<?php echo (isset($event['cover']))?$event['cover']['sorce']:$user_info['picture']['url'];?>"
                                             alt="<?php echo $event['name']?>"/>
                                    <span class='username'>
                                      <a href="javascript:void(0)"><?php echo $event['name']?></a>
                                    </span>
                                        <span class='description'><?php _e('Owner');echo ' : '.$event['owner']['name']?></span>
                                    </div><!-- /.user-block -->
                                    <p> <?php echo $event['description']?></p>
                                    <ul class="list-inline">
                                        <li><a href="javascript:void(0)" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> <?php _e('Attending Count');echo "({$event['attending_count']})"?></a></li>
                                        <li><a href="javascript:void(0)" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> <?php _e('Interested Count');echo "({$event['interested_count']})"?></a></li>
                                        <li><a href="javascript:void(0)" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> <?php _e('Maybe Count');echo "({$event['maybe_count']})"?></a></li>

                                    </ul>


                                </div>
                            <?php }?>
                            <h3><?php _e('Facebook User Profile')?></h3>
                            <div class="post">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm"
                                         src="<?php echo $user_info['picture']['url']?>"
                                         alt="<?php echo $user_info['name']?>"/>
                                    <span class='username'>
                                      <a href="javascript:void(0)"><?php echo $user_info['name']?></a>
                                    </span>
                                    <span class='description'><?php _e('User Profile')?></span>
                                </div><!-- /.user-block -->
                                <p> <?php echo $user_info['work'][0]['position']['name']?></p>
                                <ul class="list-inline">
                                    <li><a href="javascript:void(0)" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> <?php _e('Talking about');echo "(0)"?></a></li>
                                    <li><a href="javascript:void(0)" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> <?php _e('like');echo "(0)"?></a></li>

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
                                                <label><?php _e('Facebook Page')?></label>
                                                <select class="form-control select2" id="pages_<?php echo  $post_key['id'];?>" multiple="multiple" data-placeholder="<?php _e('Page to publish')?>(<?php _e('Multiple Selection')?>)" style="width: 100%;">
                                                    <?php foreach($user_pages as $key){?>
                                                        <option value="<?php echo $key['id']?>" data-token="<?php echo $key['access_token']?>"><?php echo $key['name']?></option>

                                                    <?php } ?>
                                                    <?php foreach($user_info['groups'] as $group){?>
                                                        <option value="<?php echo $group['id']?>" data-token="<?php echo $_SESSION['hmd_fb_token'];?>"><?php echo $group['name']?></option>

                                                    <?php } ?>
                                                    <?php foreach($user_info['events'] as $event){?>
                                                        <option value="<?php echo $event['id']?>" data-token="<?php echo $_SESSION['hmd_fb_token'];?>"><?php echo $event['name']?></option>

                                                    <?php } ?>
                                                    <option value="me" data-token="<?php echo $_SESSION['hmd_fb_token'];?>"><?php _e('My Profile')?></option>

                                                </select>
                                                <a class="btn btn-primary btn-xs post_id" data-id="<?php echo  $post_key['id'];?>"><?php _e('Send To Facebook') ?></a>
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
                                        <input type="text" class="form-control" id="appid" name="appid" value="<?php echo $socialKeys['appid'] ?>" placeholder="<?php _e('App ID')?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label"><?php _e('App Secret')?></label>
                                    <div class="col-sm-10">
                                        <p style="display: none;">
                                            <i class="fa fa-times-circle-o"></i>
                                            <?php _e('You cant leave it empty');?>
                                        </p>
                                        <input type="text" class="form-control" id="secret" name="secret" value="<?php echo $socialKeys['secret'] ?>" placeholder="<?php _e('App Secret')?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label"><?php _e('Namespace')?></label>
                                    <div class="col-sm-10">
                                        <p style="display: none;">
                                            <i class="fa fa-times-circle-o"></i>
                                            <?php _e('You cant leave it empty');?>
                                        </p>
                                        <input type="text" class="form-control" id="namespace"  value="<?php echo $socialKeys['namespace'] ?>" name="namespace" placeholder="<?php _e('Namespace')?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputExperience" class="col-sm-2 control-label"><?php _e('Valid OAuth redirect URIs')?></label>
                                    <div class="col-sm-10">
                                        <p style="display: none;">
                                            <i class="fa fa-times-circle-o"></i>
                                            <?php _e('You cant leave it empty');?>
                                        </p>
                                        <textarea class="form-control" id="url" name="url" placeholder="<?php _e('Valid OAuth redirect URIs')?>"><?php echo $socialKeys['url'] ?></textarea>
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
                                <?php _e('Facebook credential is saved ');?>
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
                'social_name':'facebook'
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
                        '<label><?php _e('Facebook Page')?></label>'+
                        '<select class="form-control select2" id="pages_'+val.id+'" multiple="multiple" data-placeholder="<?php _e('Page to publish')?>(<?php _e('Multiple Selection')?>)" style="width: 100%;">'+
                        '<?php foreach($user_pages as $key){?>'+
                        '<option value="<?php echo $key['id']?>" data-token="<?php echo $key['access_token']?>"><?php echo $key['name']?></option>'+

                        '<?php } ?>'+
                        '<?php foreach($user_info['groups'] as $group){?>'+
                        '<option value="<?php echo $group['id']?>" data-token="<?php echo $_SESSION['hmd_fb_token'];?>"><?php echo $group['name']?></option>'+

                        '<?php } ?>'+
                        '<?php foreach($user_info['events'] as $event){?>'+
                        '<option value="<?php echo $event['id']?>" data-token="<?php echo $_SESSION['hmd_fb_token'];?>"><?php echo $event['name']?></option>'+

                        '<?php } ?>'+
                        '<option value="me" data-token="<?php echo $_SESSION['hmd_fb_token'];?>"><?php _e('My Profile')?></option>'+

                        '</select>'+
                        '<a class="btn btn-primary btn-xs post_id" data-id="'+val.id+'"><?php _e('Send To Facebook') ?></a>'+
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
                'action':'send_to_facebook'
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

    jQuery(document).on('click','#logout-facebook',function (){
        jQuery.ajax({
                url:"admin-ajax.php",
                data:{action:'facebook_logout'},
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
