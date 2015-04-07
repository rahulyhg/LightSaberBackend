<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class sociallogin_model extends CI_Model
{
    public function create($name)
    {
        $data=array("name" => $name);
        $query=$this->db->insert( "predicto_sociallogin", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_sociallogin")->row();
        return $query;
    }
    function getsinglesociallogin($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_sociallogin")->row();
        return $query;
    }
    public function edit($id,$name)
    {
        $data=array("name" => $name);
        $this->db->where( "id", $id );
        $query=$this->db->update( "predicto_sociallogin", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `predicto_sociallogin` WHERE `id`='$id'");
        return $query;
    }
    
    public function getsociallogindropdown()
	{
		$query=$this->db->query("SELECT * FROM `predicto_sociallogin`  ORDER BY `id` ASC")->result();
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
