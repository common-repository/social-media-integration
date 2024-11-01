<?php

/**
 * Created by PhpStorm.
 * User: DeveloperH
 * Date: 1/25/16
 * Time: 11:22 PM
 */



/**
 * Class HMDFacebook
 */
class HMDFacebook
{
    private $_appID='';
    private $_appSecret='';
    private $_graphV='v2.5';
    private $_fb;
    public  $isLogged=false;
    private $_permissions = array(
        'public_profile',
        'user_friends',
        'email',
        'user_about_me',
        'user_status',
        'user_actions.books',
        'user_actions.fitness',
        'user_actions.music',
        'user_actions.news',
        'user_actions.video',
        //TODO get user action for specific apps
        'user_actions:hmd-health',
        'user_birthday',
        'user_education_history',
        'user_events',
        'user_games_activity',
        'user_hometown',
        'user_likes',
        'user_location',
        'user_managed_groups',
        'user_photos',
        'user_posts',
        'user_relationships',
        'user_relationship_details',
        'user_religion_politics',
        'user_tagged_places',
        'user_videos',
        'user_website',
        'user_work_history',
        'read_custom_friendlists',
        'read_insights',
        'read_audience_network_insights',
        'read_page_mailboxes',
        'manage_pages',
        'publish_pages',
        'publish_actions',
        'rsvp_event',
        'pages_show_list',
        'pages_manage_cta',
        'pages_manage_leads',
        'ads_read',
        'ads_management'
    );
    private $_canvasLink='';
    private $_namespace='';

    /**
     * HMDFacebook constructor.
     */
    function __construct()
    {

    }

    function setFacebook(){
        $this->_fb = new Facebook\Facebook(
            array(
                'app_id' => $this->_appID,
                'app_secret' => $this->_appSecret,
                'default_graph_version' => $this->_graphV,
            )
        );
        $code=isset($_GET['code'])?$_GET['code']:'';

        $token=$this->_getToken();

        if ($token!='') {
            $this->isLogged=true;
        } elseif ($code!='') {
            $this->_setToken();
        }

    }

    /**
     * @return string
     */
    private function _getToken(){
        //TODO Save token in DB
        return isset($_SESSION['hmd_fb_token']) ?$_SESSION['hmd_fb_token']:'';
    }
    /**
     * @return string
     */
    private function _setToken(){
        //TODO Save token in DB
        $helper = $this->_fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();


        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();

        }

        if (isset($accessToken)) {
            $this->isLogged=true;
            $_SESSION['hmd_fb_token'] = (string) $accessToken;
        }
        return isset($_SESSION['hmd_fb_token']) ?$_SESSION['hmd_fb_token']:'';
    }

    public function _setAppID($id){

        $this->_appID=$id;
    }
    public function _setNameSpace($namespace){

        $this->_namespace=$namespace;
    }
    public function _setCanvasLink($url){

        $this->_canvasLink=$url;
    }
    public function _setSecret($secret){
        $this->_appSecret=$secret;
    }

    /**
     * Get Facebook login link
     * @return string
     */
    public function getLoginLink()
    {
        $helper = $this->_fb->getRedirectLoginHelper();
        $loginUrl = $helper->getLoginUrl($this->_canvasLink, $this->_permissions);
        return $loginUrl;
    }

    /**
     *
     */
    public function getUserInfo()
    {
        $fields=array(
            'name',
            'first_name',
            'middle_name',
            'last_name',
            'picture.height(128)',
            'work',
            'education',
            'hometown',
            'events{attending_count,cover,description,id,interested_count,maybe_count,category,name,owner}',
            'groups{id,cover,description,name,owner,member_request_count,unread}'
        );
        $fields=implode(',',$fields);
        $this->_fb->setDefaultAccessToken($_SESSION['hmd_fb_token']);
        try {
            $response = $this->_fb->get('/me?fields='.$fields);
            $userNode = $response->getGraphUser();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        return $userNode->asArray();
    }
    public function getUserPages()
    {
        $fields= array(
            'about',
            'id',
            'name',
            'category',
            'likes',
            'talking_about_count',
            'access_token',
            'picture.width(128)'
        );
        $fields=implode(',',$fields);
        $this->_fb->setDefaultAccessToken($_SESSION['hmd_fb_token']);
        try {
            //TODO cahnge limit
            $response = $this->_fb->get("/me/accounts?fields={$fields}&limit=20");
            $userNode = $response->getGraphEdge();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        return $userNode->asArray();
    }

    private function _isLink($link=''){
        preg_match("/http:\/\/|https:\/\//", $link, $output_array);
        return isset($output_array[0]);
    }

    /**
     * @param array $data
     * @param $db
     */
    public function send_to_page($data=array(), $db)
    {
        /* @var $db Database */
        $post_data=array(
            'message' => $data['message'],
            'link' => $data['url'],
            'picture' => $data['img'],
            'name' => $data['title']
        );
        $pages=$data['page'];
        $tokens=$data['token'];
        for ($i=0;$i<count($pages);$i++) {

            $req= $this->_fb->post("/{$pages[$i]}/feed", $post_data, $tokens[$i]);
            $db->saveSocialToPost(
                'facebook',
                array(
                    'social_post'=>$req->getDecodedBody()['id'],
                    'wp_post'=> $data['id'],
                    'page_id'=>$pages[$i]
                )
            );
        }
    }
    //TODO remove this function
    public function test(){
        $this->_fb->setDefaultAccessToken($_SESSION['hmd_fb_token']);
        try {
            $response = $this->_fb->get('/me?fields=accounts');
            $userNode = $response->getGraphUser();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $page=$userNode->asArray();
        $page=$page['accounts'][0]['id'];
        $pageaccess=$userNode->asArray();
        $pageaccess=$pageaccess['accounts'][0]['access_token'];
        //print_r($userNode->asArray()['accounts']);
        // echo 'Logged in as ' . $userNode->getName();
        $request= $this->_fb->post("/{$page}/feed", array('message' => 'this is for testing'), $pageaccess );

        print_r($request->getDecodedBody());
    }



}