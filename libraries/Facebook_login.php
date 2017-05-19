<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "libraries/Social_login.php";

class Facebook_login extends Social_login {

    /**
     * oAuth 코드를 받아올때 필요한 패러미터를 가져온다.
     */
    protected function _get_authorize_param()
    {
        $param = parent::_get_authorize_param();
        $param['scope'] = "public_profile,email";
        return $param;
    }

    /**
     * 사용자 프로필 받아오기
     */
    protected function _get_info( $access_token, $add_param=""  )
    {
        $fields = 'id,name,picture.width(1000).height(1000),link,email,verified,about,website,birthday,gender';
        $add_param = sprintf('?access_token=%s&fields=%s',$access_token, $fields);

        $result = json_decode(parent::_get_info($access_token, $add_param), TRUE);


        if( $result['id'] ) {
            return $result;
        }
        else {
            return NULL;
        }
    }
}
