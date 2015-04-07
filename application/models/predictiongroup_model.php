<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class predictiongroup_model extends CI_Model
{
    public function create($name,$order,$status,$endtime)
    {
        $data=array("name" => $name,"order" => $order,"status" => $status,"endtime" => $endtime);
        $query=$this->db->insert( "predicto_predictiongroup", $data );
        $id=$this->db->insert_id();
        if(!$query)
        return  0;
        else
        return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_predictiongroup")->row();
        return $query;
    }
    function getsinglepredictiongroup($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_predictiongroup")->row();
        return $query;
    }
    public function edit($id,$name,$order,$status,$endtime)
    {
        $data=array("name" => $name,"order" => $order,"status" => $status,"endtime" => $endtime);
        $this->db->where( "id", $id );
        $query=$this->db->update( "predicto_predictiongroup", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `predicto_predictiongroup` WHERE `id`='$id'");
        return $query;
    }
    
    public function getpredictiongroupdropdown()
	{
		$query=$this->db->query("SELECT * FROM `predicto_predictiongroup`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	public function getpredictiongroupstatusdropdown()
	{
		$status= array(
			 "0" => "Disable",
			 "1" => "Enable",
			);
		return $status;
	}
}
?>
