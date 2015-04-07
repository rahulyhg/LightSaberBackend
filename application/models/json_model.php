<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Json_model extends CI_Model {
    function authenticate() {
        $is_logged_in = $this->session->userdata('logged_in');
        if ($is_logged_in != 'true' || !isset($is_logged_in)) {
            return false;
        } //$is_logged_in !== 'true' || !isset( $is_logged_in )
        else {
            return $this->session->all_userdata();
        }
    }
    function getuserdetails() {
        $userid = $this->session->userdata("id");
        $user = $this->db->query("SELECT * FROM `user` WHERE `id`='$userid'")->row();
        $query = $this->db->query("SELECT COUNT(`id`) as `prediction` FROM `predicto_userprediction` WHERE `user`='$userid'");
        $querynum = $query->num_rows();
        if ($querynum == 0) {
            $user->prediction = 0;
        } else {
            $user->prediction = $query->row();
            $user->prediction = $user->prediction->prediction;
        }
        return $user;
    }
    function getpredictions() {
        $userid = $this->session->userdata("id");
        $prediction = $this->db->query("SELECT `predicto_prediction`.`id`,`predicto_prediction`.`name`,`predicto_prediction`.`status`,
`predicto_prediction`.`predictionteam` as `winner`,`predicto_prediction`.`starttime`,`predicto_prediction`.`endtime`,
`predicto_prediction`.`venue`,`team11`.`id` as `team1id`,`team22`.`id` as `team2id`,`team11`.`name` as `team1name`,`team22`.`name` as `team2name`
 FROM `predicto_prediction`

INNER  JOIN `predicto_predictionteam` as `team1` ON `predicto_prediction`.`id`=`team1`.`prediction`  AND `team1`.`order`=1
INNER  JOIN `predicto_predictionteam` as `team2` ON `predicto_prediction`.`id`=`team2`.`prediction` AND `team2`.`order`=2
INNER  JOIN `predicto_teamgroup` as `team11` ON `team1`.`teamgroup`=`team11`.`id`
INNER  JOIN `predicto_teamgroup` as `team22` ON `team2`.`teamgroup`=`team22`.`id`

")->result();
        foreach ($prediction as $predict) {
            $predictioncount = $this->db->query("SELECT COUNT(`id`) as `count` FROM `predicto_userprediction` WHERE `prediction`='$predict->id' GROUP BY `teamgroup`")->result();
            if (($predictioncount[0]->count + $predictioncount[1]->count) > 0) {
                $predict->team1percent = $predictioncount[0]->count / ($predictioncount[0]->count + $predictioncount[1]->count) * 100;
            } else {
                $predict->team1percent = - 1;
            }
        }
        return $prediction;
    }
    function userpredicts($team, $prediction) {
        $userid = $this->session->userdata("id");
        $query = $this->db->query("SELECT * FROM `predicto_userprediction` WHERE `user`='$userid' AND `prediction`='$prediction'");
        $querynum = $query->num_rows();
        if ($querynum == 0) {
            $this->db->query("INSERT INTO `predicto_userprediction` (`id`, `user`, `teamgroup`, `prediction`) VALUES (NULL, '$userid', '$teamgroup', '$prediction')");
        } else {
            $this->db->query("UPDATE predicto_userprediction` SET `teamgroup` = '$team' WHERE `user` = '$userid' AND  `prediction` = '$prediction'");
        }
        return true;
    }
    function getpredictionforuser($predict) {
      $userid = $this->session->userdata("id");
        $prediction = $this->db->query("SELECT `predicto_prediction`.`id`,`predicto_prediction`.`name`,`predicto_prediction`.`status`,
`predicto_prediction`.`predictionteam` as `winner`,`predicto_prediction`.`starttime`,`predicto_prediction`.`endtime`,
`predicto_prediction`.`venue`,`team11`.`id` as `team1id`,`team22`.`id` as `team2id`,`team11`.`name` as `team1name`,`team22`.`name` as `team2name`
FROM `predicto_prediction`
INNER  JOIN `predicto_predictionteam` as `team1` ON `predicto_prediction`.`id`=`team1`.`prediction`  AND `team1`.`order`=1 AND `predicto_prediction`.`id`='$predict'
INNER  JOIN `predicto_predictionteam` as `team2` ON `predicto_prediction`.`id`=`team2`.`prediction` AND `team2`.`order`=2
INNER  JOIN `predicto_teamgroup` as `team11` ON `team1`.`teamgroup`=`team11`.`id`
INNER  JOIN `predicto_teamgroup` as `team22` ON `team2`.`teamgroup`=`team22`.`id` ")->row();
        $predictioncount = $this->db->query("SELECT COUNT(`id`) as `count` FROM `predicto_userprediction` WHERE `prediction`='$prediction->id' GROUP BY `teamgroup`")->result();
        if (($predictioncount[0]->count + $predictioncount[1]->count) > 0) {
            $prediction->team1percent = $predictioncount[0]->count / ($predictioncount[0]->count + $predictioncount[1]->count) * 100;
        } else {
            $prediction->team1percent = - 1;
        }
        $userid = $this->session->userdata("id");
        $query = $this->db->query("SELECT * FROM `predicto_userprediction` WHERE `user`='$userid' AND `prediction`='$predict'");
        $querynum = $query->num_rows();
        if ($querynum != 0) {
            $query = $query->row();
            $prediction->predicted = $query->teamgroup;
        }
        $query2 = $this->db->query("SELECT * FROM `predicto_predictionhash` WHERE `prediction`='$predict'");
        $querynum2 = $query2->num_rows();
        $hash = new stdClass();
        if ($querynum2 != 0) {
            $hash = $query2->result();
            $this->load->library('HybridAuthLib');
            $twitter = $this->hybridauthlib->authenticate("Twitter");
            $hashstring="";
            foreach($hash as $hashone)
            {
              $hashstring.="$hashone->hashtag ";
            }
            $hashstring= substr($hashstring,0,-1);
            $data = $twitter->api()->get("h");
            print_r($data);
        }
        return $prediction;
    }
}
