<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "libraries/Social_login.php";

class Kakao_login extends Social_login {

    /**
     * 사용자 프로필 받아오기
     */
    protected function _get_info( $access_token, $add_param=""  )
    {
        $result = json_decode(parent::_get_info($access_token), TRUE);

        if( empty($result['id'] )) {
            return NULL;
        }
        else {
            return $result;
        }
    }

}