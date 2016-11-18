<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Social_login {

    protected $CI;
    protected $social_provider;
    protected $social_setting;

    function __construct()
    {
        $this->CI =& get_instance();

        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->config('social_login');

        $this->social_provider = strtolower(get_called_class());
        $this->social_setting = $this->CI->config->item( $this->social_provider );
    }

    function get_profile()
    {
        if($code = $this->CI->input->get("code", TRUE) )
        {
            // AccessToken을 요청하고 받은값이 없으면 종료
            if(! $access_token_array = $this->_get_access_token($code) ) exit("Failed to get Access Token");
            if( isset($access_token_array['error']) && $access_token_array['error'] ) {
                exit("Failed to get Access Token : ".$access_token_array['error']);
            }
            if(! $profile = $this->_get_info($access_token_array['access_token'])) exit("Failed to get User Info");

            return $profile;
        }
        else
        {
            if( $error = $this->CI->input->get('error', TRUE) )
            {
                // 코드를 받지 못한상태인데 Error GET값이 잇을경우
                echo "error : " . $this->CI->input->get('error', TRUE) . PHP_EOL;
                echo "error_descrption : ". $this->CI->input->get('error_description', TRUE);
                exit();
            }
            // oAuth 인증코드를 받지못한경우
            // 로그인 처리후 이동할 페이지를 세션으로 저장해 둡니다.
            $reurl = $this->CI->input->get('reurl', TRUE) ? $this->CI->input->get('reurl', TRUE) : base_url();
            $this->CI->session->set_userdata('reurl', $reurl);
            // oAuth Code를 받기위해 이동한다.
            $this->_redirect_authorize();
        }
    }

    /**
     * oAuth 코드를 받아올때 필요한 패러미터를 가져온다.
     */
    protected function _get_authorize_param() {

        $param = array();
        $param['response_type'] = "code";
        $param['client_id'] = $this->social_setting['client_id'];
        $param['redirect_uri'] = $this->social_setting['redirect_uri'];

        return $param;
    }

    /**
     * Access Token 을 얻기위해 넘겨야할 패러미터를 가져온다.
     */
    protected function _get_token_param($code) {
        $param = array();

        $param['grant_type'] = "authorization_code";
        $param['code'] = $code;
        $param['state'] = $this->CI->session->userdata($this->social_provider."_state");
        $param['client_id'] = $this->social_setting['client_id'];
        $param['client_secret'] = $this->social_setting['client_secret'];
        $param['redirect_uri'] = $this->social_setting['redirect_uri'];

        return $param;
    }

    /**
     * oAuth 인증절차
     */
    protected function _redirect_authorize()
    {
        // State 값을 만들고, Session에 저장해둡니다.
        $state = md5(microtime().mt_rand());
        $this->CI->session->set_userdata( $this->social_provider."_state", $state);

        // 만든 State 값을 parameter에 추가한다.
        $param = $this->_get_authorize_param();
        $param['state'] = $state;

        // 요청 페이지 고고씽
        redirect($this->social_setting['authorize_url'].'?'.http_build_query($param));
        exit;
    }

    /**
     * Curl을 통해 AccessToken을 얻어옵니다.
     */
    protected function _get_access_token($code)
    {
        $param = $this->_get_token_param($code);
        $this->social_setting['token_url'] .= ( $this->social_setting['token_request_post'] ) ? '':'?'.http_build_query($param);
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $this->social_setting['token_url']);
        curl_setopt ($ch, CURLOPT_POST, $this->social_setting['token_request_post']);
        if( $this->social_setting['token_request_post'] )
        {
            curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($param));
        }
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $result = curl_exec ($ch);
        $result_json = json_decode($result, TRUE);
        return $result_json;
    }

    /**
     * 사용자 프로필 조회요청
     */
    protected function _get_info($access_token, $add_param="")
    {
        if(empty($access_token) OR ! $access_token) return FALSE;

        $url = $this->social_setting['info_url'].$add_param;
        $header = array("Authorization: Bearer {$access_token}");
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);

        return $result;
    }
}