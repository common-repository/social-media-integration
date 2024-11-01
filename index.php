<?php
/**
 * Plugin Name: Social Integration
 * Plugin URI: http://www.hamzaalayed.com/
 * Version: 0.8.2.2
 * Author URI: http://www.hamzaalayed.com/
 * Author: Hamza Alayed
 * Description: Integrate your WP with social media
 * PHP version 5.6
 *
 */

/**
 * Class SocialIntegration
 * @author Hamza alayed <developerh108@gmail.com>
 */
class HMDSocialIntegration
{
    private $_pluginName='Social Integration';
    private $_pluginSlug='social-integration';
    /**
     * SocialIntegration constructor.
     */
    function __construct()
    {

//        session_start();
//        session_destroy();
        if (!defined('PHP_VERSION_ID')) {
            $version = explode('.', PHP_VERSION);

            define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
        }




        $_GET['model']=isset($_GET['model'])?$_GET['model']:'facebook';
        define('PLUGIN_DIR', dirname(__FILE__).'/');
        define('PLUGIN_URL', plugins_url()."/{$this->_pluginSlug}/");
        add_action('admin_menu', array($this, 'hmd_add_menu'));
        add_action('init', array($this, 'register_session'));
        add_action('admin_enqueue_scripts', array($this, 'register_script'));
        add_action('wp_ajax_save_settings', array($this, 'hmd_save_settings'));
        add_action('wp_ajax_send_to_facebook', array($this, 'hmd_send_to_facebook'));
        add_action('wp_ajax_facebook_logout', array($this, 'hmd_facebook_logout'));
        add_action('wp_ajax_twitter_logout', array($this, 'hmd_twitter_logout'));
        add_action('wp_ajax_send_to_twitter', array($this, 'hmd_send_to_twitter'));
        add_action('wp_ajax_get_posts', array($this, 'hmd_get_posts'));
        add_action('wp_ajax_send_to_developer', array($this, 'hmd_send_to_developer'));
        register_activation_hook(__FILE__, array($this, 'hmd_install' ));
        register_deactivation_hook(__FILE__, array($this, 'hmd_uninstall'));
    }
    /**
     * Actions perform at loading of admin menu
     * @return void
     */
    function hmd_add_menu()
    {

        if (PHP_VERSION_ID >= 50400 && extension_loaded('mbstring')) {
            add_menu_page(
                $this->_pluginName,
                $this->_pluginName,
                'manage_options',
                $this->_pluginSlug,
                null,
                'dashicons-share',
                '2.2.9'
            );

            add_submenu_page(
                null,
                $this->_pluginName.'-twitter',
                $_GET['model'],
                'manage_options',
                $this->_pluginSlug.'-twitter',
                array(__CLASS__, 'hmd_set_twitter')
            );
            if (isset($_GET['model'])) {
                $model='hmd_'.$_GET['model'];

                if (method_exists($this, $model)) {

                    add_submenu_page(
                        null,
                        $this->_pluginName . $_GET['model'],
                        $_GET['model'],
                        'manage_options',
                        $this->_pluginSlug,
                        array(__CLASS__, $model)
                    );

                }
            }
        } else {
            add_menu_page(
                $this->_pluginName,
                $this->_pluginName,
                'manage_options',
                $this->_pluginSlug,
                null,
                'dashicons-share',
                '2.2.9'
            );
            add_submenu_page(
                null,
                $this->_pluginName . 'Not Working',
                $_GET['model'],
                'manage_options',
                $this->_pluginSlug,
                array(__CLASS__, 'hmd_not_working')
            );
        }

    }
    /**
     * Register jquery and style on initialization
     */
    function hmd_load_model() {


    }
    /**
     * Register jquery and style on initialization
     */
    public static  function hmd_set_twitter() {
        $_SESSION['hmd_oauth_token2']=$_GET['oauth_token'];
        $_SESSION['hmd_oauth_verifier']=$_GET['oauth_verifier'];
        //$_SESSION['hmd_token_secret']=$_GET['oauth_token'];

        //TODO include one time
        include_once "core/View.php";
        /* @var $view View */
        $data['page']='go_to';

        $data['data']['model']=__('twitter');
        $data['data']['link']='admin.php?page=social-integration&model=twitter';

        $view->load('theme', $data);


       // wp_redirect('admin.php?page=social-integration&model=twitter');
    }

