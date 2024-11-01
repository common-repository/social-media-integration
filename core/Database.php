<?php

/**
 * Created by PhpStorm.
 * User: DeveloperH
 * Date: 1/28/16
 * Time: 3:44 PM
 */
class Database
{
    private $_prefix='';
    private $_dbObj;
    private $_hmd_db_version="1.0.0";
    private $_social_keys='';
    private $_social_To_Post='';
    /**
     * Database constructor.
     */
    function __construct()
    {
        global $wpdb;
        global $hmd_db_version;
        $hmd_db_version = $this->_hmd_db_version;

        $this->_dbObj=$wpdb;
        $this->_prefix=$wpdb->base_prefix;
        $this->_social_keys="{$wpdb->base_prefix}social_keys";
        $this->_social_To_Post="{$wpdb->base_prefix}social_to_post";

    }

    private function _createSocialKeys() {
        $isExist=$this->_dbObj->get_var("show tables like '{$this->_social_keys}'");
        if ($isExist != $this->_social_keys) {
            $sql = "
            CREATE TABLE IF NOT EXISTS `{$this->_social_keys}` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `blog_id` int(5) NOT NULL,
              `social_name` varchar(50) NOT NULL DEFAULT '',
              `keys` varchar(100) NOT NULL DEFAULT '',
              `values` varchar(300) NOT NULL DEFAULT '',
              `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp,
              `updated_at` TIMESTAMP NOT NULL DEFAULT 0,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Table with social integration keys' AUTO_INCREMENT=1 ;
         ";
            include_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql, true);
            add_option('hmd_db_version', $this->_hmd_db_version);
        }
    }
    private function _createSocialToPost() {
        $isExist=$this->_dbObj->get_var("show tables like '{$this->_social_To_Post}'");
        if ($isExist != $this->_social_To_Post) {
            $sql = "
            CREATE TABLE IF NOT EXISTS `{$this->_social_To_Post}` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `blog_id` int(5) NOT NULL,
              `social_name` varchar(50) NOT NULL DEFAULT '',
              `social_post` varchar(100) NOT NULL DEFAULT '',
              `wp_post` varchar(300) NOT NULL DEFAULT '',
              `page_id` varchar(300) NOT NULL DEFAULT '',
              `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp,
              `updated_at` TIMESTAMP NOT NULL DEFAULT 0,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Table to connect social post with wordpress post' AUTO_INCREMENT=1 ;
         ";
            include_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql, true);
            add_option('hmd_db_version', $this->_hmd_db_version);
        }
    }

    /**
     * @param string $social_name
     * @param array $data
     */
    public function saveSocialKey($social_name='',$data=array())
    {
        $current_blog = $this->_dbObj->blogid;
        foreach ($data as $key=>$val) {
            $insertData=array(
                'social_name'=>$social_name,
                'keys'=>$key,
                'values'=>$val,
                'blog_id'=>$current_blog,
                'updated_at'=>date('Y-m-d h:i:s', time())
            );
            $updateData=array(
                'values'=>$val,
                'updated_at'=>date('Y-m-d h:i:s', time())
            );
            $whereData=array(
                'social_name'=>$social_name,
                'keys'=>$key,
                'blog_id'=>$current_blog
            );

            $isExist = $this->_dbObj
                ->get_var(
                    "SELECT COUNT(*) FROM {$this->_social_keys}
                     where blog_id={$current_blog} and
                     `keys`='{$key}' and
                     social_name='{$social_name}'"
                );


            if (intval($isExist==0)) {
                $this->_dbObj
                    ->insert($this->_social_keys, $insertData);
            } else {
                $this->_dbObj
                    ->update($this->_social_keys, $updateData, $whereData);
            }

        }

    }/**
 * @param string $social_name
 * @param array $data
 */
    public function saveSocialToPost($social_name='',$data=array())
    {
        $insertData=array(
            'social_name'=>$social_name,
            'social_post'=>$data['social_post'],
            'wp_post'=>$data['wp_post'],
            'page_id'=>$data['page_id'],
            'blog_id'=>$this->_dbObj->blogid,
            'updated_at'=>date('Y-m-d h:i:s', time())
        );

        $this->_dbObj
            ->insert($this->_social_To_Post, $insertData);



    }


    /**
     * @param string $social_name
     */
    public function get_social_var($social_name='')
    {
        $data=array();
        if($social_name!=''){
            $current_blog = $this->_dbObj->blogid;
            $result=$this->
            _dbObj->get_results(
                " SELECT `keys`,`values` FROM {$this->_social_keys}
                     where blog_id={$current_blog} and
                     social_name='{$social_name}'"
            );

            foreach ($result as $key){
                $data[$key->keys]=$key->values;
            }

        }
        return $data;
    }

    /**
     * @param int $offset
     *
     * @return array
     */
    function wp_posts($offset=0,$social_name='facebook')
    {

        $current_blog = $this->_dbObj->blogid;
//        $exclude_posts = $this->_dbObj->get_col(
//            "SELECT wp_post FROM {$this->_social_To_Post}
//             where blog_id={$current_blog} and social_name='{$social_name}'"
//        );


        $arg=array('post_type'      => 'post',
                   'post_status'    => 'publish',
                   'meta_query'     => array(),
                   'offset'=> $offset,
            //TODO change to make dynamic
                   'showposts' => 15
        );
        $exclude_posts =array();
        if (count($exclude_posts)) {
            $arg['post__not_in']=$exclude_posts;
        }
        $wp_posts=query_posts($arg);
        $posts=array();

        /* @var $key  WP_Post*/
        foreach ($wp_posts as $key) {
            $tmp=array();

            $msg=substr(
                strip_tags(
                    apply_filters('the_content', $key->post_content)
                ), 0, 200
            );

            $tmp['id']=$key->ID;
            $tmp['title']=$key->post_title;
            $tmp['date']=$key->post_date;
            $tmp['url']=get_permalink($key->ID);
            $tmp['img']=get_the_post_thumbnail_url($key->ID);
            $tmp['message']=mb_convert_encoding($msg, 'UTF-8');
            array_push($posts, $tmp);

        }
        return $posts;

    }

    /**
     * this function not using anymore
     */
    function installDB()
    {

        if (is_multisite()) {
            // store the current blog id
            $current_blog = $this->_dbObj->blogid;
            // Get all blogs in the network and activate plugin on each one
            $blog_ids = $this->_dbObj->get_col("SELECT blog_id FROM {$this->_dbObj->blogs}");

            foreach ( $blog_ids as $blog_id ) {
                switch_to_blog($blog_id);
                $this->runCreate();
                restore_current_blog();
            }
        } else {
            $this->runCreate();
        }
    }

    /**
     * this function not using anymore
     */
    function on_create_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
        if (is_plugin_active_for_network('social-integration/index.php')) {
            switch_to_blog($blog_id);
            $this->runCreate();
            restore_current_blog();
        }
    }

    public function runCreate(){
        $this->_createSocialKeys();
        $this->_createSocialToPost();
    }


}
$db=new Database();