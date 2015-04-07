<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Json_model extends CI_Model {
    function authenticate() {
        $is_logged_in = $this->session->userdata('logged_in');
        //        print_r($is_logged_in);
        if ($is_logged_in != 'true' || !isset($is_logged_in)) {
            return false;
        } //$is_logged_in !== 'true' || !isset( $is_logged_in )
        else {
            $userid = $this->session->userdata('id');
            return $this->session->all_userdata();
        }
    }


    function getuserdetails() {
        $userid=$this->session->userdata("id");
        $user=$this->db->query("SELECT * FROM `user` WHERE `id`='$userid'")->row();
        $user->prediction=$this->db->query("SELECT SUM(*) as `prediction` FROM `predicto_userprediction` WHERE `user`='$userid'")->row();
        $user->prediction=$user->prediction->prediction;
        return $user;
    }



}
