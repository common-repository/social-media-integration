<?php

/**
 * Created by PhpStorm.
 * User=> DeveloperH
 * Date: 2/1/16
 * Time: 1:46 PM
 */
use Abraham\TwitterOAuth\TwitterOAuth;
class HMDTwitter {
    public $_twitter;
    private $_token;
    private $_token_secret;
    private $_key_secret;
    private $_key;
    public  $isLogged=false;

    /**
     *
     */
    function setTwitter()
    {


        if(isset($_SESSION['hmd_oauth_token']) && isset($_SESSION['hmd_oauth_verifier'])) {
            $this->isLogged = true;
            $this->_twitter = new TwitterOAuth(
                $this->_key,
                $this->_key_secret,
                $_SESSION['hmd_oauth_token2'],
                $_SESSION['hmd_oauth_token_secret']

            );
            if ( ! isset( $_SESSION['hmd_access_token'] ) ) {
                $access_token = $this->_twitter->oauth( "oauth/access_token", [ "oauth_verifier" => $_SESSION['hmd_oauth_verifier'] ] );

            $_SESSION['hmd_access_token'] = $access_token;
            }
            $this->_twitter = new TwitterOAuth(
                $this->_key,
                $this->_key_secret,
                $_SESSION['hmd_access_token']['oauth_token'],
                $_SESSION['hmd_access_token']['oauth_token_secret']
            );

        }else{
            $this->isLogged = false;
            $this->_twitter = new TwitterOAuth($this->_key,  $this->_key_secret);
        }


    }

    /**
     * @param $token
     */
    function setToken($token)
    {
        $this->_token=$token;
    }

    /**
     * @param $secret
     */
    function setSecretToken($secret)
    {
        $this->_token_secret =$secret;
    }
    /**
     * @param $key
     */
    function setKey($key)
    {
        $this->_key =$key;
    }/**
     * @param $secret
     */
    function setSecret($secret)
    {
        $this->_key_secret =$secret;
    }

    /**
    * Get twitter login link
    * @return string
    */
    public function getLoginLink()
    {
        try {
            $request_token =  $this->_twitter->oauth(
                'oauth/request_token',
                array('oauth_callback' => 'http://'.$_SERVER['SERVER_NAME'].'/wp-admin/admin.php?page=social-integration-twitter')
            );
            switch ( $this->_twitter->getLastHttpCode()) {
                case 200:
                    /* Save temporary credentials to session. */
                    $_SESSION['hmd_oauth_token'] = $request_token['oauth_token'];
                    $_SESSION['hmd_oauth_token_secret'] = $request_token['oauth_token_secret'];
                    /* Build authorize URL and redirect user to Twitter. */
                    $url =  $this->_twitter->url('oauth/authorize', ['oauth_token' => $request_token['oauth_token']]);
                    return $url;
                    break;
                default:
                    /* Show notification if something went wrong. */
                    echo 'Could not connect to Twitter. Refresh the page or try again later.';
            }
        } catch (OAuthException $e) {
            echo $e->getMessage();
        }
        return null;
    }

    public function getUserInfo() {
        $user_info = $this->_twitter->get('account/verify_credentials');

        $user_details=array();
        $user_details['name']=$user_info->name;
        $user_details['first_name']=$user_info->name;
        $user_details['picture']['url']=$user_info->profile_image_url_https;
        $user_details['hometown']['name']=$user_info->location;
        $user_details['screen_name']='@'.$user_info->screen_name;
        $user_details['description']=$user_info->description;
        $user_details['followers']=$user_info->followers_count;
        $user_details['friends']=$user_info->friends_count;
        $user_details['statuses_count']=$user_info->statuses_count;
        $user_details['education']=array();
        return $user_details;
    }

    public function send_to_account( $data, $db ) {
            $ext=explode('.',$data['img']);
            $ext=$ext[count($ext)-1];
            $image=file_get_contents($data['img']);
        $img_name=date('YmdHis').'.'.$ext;

        $myfile = fopen($img_name, "w");
        fwrite($myfile, $image);
        fclose($myfile);

        $media = $this->_twitter->upload('media/upload', array('media' => $img_name));

        $res=$this->_twitter->post("statuses/update", ["status" => $data['message'].' '.$data['url'],'media_ids'=>$media->media_id_string]);
        $user_info=$this->getUserInfo();
        $db->saveSocialToPost(
            'twitter',
            array(
                'social_post'=>$res->id,
                'wp_post'=> $data['id'],
                'page_id'=>$user_info['screen_name']
            )
        );
        unlink($img_name);
    }
    public function __toObject(Array $arr) {
        $obj = new stdClass();
        foreach($arr as $key=>$val) {
            if (is_array($val)) {
                $val = __toObject($val);
            }
            $obj->$key = $val;
        }

        return $obj;
    }
}
