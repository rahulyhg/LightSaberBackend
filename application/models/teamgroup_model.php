<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class teamgroup_model extends CI_Model
{
    public function create($name,$predictiongroup,$order)
    {
        $data=array("name" => $name,"predictiongroup" => $predictiongroup,"order" => $order);
        $query=$this->db->insert( "predicto_teamgroup", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_teamgroup")->row();
        return $query;
    }
    function getsingleteamgroup($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_teamgroup")->row();
        return $query;
    }
    public function edit($id,$name,$predictiongroup,$order)
    {
        $data=array("name" => $name,"predictiongroup" => $predictiongroup,"order" => $order);
        $this->db->where( "id", $id );
        $query=$this->db->update( "predicto_teamgroup", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `predicto_teamgroup` WHERE `id`='$id'");
        return $query;
    }
    
    public function getteamgroupdropdown()
	{
		$query=$this->db->query("SELECT * FROM `predicto_teamgroup`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
}
?>
