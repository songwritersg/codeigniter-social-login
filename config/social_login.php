<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * SOCIAL Setting
 **/
$config['naver_login']['client_id']         = "네아로 클라이언트 ID";
$config['naver_login']['client_secret']     = "네아로 클라이언트 secret";
$config['naver_login']['redirect_uri']  = "네아로 Redirect URI";
$config['naver_login']['authorize_url'] = "https://nid.naver.com/oauth2.0/authorize";
$config['naver_login']['token_url']     = "https://nid.naver.com/oauth2.0/token";
$config['naver_login']['info_url']      = "https://openapi.naver.com/v1/nid/me";
$config['naver_login']['token_request_post'] = FALSE;


$config['facebook_login']['client_id']  = "페이스북 앱 ID";      // 페이스북 앱 ID 입력
$config['facebook_login']['client_secret']= "페이스북 앱 시크릿";   // 페이스북 앱 시크릿 코드
$config['facebook_login']['redirect_uri']   = "페이스북 Redirect URI";
$config['facebook_login']['authorize_url']= "https://www.facebook.com/dialog/oauth";
$config['facebook_login']['token_url']  = "https://graph.facebook.com/v2.4/oauth/access_token";
$config['facebook_login']['info_url']       = "https://graph.facebook.com/v2.4/me";
$config['facebook_login']['token_request_post'] = FALSE;

$config['kakao_login']['client_id']     = "카카오 로그인 REST API KEY";   // REST API 키를 입력
$config['kakao_login']['client_secret'] = "";   // 카카오는 Client Secret을 사용하지 않습니다. 공백으로 지정
$config['kakao_login']['redirect_uri']  = "";
$config['kakao_login']['authorize_url'] = "https://kauth.kakao.com/oauth/authorize";
$config['kakao_login']['token_url']     = "https://kauth.kakao.com/oauth/token";
$config['kakao_login']['info_url']      = "https://kapi.kakao.com/v1/user/me";
$config['kakao_login']['token_request_post'] = FALSE;

$config['google_login']['client_id']        = "구글 클라이언트 ID";
$config['google_login']['client_secret']    = "구글 클라이언트 시크릿";
$config['google_login']['redirect_uri']     = "";
$config['google_login']['authorize_url']    = "https://accounts.google.com/o/oauth2/auth";
$config['google_login']['token_url']        = "https://www.googleapis.com/oauth2/v4/token";
$config['google_login']['info_url']         = "https://www.googleapis.com/plus/v1/people/me";
$config['google_login']['token_request_post'] = TRUE;