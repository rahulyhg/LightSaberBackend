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
    function getuserdetails($userid) {
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
    function getpredictions($userid) {
        $prediction = $this->db->query("SELECT `predicto_prediction`.`id`,`predicto_prediction`.`name`,`predicto_prediction`.`status`,
`predicto_prediction`.`predictionteam` as `winner`,FLOOR(UNIX_TIMESTAMP(`predicto_prediction`.`starttime`)*1000) as `starttime`,FLOOR(UNIX_TIMESTAMP(`predicto_prediction`.`endtime`)*1000) as `endtime`,
`predicto_prediction`.`venue`,`team11`.`id` as `team1id`,`team22`.`id` as `team2id`,`team11`.`name` as `team1name`,`team22`.`name` as `team2name`
 FROM `predicto_prediction`

INNER  JOIN `predicto_predictionteam` as `team1` ON `predicto_prediction`.`id`=`team1`.`prediction`  AND `team1`.`order`=1
INNER  JOIN `predicto_predictionteam` as `team2` ON `predicto_prediction`.`id`=`team2`.`prediction` AND `team2`.`order`=2
INNER  JOIN `predicto_teamgroup` as `team11` ON `team1`.`teamgroup`=`team11`.`id`
INNER  JOIN `predicto_teamgroup` as `team22` ON `team2`.`teamgroup`=`team22`.`id`

")->result();
        foreach ($prediction as $predict) {

            $query = $this->db->query("SELECT * FROM `predicto_userprediction` WHERE `user`='$userid' AND `prediction`='$predict->id'");
            $querynum = $query->num_rows();
            if ($querynum != 0) {
                $query = $query->row();
                $predict->predicted = $query->teamgroup;
            }

            $predictioncount = $this->db->query("SELECT COUNT(`id`) as `count`,`teamgroup` FROM `predicto_userprediction` WHERE `teamgroup` <> 0 AND  `prediction`='$predict->id' GROUP BY `teamgroup`")->result();
            if (sizeof($predictioncount) == 1) {
                if ($predictioncount[0]->teamgroup == $predict->team1id) {
                    $predict->team1percent = 100;
                } else {
                    $predict->team1percent = 0;
                }
            } else if (sizeof($predictioncount) > 1) {
                $firstone=0;
                $secondtwo=0;
                foreach($predictioncount as $key => $predict2)
                {
                    if($predict2->teamgroup==$predict->team1id)
                    {
                        $firstone=$key;
                    }
                    if($predict2->teamgroup==$predict->team2id)
                    {
                        $secondtwo=$key;
                    }

                }

                $predict->team1percent = $predictioncount[$firstone]->count / ($predictioncount[$firstone]->count + $predictioncount[$secondtwo]->count) * 100;
            } else {
                $predict->team1percent = - 1;
            }
            $predict->team1percent=intval($predict->team1percent);
        }
        return $prediction;
    }
    function userpredicts($userid,$team, $prediction) {
        $query = $this->db->query("SELECT * FROM `predicto_userprediction` WHERE `user`='$userid' AND `prediction`='$prediction'");
		$query1=$this->db->query("SELECT * FROM `predicto_prediction` WHERE `id` = '$prediction'")->row();
		if($query1->status=='0')
		{
			return false;
		}
        $querynum = $query->num_rows();
        if ($querynum == 0) {
            $this->db->query("INSERT INTO `predicto_userprediction` (`id`, `user`, `teamgroup`, `prediction`) VALUES (NULL, '$userid', '$team', '$prediction')");
        } else {
            $this->db->query("UPDATE `predicto_userprediction` SET `teamgroup` = '$team' WHERE `user` = '$userid' AND  `prediction` = '$prediction'");
        }
        return true;
    }
    function getpredictionforuser($userid,$predict) {
        $prediction = $this->db->query("SELECT `predicto_prediction`.`id`,`predicto_prediction`.`name`,`predicto_prediction`.`status`,
`predicto_prediction`.`predictionteam` as `winner`,FLOOR(UNIX_TIMESTAMP(`predicto_prediction`.`starttime`)*1000) as `starttime`,FLOOR(UNIX_TIMESTAMP(`predicto_prediction`.`endtime`)*1000) as `endtime`,
`predicto_prediction`.`venue`,`team11`.`id` as `team1id`,`team22`.`id` as `team2id`,`team11`.`name` as `team1name`,`team22`.`name` as `team2name`
FROM `predicto_prediction`
INNER  JOIN `predicto_predictionteam` as `team1` ON `predicto_prediction`.`id`=`team1`.`prediction`  AND `team1`.`order`=1 AND `predicto_prediction`.`id`='$predict'
INNER  JOIN `predicto_predictionteam` as `team2` ON `predicto_prediction`.`id`=`team2`.`prediction` AND `team2`.`order`=2
INNER  JOIN `predicto_teamgroup` as `team11` ON `team1`.`teamgroup`=`team11`.`id`
INNER  JOIN `predicto_teamgroup` as `team22` ON `team2`.`teamgroup`=`team22`.`id` ")->row();
        $predictioncount = $this->db->query("SELECT COUNT(`id`) as `count`,`teamgroup`  FROM `predicto_userprediction` WHERE `teamgroup` <> 0 AND `prediction`='$prediction->id' GROUP BY `teamgroup`")->result();
$prediction->count=$predictioncount;
        if (sizeof($predictioncount) == 1) {
            if ($predictioncount[0]->teamgroup == $prediction->team1id) {
                $prediction->team1percent = 100;
            } else {
                $prediction->team1percent = 0;
            }
        } else if (sizeof($predictioncount) > 1) {

            $firstone=0;
                $secondtwo=0;
                foreach($predictioncount as $key => $predict2)
                {
                    if($predict2->teamgroup==$prediction->team1id)
                    {
                        $firstone=$key;
                    }
                    if($predict2->teamgroup==$prediction->team2id)
                    {
                        $secondtwo=$key;
                    }

                }

                $prediction->team1percent = $predictioncount[$firstone]->count / ($predictioncount[$firstone]->count + $predictioncount[$secondtwo]->count) * 100;

        } else {
            $prediction->team1percent = - 1;
        }
        $prediction->team1percent=intval($prediction->team1percent);

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
            $hashstring = "";
            foreach ($hash as $hashone) {
                $hashstring.= "$hashone->hashtag OR ";
            }
            $hashstring = substr($hashstring, 0, -4);
            $this->load->library('twitteroauth');
            $this->config->load('twitter');
            $this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->config->item('twitter_access_token'), $this->config->item('twitter_access_secret'));
            $hashstring = urlencode($hashstring);
            $data = $this->twitteroauth->get('search/tweets.json?q=' . $hashstring . "&count=20");
            $prediction->tweets = $data;
        }
        return $prediction;
    }
    function getleaderboard() {
      $query=$this->db->query("SELECT `user`.*, count(`predicto_userprediction`.`user`) as `predictions` FROM `user` LEFT OUTER JOIN `predicto_userprediction` ON `user`.`id`=`predicto_userprediction`.`user` AND `predicto_userprediction`.`teamgroup`>0 GROUP BY `user`.`id` ORDER BY `points` DESC,`predictions` DESC LIMIT 0,50")->result();


      return $query;
    }
    
    function getfriendsleaderboard($facebookfriends) {
        $facebookfriendid=$facebookfriends["data"];
        $str="";
        foreach($facebookfriendid as $friend)
        {
            $str.=$friend['id'].",";
        }
        $str=substr($str,0,-1);
        $query=$this->db->query("SELECT `user`.*, count(`predicto_userprediction`.`user`) as `predictions` FROM `user` LEFT OUTER JOIN `predicto_userprediction` ON `user`.`id`=`predicto_userprediction`.`user` AND `predicto_userprediction`.`teamgroup`>0 WHERE `user`.`socialid` IN ($str) GROUP BY `user`.`id`  ORDER BY `points` DESC,`predictions` DESC LIMIT 0,50")->result();


      return $query;
    }
	
	function getpredictionteamwise() {
		$query=$this->db->query("SELECT `all`.`id`,`all`.`name`,`all`.`total`,`winning`.`totalwins`,`loss`.`totalloss`
FROM
(SELECT  `predicto_teamgroup`.`id` ,  `predicto_teamgroup`.`name` , COUNT(  `predicto_teamgroup`.`id` ) AS  `total` 
FROM  `predicto_userprediction` 
INNER JOIN `predicto_prediction` ON `predicto_userprediction`.`prediction`=`predicto_prediction`.`id`
INNER JOIN  `predicto_teamgroup` ON  `predicto_userprediction`.`teamgroup` =  `predicto_teamgroup`.`id` 
GROUP BY  `predicto_teamgroup`.`id`) AS `all`
LEFT OUTER JOIN 
(SELECT  `predicto_teamgroup`.`id` ,  `predicto_teamgroup`.`name` , COUNT(  `predicto_teamgroup`.`id` ) AS  `totalwins` 
FROM  `predicto_userprediction` 
INNER JOIN `predicto_prediction` ON `predicto_userprediction`.`prediction`=`predicto_prediction`.`id` AND `predicto_userprediction`.`teamgroup`=`predicto_prediction`.`predictionteam`
INNER JOIN  `predicto_teamgroup` ON  `predicto_userprediction`.`teamgroup` =  `predicto_teamgroup`.`id` 
GROUP BY  `predicto_teamgroup`.`id`) AS `winning` ON `all`.`id`=`winning`.`id`
LEFT OUTER JOIN 
(SELECT  `predicto_teamgroup`.`id` ,  `predicto_teamgroup`.`name` , COUNT(  `predicto_teamgroup`.`id` ) AS  `totalloss` 
FROM  `predicto_userprediction` 
INNER JOIN `predicto_prediction` ON `predicto_userprediction`.`prediction`=`predicto_prediction`.`id` AND `predicto_userprediction`.`teamgroup`<>`predicto_prediction`.`predictionteam` AND `predicto_prediction`.`predictionteam`<>'0' AND `predicto_prediction`.`predictionteam`<10
INNER JOIN  `predicto_teamgroup` ON  `predicto_userprediction`.`teamgroup` =  `predicto_teamgroup`.`id` 
GROUP BY  `predicto_teamgroup`.`id`) AS `loss` ON `all`.`id`=`loss`.`id`

ORDER BY `total` DESC")->result();
return $query;
	}
}
