<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class usershare_model extends CI_Model
{
    public function create($user,$sharecontent,$total,$prediction,$predictionhash)
    {
        $data=array("user" => $user,"sharecontent" => $sharecontent,"total" => $total,"prediction" => $prediction);
        $query=$this->db->insert( "predicto_usershare", $data );
        $id=$this->db->insert_id();
        foreach($predictionhash AS $key=>$value)
        {
            $this->usershare_model->createpredictionhashbyusershare($value,$id);
        }
    
        if(!$query)
        return  0;
        else
        return  $id;
    }
    public function createpredictionhashbyusershare($value,$id)
	{
		$data  = array(
			'predictionhash' => $value,
			'usershare' => $id
		);
		$query=$this->db->insert( 'predicto_usersharehash', $data );
		return  1;
	}
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_usershare")->row();
        return $query;
    }
    function getsingleusershare($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_usershare")->row();
        return $query;
    }
    public function edit($id,$user,$sharecontent,$total,$prediction,$predictionhash)
    {
        $data=array("user" => $user,"sharecontent" => $sharecontent,"total" => $total,"prediction" => $prediction);
        $this->db->where( "id", $id );
        $query=$this->db->update( "predicto_usershare", $data );
        $querydelete=$this->db->query("DELETE FROM `predicto_usersharehash` WHERE `usershare`='$id'");
        foreach($predictionhash AS $key=>$value)
        {
            $this->usershare_model->createpredictionhashbyusershare($value,$id);
        }
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `predicto_usershare` WHERE `id`='$id'");
        return $query;
    }
    
    public function getusersharedropdown()
	{
		$query=$this->db->query("SELECT `predicto_usershare`.`id`, `predicto_usershare`.`user`, `predicto_usershare`.`sharecontent`, `predicto_usershare`.`total`, `predicto_usershare`.`prediction` ,`predicto_prediction`.`name` AS `predictionname`,`user`.`name` AS `username`
FROM `predicto_usershare`
LEFT OUTER JOIN  `user`ON `predicto_usershare`.`user`=`user`.`id`
LEFT OUTER JOIN  `predicto_prediction`ON `predicto_usershare`.`prediction`=`predicto_prediction`.`id`  ORDER BY `predicto_usershare`.`id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->username." ".$row->predictionname;
		}
		
		return $return;
	}
    
        
     public function getusersharehashbyusershare($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`usershare`,`predictionhash` FROM `predicto_usersharehash`  WHERE `usershare`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->predictionhash;
            }
        }
         return $return;
         
		
	}
}
?>
