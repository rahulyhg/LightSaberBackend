<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class usersharehash_model extends CI_Model
{
    public function create($usershare,$predictionhash)
    {
        $data=array("usershare" => $usershare,"predictionhash" => $predictionhash);
        $query=$this->db->insert( "predicto_usersharehash", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_usersharehash")->row();
        return $query;
    }
    function getsingleusersharehash($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_usersharehash")->row();
        return $query;
    }
    public function edit($id,$usershare,$predictionhash)
    {
        $data=array("usershare" => $usershare,"predictionhash" => $predictionhash);
        $this->db->where( "id", $id );
        $query=$this->db->update( "predicto_usersharehash", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `predicto_usersharehash` WHERE `id`='$id'");
        return $query;
    }
    
    public function getusersharehashdropdown()
	{
		$query=$this->db->query("SELECT * FROM `predicto_usersharehash`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->hashtag;
		}
		
		return $return;
	}
}
?>