    /**
     * Register jquery and style on initialization
     */
    function register_script() {

        //  wp_enqueue_script('jquery-2', plugins_url('js/plugins/jQuery/jQuery-2.1.4.min.js', __FILE__));
        wp_enqueue_script('bootstrap', plugins_url('js/bootstrap.js', __FILE__));

        wp_enqueue_script('app', plugins_url('js/app.js', __FILE__));
        wp_enqueue_script('select2', plugins_url('js/plugins/select2/select2.full.min.js', __FILE__));

        wp_enqueue_script('demo', plugins_url('js/demo.js', __FILE__));

        wp_enqueue_style('bootstrap', plugins_url('css/bootstrap.min.css', __FILE__));
        wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
        wp_enqueue_style('ionicframework', 'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');
        wp_enqueue_style('AdminLTE', plugins_url('css/AdminLTE.css', __FILE__));
        wp_enqueue_style('Skins', plugins_url('css/skins/_all-skins.min.css', __FILE__));
        wp_enqueue_style('custom', plugins_url('css/custom.css', __FILE__));
        wp_enqueue_style('select2', plugins_url('js/plugins/select2/select2.min.css', __FILE__));

    }


    /**
     * Start session function
     * @return void
     */
    function register_session()
    {
        if(!is_dir (ini_get ('session.save_path'))){
            @mkdir (ABSPATH.'/tmp', 0777, true);
            $myfile = @fopen(ABSPATH.'/tmp/index.php', "w");
            $html='<?php header("Location: http://".$_SERVER["SERVER_NAME"]); ?>';
            @fwrite($myfile, $html);
            @fclose($myfile);

            ini_set ('session.save_path', ABSPATH.'tmp');
        }
        if (!session_id()) {
            session_start();
        }
    }


    /**
     * Actions perform on loading of menu pages
     * @return void
     */
    public static function hmd_twitter()
    {

        include_once 'lib/Twitter/autoload.php';
        include_once 'models/HMDTwitter.php';
        include_once 'core/Database.php';
        /* @var $db Database */
        $socialKeys=$db->get_social_var('twitter');
        $posts=$db->wp_posts(0, 'twitter');

        include_once "core/View.php";
        /* @var $view View */
        if (isset($socialKeys['access_token'])&&isset($socialKeys['token_secret'])&&isset($socialKeys['consumer_key'])&&isset($socialKeys['consumer_secret'])) {
            if(!empty($socialKeys['access_token'])&&!empty($socialKeys['token_secret'])&&!empty($socialKeys['consumer_key'])&&!empty($socialKeys['consumer_secret'])){
                $TwitterObj=new HMDTwitter();
                $TwitterObj->setKey($socialKeys['consumer_key']);
                $TwitterObj->setSecretToken($socialKeys['token_secret']);
                $TwitterObj->setToken($socialKeys['access_token']);
                $TwitterObj->setSecret($socialKeys['consumer_secret']);
                $TwitterObj->setTwitter();
                $isLogin=$TwitterObj->isLogged;
                if (!$isLogin) {

                    //TODO include one time
                    include_once "core/View.php";
                    /* @var $view View */
                    $data['page']='not_connected';
                    $data['data']['model']=__('twitter');
                    $data['data']['link']=$TwitterObj->getLoginLink();

                    $data['data']['socialKeys']=$socialKeys;

                    $view->load('theme', $data);

                } else {
                    //TODO include one time
                    include_once "core/View.php";
                    /* @var $view View */
                    $data['page']='twitter';
                    $data['data']['blog_posts']=$posts;
                    $data['data']['user_info']=$TwitterObj->getUserInfo();
                    // $data['data']['user_pages']=$TwitterObj->getUserPages();
                    $data['data']['socialKeys']=$socialKeys;

                    $view->load('theme', $data);

                }
            }else{

                //TODO include one time
                include_once "core/View.php";
                /* @var $view View */
                $data['page']='not_connected';
                $data['data']['model']=__('twitter');
                $data['data']['link']="#";

                $data['data']['socialKeys']=$socialKeys;

                $view->load('theme', $data);
            }

        }else{

            //TODO include one time
            include_once "core/View.php";
            /* @var $view View */
            $data['page']='not_connected';
            $data['data']['model']=__('twitter');
            $data['data']['link']="#";

            $data['data']['socialKeys']=$socialKeys;

            $view->load('theme', $data);
        }
    }
    /**
     * Actions perform on loading of menu pages
     * @return void
     */
    public static function hmd_thanks()
    {
        //TODO include one time
        include_once "core/View.php";
        /* @var $view View */
        $data['page']='thanks';
        $view->load('theme', $data);
    }
    /**
     * Actions perform on loading of menu pages
     * @return void
     */
    public static function hmd_to_developer()
    {
        //TODO include one time
        include_once "core/View.php";
        /* @var $view View */
        $data['page']='ask_me';
        $view->load('theme', $data);
    }
    /**
     * Actions perform on loading of menu pages
     * @return void
     */
    public static function hmd_not_working()
    {
        //TODO include one time
        include_once "core/View.php";
        /* @var $view View */
        $data['data']['php_version']=PHP_VERSION_ID >= 50400;
        $data['data']['mbstring']=!extension_loaded('mbstring');
        $data['page']='not_working';
        $view->load('theme', $data);
    }
    /**
     * Actions perform on loading of menu pages
     * @return void
     */
    public static function hmd_facebook()
    {
        include_once 'lib/Facebook/autoload.php';
        include_once 'models/HMDFacebook.php';

        include_once 'core/Database.php';
        /* @var $db Database */
        $socialKeys=$db->get_social_var('facebook');
        $posts=$db->wp_posts(0, 'facebook');

        if (isset($socialKeys['appid'])&&isset($socialKeys['secret'])) {
            $FacebookObj=new HMDFacebook();
            $FacebookObj->_setAppID($socialKeys['appid']);
            $FacebookObj->_setCanvasLink($socialKeys['url']);
            $FacebookObj->_setSecret($socialKeys['secret']);
            $FacebookObj->_setNameSpace($socialKeys['namespace']);
            $FacebookObj->setFacebook();
            $isLogin=$FacebookObj->isLogged;
            if (!$isLogin) {
                //TODO include one time
                include_once "core/View.php";
                /* @var $view View */
                $data['page']='not_connected';
                $data['data']['model']=__('facebook');
                $data['data']['link']=$FacebookObj->getLoginLink();

                $data['data']['socialKeys']=$socialKeys;

                $view->load('theme', $data);
            } else {
                //TODO include one time
                include_once "core/View.php";
                /* @var $view View */
                $data['page']='facebook';
                $data['data']['blog_posts']=$posts;
                $data['data']['user_info']=$FacebookObj->getUserInfo();
                $data['data']['user_pages']=$FacebookObj->getUserPages();
                $data['data']['socialKeys']=$socialKeys;

                $view->load('theme', $data);

            }
        }else{
            //TODO include one time
            include_once "core/View.php";
            /* @var $view View */
            $data['page']='not_connected';
            $data['data']['model']=__('facebook');
            $data['data']['link']="#";

            $data['data']['socialKeys']=$socialKeys;


            $view->load('theme', $data);
        }


    }

