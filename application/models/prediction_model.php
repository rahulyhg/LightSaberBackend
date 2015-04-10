<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class prediction_model extends CI_Model
{
    public function create($predictiongroup,$name,$status,$predictionteam,$starttime,$endtime,$venue,$order)
    {
        $data=array("predictiongroup" => $predictiongroup,"name" => $name,"status" => $status,"predictionteam" => $predictionteam,"starttime" => $starttime,"endtime" => $endtime,"venue" => $venue,"order" => $order);
        $query=$this->db->insert( "predicto_prediction", $data );
        $id=$this->db->insert_id();
        if(!$query)
        return  0;
        else
        return $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_prediction")->row();
        return $query;
		
    }
    function getsingleprediction($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_prediction")->row();
        return $query;
    }
    public function edit($id,$predictiongroup,$name,$status,$predictionteam,$starttime,$endtime,$venue,$order)
    {
        $data=array("predictiongroup" => $predictiongroup,
					"name" => $name,"status" => $status,
					"predictionteam" => $predictionteam,
					"starttime" => $starttime,
					"endtime" => $endtime,
					"venue" => $venue,
					"order" => $order);
        $this->db->where( "id", $id );
        $query=$this->db->update( "predicto_prediction", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `predicto_prediction` WHERE `id`='$id'");
        return $query;
    }
    
    public function getpredictiondropdown()
	{
		$query=$this->db->query("SELECT * FROM `predicto_prediction`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	public function getpredictionstatusdropdown()
	{
		$status= array(
			 "0" => "Disable",
			 "1" => "Enable",
			);
		return $status;
	}
	 public function winnerchanged($prediction, $team) {
        if ($team != "") {
            $this->db->query("DELETE FROM `predicto_userpointlog` WHERE `prediction` = '$prediction'");
            $this->db->query("INSERT INTO `predicto_userpointlog` (`id`, `point`, `for`, `prediction`, `shareid`, `user`) SELECT NULL,200,1,$prediction,0,`user` FROM `predicto_userprediction` WHERE `prediction`='$prediction' AND `teamgroup`='$team'");
            $this->db->query("INSERT INTO `predicto_userpointlog` (`id`, `point`, `for`, `prediction`, `shareid`, `user`) SELECT NULL,50,1,$prediction,0,`user` FROM `predicto_userprediction` WHERE `prediction`='$prediction' AND `teamgroup`<>'$team'");
            $this->db->query("UPDATE `user` ,(SELECT SUM(`point`) as `points`,`user` as `user` FROM `predicto_userpointlog` GROUP BY `user`) as `userpoints`  SET `user`.`points`=`userpoints`.`points` WHERE `user`.`id`=`userpoints`.`user`");
            return true;
        } else {
            return false;
        }
    }
	
}
?>
