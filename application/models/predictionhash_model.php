<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class predictionhash_model extends CI_Model
{
    public function create($prediction,$hashtag)
    {
        $data=array("prediction" => $prediction,"hashtag" => $hashtag);
        $query=$this->db->insert( "predicto_predictionhash", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_predictionhash")->row();
        return $query;
    }
    function getsinglepredictionhash($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("predicto_predictionhash")->row();
        return $query;
    }
    public function edit($id,$prediction,$hashtag)
    {
        $data=array("prediction" => $prediction,"hashtag" => $hashtag);
        $this->db->where( "id", $id );
        $query=$this->db->update( "predicto_predictionhash", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `predicto_predictionhash` WHERE `id`='$id'");
        return $query;
    }
    
    public function getpredictionhashdropdown()
	{
		$query=$this->db->query("SELECT `predicto_predictionhash`.`id`, `predicto_predictionhash`.`prediction`, `predicto_predictionhash`.`hashtag`,`predicto_prediction`.`name`  AS `predictionname`
FROM `predicto_predictionhash` 
LEFT OUTER JOIN `predicto_prediction` ON `predicto_predictionhash`.`prediction`=`predicto_prediction`.`id`  ORDER BY `predicto_predictionhash`.`id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->predictionname." ".$row->hashtag;
		}
		
		return $return;
	}
}
?>
