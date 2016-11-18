<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller
{
    public function naver()
    {
        $this->load->library("naver_login");
        $result = $this->naver_login->get_profile();

        print_r($result);
    }

    public function facebook()
    {
        $this->load->library("facebook_login");
        $result = $this->facebook_login->get_profile();

        print_r($result);
    }

    public function kakao()
    {
        $this->load->library("kakao_login");
        $result = $this->kakao_login->get_profile();

        print_r($result);
    }

    public function google()
    {
        $this->load->library("google_login");
        $result = $this->google_login->get_profile();

        print_r($result);
    }
}