    /**
     * Actions perform on loading of menu pages
     * @return void
     */
    public static function hmd_settings()
    {
        //TODO include one time
        include_once "core/View.php";
        /* @var $view View */

        $view->load('theme', array('page'=>'settings'));


    }
    /**
     * Actions perform on loading of menu pages
     * @return void
     */
    public static function hmd_save_settings()
    {
        $result['success']=false;
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if(isset($_POST['social'])){
                switch ($_POST['social']){
                    case 'facebook':
                        if(isset($_POST['appid']) && isset($_POST['secret']) && isset($_POST['namespace']) && isset($_POST['url']) ){
                            include_once 'core/Database.php';
                            /* @var $db Database */
                            $data['appid']=$_POST['appid'];
                            $data['secret']=$_POST['secret'];
                            $data['namespace']=$_POST['namespace'];
                            $data['url']=$_POST['url'];
                            $db->saveSocialKey($_POST['social'], $data);

                            $result['success']=true;
                        }
                    case 'twitter':
                        if(isset($_POST['access_token']) && isset($_POST['token_secret']) && isset($_POST['consumer_key']) && isset($_POST['consumer_secret']) ){
                            include_once 'core/Database.php';
                            /* @var $db Database */
                            $data['access_token']=$_POST['access_token'];
                            $data['token_secret']=$_POST['token_secret'];
                            $data['consumer_key']=$_POST['consumer_key'];
                            $data['consumer_secret']=$_POST['consumer_secret'];
                            $db->saveSocialKey($_POST['social'], $data);

                            $result['success']=true;
                        }
                }
            }
        }
        echo json_encode($result);
        wp_die();
    }

    public static function hmd_send_to_twitter() {
        $result['success'] = false;
        if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
            if ( isset( $_POST['id'] ) ) {
                include_once 'lib/Twitter/autoload.php';
                include_once 'models/HMDTwitter.php';
                include_once 'core/Database.php';
                /* @var $db Database */
                $socialKeys=$db->get_social_var('twitter');
                $TwitterObj=new HMDTwitter();
                $TwitterObj->setKey($socialKeys['consumer_key']);
                $TwitterObj->setSecretToken($socialKeys['token_secret']);
                $TwitterObj->setToken($socialKeys['access_token']);
                $TwitterObj->setSecret($socialKeys['consumer_secret']);
                if (isset($socialKeys['access_token'])&&isset($socialKeys['token_secret'])&&isset($socialKeys['consumer_key'])&&isset($socialKeys['consumer_secret'])) {
                    $TwitterObj->setTwitter();
                    $isLogin=$TwitterObj->isLogged;
                    if ($isLogin) {
                        $TwitterObj->send_to_account($_POST,$db);
                        echo json_encode(array('success'=>true));
                        wp_die();
                    }

                }
            }
        }
    }
    public static function hmd_facebook_logout(){
        unset($_SESSION['hmd_fb_token']);
        echo json_encode(array('success'=>true));
        wp_die();
    }
    public static function hmd_twitter_logout(){
        unset($_SESSION['hmd_oauth_token2']);
        unset($_SESSION['hmd_oauth_verifier']);
        unset($_SESSION['hmd_oauth_token']);
        unset($_SESSION['hmd_access_token']);
        echo json_encode(array('success'=>true));
        wp_die();
    }
    public static function hmd_send_to_facebook() {
        $result['success'] = false;
        if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
            if (isset($_POST['id'])) {
                include_once 'lib/Facebook/autoload.php';
                include_once 'models/HMDFacebook.php';
                include_once 'core/Database.php';
                /* @var $db Database */
                $socialKeys=$db->get_social_var('facebook');
                $FacebookObj=new HMDFacebook();
                $FacebookObj->_setAppID($socialKeys['appid']);
                $FacebookObj->_setCanvasLink($socialKeys['url']);
                $FacebookObj->_setSecret($socialKeys['secret']);
                $FacebookObj->_setNameSpace($socialKeys['namespace']);
                if (isset($socialKeys['appid'])&&isset($socialKeys['secret'])) {
                    $FacebookObj->setFacebook();
                    $isLogin=$FacebookObj->isLogged;
                    if ($isLogin) {
                        $FacebookObj->send_to_page($_POST,$db);
                        echo json_encode(array('success'=>true));
                        wp_die();
                    }
                }
            }
        }
    }


    /**
     *
     */
    public static function hmd_get_posts()
    {
        $offset=0;
        if (isset($_POST['offset'])) {
            $offset=intval($_POST['offset']);
        }
        $social_name=$_POST['social_name'];
        include_once 'core/Database.php';
        /* @var $db Database */
        $posts['data']=$db->wp_posts($offset,$social_name);
//        print_r($posts);
        echo json_encode($posts);
        wp_die();
    }

    /**
     * @return mixed
     */
    function custom_wp_mail_from_name()
    {
        return $_POST['name'];
    }

    /**
     * @return mixed
     */
    function custom_wp_mail_from()
    {
        //Make sure the email is from the same domain
        //as your website to avoid being marked as spam.
        return $_POST['email'];
    }


    /**
     *
     */
    public  function hmd_send_to_developer()
    {
        $subject=$_POST['request'];
        $message ='Request : '.$_POST['request']."\n";
        $message.='Name : '.$_POST['name']."\n";
        $message.='E-Mail : '.$_POST['email']."\n";
        $message.='Website : '.$_POST['url']."\n";
        $message.='Subject : '.$_POST['subject']."\n";
        add_filter('wp_mail_from_name',  array($this,'custom_wp_mail_from_name'));
        add_filter('wp_mail_from', array($this,'custom_wp_mail_from'));
        $res=wp_mail('developerh108@gmail.com', $subject, $message);
        echo json_encode(array('success'=>$res));
        wp_die();
    }
    /**
     * Actions perform on activation of plugin
     * @return void
     */
    public static function hmd_install()
    {
        include_once 'core/Database.php';
        /* @var $db Database */
        $db->runCreate();

    }

    /**
     * Actions perform on de-activation of plugin
     * @return void
     */
    public static function hmd_uninstall()
    {



    }


}
new HMDSocialIntegration();