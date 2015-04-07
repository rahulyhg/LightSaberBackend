<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class userprediction_model extends CI_Model
{
    public function create($user,$teamgroup,$prediction)
    {
        $data=array("user" => $user,"teamgroup" => $teamgroup,"prediction" => $prediction);
        $query=$this->db->insert( "predicto_userprediction", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_userprediction")->row();
        return $query;
    }
    function getsingleuserprediction($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_userprediction")->row();
        return $query;
    }
    public function edit($id,$user,$teamgroup,$prediction)
    {
        $data=array("user" => $user,"teamgroup" => $teamgroup,"prediction" => $prediction);
        $this->db->where( "id", $id );
        $query=$this->db->update( "predicto_userprediction", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `predicto_userprediction` WHERE `id`='$id'");
        return $query;
    }
    
    public function getuserpredictiondropdown()
	{
		$query=$this->db->query("SELECT * FROM `predicto_userprediction`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->timestamp;
		}
		
		return $return;
	}
}
?>
