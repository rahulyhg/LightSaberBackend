<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Json extends CI_Controller 
{function getallsociallogin()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`predicto_sociallogin`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`predicto_sociallogin`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_sociallogin`");
$this->load->view("json",$data);
}
public function getsinglesociallogin()
{
$id=$this->input->get_post("id");
$data["message"]=$this->sociallogin_model->getsinglesociallogin($id);
$this->load->view("json",$data);
}
function getallpredictiongroup()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`predicto_predictiongroup`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`predicto_predictiongroup`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`predicto_predictiongroup`.`order`";
$elements[2]->sort="1";
$elements[2]->header="Order";
$elements[2]->alias="order";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`predicto_predictiongroup`.`status`";
$elements[3]->sort="1";
$elements[3]->header="Status";
$elements[3]->alias="status";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`predicto_predictiongroup`.`endtime`";
$elements[4]->sort="1";
$elements[4]->header="End Time";
$elements[4]->alias="endtime";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_predictiongroup`");
$this->load->view("json",$data);
}
public function getsinglepredictiongroup()
{
$id=$this->input->get_post("id");
$data["message"]=$this->predictiongroup_model->getsinglepredictiongroup($id);
$this->load->view("json",$data);
}
function getallteamgroup()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`predicto_teamgroup`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`predicto_teamgroup`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`predicto_teamgroup`.`predictiongroup`";
$elements[2]->sort="1";
$elements[2]->header="Prediction Group";
$elements[2]->alias="predictiongroup";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`predicto_teamgroup`.`order`";
$elements[3]->sort="1";
$elements[3]->header="Order";
$elements[3]->alias="order";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_teamgroup`");
$this->load->view("json",$data);
}
public function getsingleteamgroup()
{
$id=$this->input->get_post("id");
$data["message"]=$this->teamgroup_model->getsingleteamgroup($id);
$this->load->view("json",$data);
}
function getallprediction()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`predicto_prediction`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`predicto_prediction`.`predictiongroup`";
$elements[1]->sort="1";
$elements[1]->header="Prediction Group";
$elements[1]->alias="predictiongroup";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`predicto_prediction`.`name`";
$elements[2]->sort="1";
$elements[2]->header="Name";
$elements[2]->alias="name";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`predicto_prediction`.`status`";
$elements[3]->sort="1";
$elements[3]->header="Status";
$elements[3]->alias="status";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`predicto_prediction`.`predictionteam`";
$elements[4]->sort="1";
$elements[4]->header="Winner";
$elements[4]->alias="predictionteam";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`predicto_prediction`.`endtime`";
$elements[5]->sort="1";
$elements[5]->header="End Time";
$elements[5]->alias="endtime";

$elements=array();
$elements[6]=new stdClass();
$elements[6]->field="`predicto_prediction`.`order`";
$elements[6]->sort="1";
$elements[6]->header="Order";
$elements[6]->alias="order";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_prediction`");
$this->load->view("json",$data);
}
public function getsingleprediction()
{
$id=$this->input->get_post("id");
$data["message"]=$this->prediction_model->getsingleprediction($id);
$this->load->view("json",$data);
}
function getallpredictionteam()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`predicto_predictionteam`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`predicto_predictionteam`.`prediction`";
$elements[1]->sort="1";
$elements[1]->header="Prediction";
$elements[1]->alias="prediction";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`predicto_predictionteam`.`teamgroup`";
$elements[2]->sort="1";
$elements[2]->header="Team Group";
$elements[2]->alias="teamgroup";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`predicto_predictionteam`.`order`";
$elements[3]->sort="1";
$elements[3]->header="Order";
$elements[3]->alias="order";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_predictionteam`");
$this->load->view("json",$data);
}
public function getsinglepredictionteam()
{
$id=$this->input->get_post("id");
$data["message"]=$this->predictionteam_model->getsinglepredictionteam($id);
$this->load->view("json",$data);
}
function getalluserprediction()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`predicto_userprediction`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`predicto_userprediction`.`user`";
$elements[1]->sort="1";
$elements[1]->header="User";
$elements[1]->alias="user";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`predicto_userprediction`.`teamgroup`";
$elements[2]->sort="1";
$elements[2]->header="Team Group";
$elements[2]->alias="teamgroup";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`predicto_userprediction`.`prediction`";
$elements[3]->sort="1";
$elements[3]->header="Prediction";
$elements[3]->alias="prediction";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_userprediction`");
$this->load->view("json",$data);
}
public function getsingleuserprediction()
{
$id=$this->input->get_post("id");
$data["message"]=$this->userprediction_model->getsingleuserprediction($id);
$this->load->view("json",$data);
}
function getallpredictionhash()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`predicto_predictionhash`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`predicto_predictionhash`.`prediction`";
$elements[1]->sort="1";
$elements[1]->header="Prediction";
$elements[1]->alias="prediction";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`predicto_predictionhash`.`hashtag`";
$elements[2]->sort="1";
$elements[2]->header="Hash Tag";
$elements[2]->alias="hashtag";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_predictionhash`");
$this->load->view("json",$data);
}
public function getsinglepredictionhash()
{
$id=$this->input->get_post("id");
$data["message"]=$this->predictionhash_model->getsinglepredictionhash($id);
$this->load->view("json",$data);
}
function getallusershare()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`predicto_usershare`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`predicto_usershare`.`user`";
$elements[1]->sort="1";
$elements[1]->header="User";
$elements[1]->alias="user";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`predicto_usershare`.`sharecontent`";
$elements[2]->sort="1";
$elements[2]->header="Share Content";
$elements[2]->alias="sharecontent";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`predicto_usershare`.`total`";
$elements[3]->sort="1";
$elements[3]->header="Total";
$elements[3]->alias="total";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`predicto_usershare`.`prediction`";
$elements[4]->sort="1";
$elements[4]->header="Prediction";
$elements[4]->alias="prediction";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_usershare`");
$this->load->view("json",$data);
}
public function getsingleusershare()
{
$id=$this->input->get_post("id");
$data["message"]=$this->usershare_model->getsingleusershare($id);
$this->load->view("json",$data);
}
function getallusersharehash()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`predicto_usersharehash`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`predicto_usersharehash`.`usershare`";
$elements[1]->sort="1";
$elements[1]->header="User Share";
$elements[1]->alias="usershare";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`predicto_usersharehash`.`predictionhash`";
$elements[2]->sort="1";
$elements[2]->header="Prediction Hash";
$elements[2]->alias="predictionhash";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_usersharehash`");
$this->load->view("json",$data);
}
public function getsingleusersharehash()
{
$id=$this->input->get_post("id");
$data["message"]=$this->usersharehash_model->getsingleusersharehash($id);
$this->load->view("json",$data);
}
function getalluserpointlog()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`predicto_userpointlog`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`predicto_userpointlog`.`point`";
$elements[1]->sort="1";
$elements[1]->header="Point";
$elements[1]->alias="point";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`predicto_userpointlog`.`for`";
$elements[2]->sort="1";
$elements[2]->header="For";
$elements[2]->alias="for";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`predicto_userpointlog`.`prediction`";
$elements[3]->sort="1";
$elements[3]->header="Prediction";
$elements[3]->alias="prediction";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`predicto_userpointlog`.`shareid`";
$elements[4]->sort="1";
$elements[4]->header="share ID";
$elements[4]->alias="shareid";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_userpointlog`");
$this->load->view("json",$data);
}
public function getsingleuserpointlog()
{
$id=$this->input->get_post("id");
$data["message"]=$this->userpointlog_model->getsingleuserpointlog($id);
$this->load->view("json",$data);
}
} ?>