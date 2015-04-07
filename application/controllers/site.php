<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data['category']=$this->category_model->getcategorydropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
            $status=$this->input->post('status');
            $socialid=$this->input->post('socialid');
            $logintype=$this->input->post('logintype');
            $json=$this->input->post('json');
            $points=$this->input->post('points');
//            $category=$this->input->post('category');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
			if($this->user_model->create($name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json,$points)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");
        
		$data['title']='View Users';
		$this->load->view('template',$data);
	} 
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`user`.`socialid`";
        $elements[3]->sort="1";
        $elements[3]->header="SocialId";
        $elements[3]->alias="socialid";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`logintype`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Logintype";
        $elements[4]->alias="logintype";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`json`";
        $elements[5]->sort="1";
        $elements[5]->header="Json";
        $elements[5]->alias="json";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Accesslevel";
        $elements[6]->alias="accesslevelname";
       
        $elements[7]=new stdClass();
        $elements[7]->field="`statuses`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="Status";
        $elements[7]->alias="status";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `logintype` ON `logintype`.`id`=`user`.`logintype` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` LEFT OUTER JOIN `statuses` ON `statuses`.`id`=`user`.`status`");
        
		$this->load->view("json",$data);
	} 
    
    
	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('template',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
            $status=$this->input->get_post('status');
            $socialid=$this->input->get_post('socialid');
            $logintype=$this->input->get_post('logintype');
            $json=$this->input->get_post('json');
            $points=$this->input->get_post('points');
//            $category=$this->input->get_post('category');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
            
			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json,$points)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    
    
    
    public function viewsociallogin()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewsociallogin";
        $data["base_url"]=site_url("site/viewsocialloginjson");
        $data["title"]="View sociallogin";
        $this->load->view("template",$data);
    }
    function viewsocialloginjson()
    {
        $elements=array();
        
        $elements[0]=new stdClass();
        $elements[0]->field="`predicto_sociallogin`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
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
            $maxrow=20;
        }
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_sociallogin`");
        $this->load->view("json",$data);
    }

    public function createsociallogin()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createsociallogin";
        $data["title"]="Create sociallogin";
        $this->load->view("template",$data);
    }
    public function createsocialloginsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("name","Name","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createsociallogin";
            $data["title"]="Create sociallogin";
            $this->load->view("template",$data);
        }
        else
        {
            $name=$this->input->get_post("name");
            if($this->sociallogin_model->create($name)==0)
                $data["alerterror"]="New sociallogin could not be created.";
            else
                $data["alertsuccess"]="sociallogin created Successfully.";
            $data["redirect"]="site/viewsociallogin";
            $this->load->view("redirect",$data);
        }
    }
    public function editsociallogin()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editsociallogin";
        $data["title"]="Edit sociallogin";
        $data["before"]=$this->sociallogin_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editsocialloginsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("name","Name","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editsociallogin";
            $data["title"]="Edit sociallogin";
            $data["before"]=$this->sociallogin_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $name=$this->input->get_post("name");
            if($this->sociallogin_model->edit($id,$name)==0)
                $data["alerterror"]="New sociallogin could not be Updated.";
            else
                $data["alertsuccess"]="sociallogin Updated Successfully.";
            $data["redirect"]="site/viewsociallogin";
            $this->load->view("redirect",$data);
        }
    }
    public function deletesociallogin()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->sociallogin_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewsociallogin";
        $this->load->view("redirect",$data);
    }
    public function viewpredictiongroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewpredictiongroup";
        $data["base_url"]=site_url("site/viewpredictiongroupjson");
        $data["title"]="View predictiongroup";
        $this->load->view("template",$data);
    }
    function viewpredictiongroupjson()
    {
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`predicto_predictiongroup`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`predicto_predictiongroup`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`predicto_predictiongroup`.`order`";
        $elements[2]->sort="1";
        $elements[2]->header="Order";
        $elements[2]->alias="order";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`predicto_predictiongroup`.`status`";
        $elements[3]->sort="1";
        $elements[3]->header="Status";
        $elements[3]->alias="status";
        
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
            $maxrow=20;
        }
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_predictiongroup`");
        $this->load->view("json",$data);
    }

    public function createpredictiongroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createpredictiongroup";
        $data["title"]="Create predictiongroup";
        $data['status']=$this->predictiongroup_model->getpredictiongroupstatusdropdown();
        $this->load->view("template",$data);
    }
    public function createpredictiongroupsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("order","Order","trim");
        $this->form_validation->set_rules("status","Status","trim");
        $this->form_validation->set_rules("endtime","End Time","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createpredictiongroup";
            $data["title"]="Create predictiongroup";
            $data['status']=$this->predictiongroup_model->getpredictiongroupstatusdropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $name=$this->input->get_post("name");
            $order=$this->input->get_post("order");
            $status=$this->input->get_post("status");
            $endtime=$this->input->get_post("endtime");
            if($this->predictiongroup_model->create($name,$order,$status,$endtime)==0)
                $data["alerterror"]="New predictiongroup could not be created.";
            else
                $data["alertsuccess"]="predictiongroup created Successfully.";
            $data["redirect"]="site/viewpredictiongroup";
            $this->load->view("redirect",$data);
        }
    }
    public function editpredictiongroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editpredictiongroup";
        $data["title"]="Edit predictiongroup";
        $data['status']=$this->predictiongroup_model->getpredictiongroupstatusdropdown();
        $data["before"]=$this->predictiongroup_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editpredictiongroupsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("order","Order","trim");
        $this->form_validation->set_rules("status","Status","trim");
        $this->form_validation->set_rules("endtime","End Time","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editpredictiongroup";
            $data["title"]="Edit predictiongroup";
            $data['status']=$this->predictiongroup_model->getpredictiongroupstatusdropdown();
            $data["before"]=$this->predictiongroup_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $name=$this->input->get_post("name");
            $order=$this->input->get_post("order");
            $status=$this->input->get_post("status");
            $endtime=$this->input->get_post("endtime");
            if($this->predictiongroup_model->edit($id,$name,$order,$status,$endtime)==0)
                $data["alerterror"]="New predictiongroup could not be Updated.";
            else
                $data["alertsuccess"]="predictiongroup Updated Successfully.";
            $data["redirect"]="site/viewpredictiongroup";
            $this->load->view("redirect",$data);
        }
    }
    public function deletepredictiongroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->predictiongroup_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewpredictiongroup";
        $this->load->view("redirect",$data);
    }
    public function viewteamgroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewteamgroup";
        $data["base_url"]=site_url("site/viewteamgroupjson");
        $data["title"]="View teamgroup";
        $this->load->view("template",$data);
    }
    function viewteamgroupjson()
    {
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`predicto_teamgroup`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`predicto_teamgroup`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`predicto_teamgroup`.`predictiongroup`";
        $elements[2]->sort="1";
        $elements[2]->header="Prediction Group";
        $elements[2]->alias="predictiongroupid";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`predicto_teamgroup`.`order`";
        $elements[3]->sort="1";
        $elements[3]->header="Order";
        $elements[3]->alias="order";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`predicto_predictiongroup`.`name`";
        $elements[2]->sort="1";
        $elements[2]->header="Prediction Group";
        $elements[2]->alias="predictiongroup";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_teamgroup` LEFT OUTER JOIN `predicto_predictiongroup` ON `predicto_teamgroup`.`predictiongroup`=`predicto_predictiongroup`.`id`");
        $this->load->view("json",$data);
    }

    public function createteamgroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createteamgroup";
        $data["title"]="Create teamgroup";
        $data['predictiongroup']=$this->predictiongroup_model->getpredictiongroupdropdown();
        $this->load->view("template",$data);
    }
    public function createteamgroupsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("predictiongroup","Prediction Group","trim");
        $this->form_validation->set_rules("order","Order","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createteamgroup";
            $data["title"]="Create teamgroup";
            $data['predictiongroup']=$this->predictiongroup_model->getpredictiongroupdropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $name=$this->input->get_post("name");
            $predictiongroup=$this->input->get_post("predictiongroup");
            $order=$this->input->get_post("order");
            if($this->teamgroup_model->create($name,$predictiongroup,$order)==0)
                $data["alerterror"]="New teamgroup could not be created.";
            else
                $data["alertsuccess"]="teamgroup created Successfully.";
            $data["redirect"]="site/viewteamgroup";
            $this->load->view("redirect",$data);
        }
    }
    public function editteamgroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editteamgroup";
        $data["title"]="Edit teamgroup";
        $data['predictiongroup']=$this->predictiongroup_model->getpredictiongroupdropdown();
        $data["before"]=$this->teamgroup_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editteamgroupsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("predictiongroup","Prediction Group","trim");
        $this->form_validation->set_rules("order","Order","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editteamgroup";
            $data["title"]="Edit teamgroup";
            $data['predictiongroup']=$this->predictiongroup_model->getpredictiongroupdropdown();
            $data["before"]=$this->teamgroup_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $name=$this->input->get_post("name");
            $predictiongroup=$this->input->get_post("predictiongroup");
            $order=$this->input->get_post("order");
            if($this->teamgroup_model->edit($id,$name,$predictiongroup,$order)==0)
                $data["alerterror"]="New teamgroup could not be Updated.";
            else
                $data["alertsuccess"]="teamgroup Updated Successfully.";
            $data["redirect"]="site/viewteamgroup";
            $this->load->view("redirect",$data);
        }
    }
    public function deleteteamgroup()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->teamgroup_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewteamgroup";
        $this->load->view("redirect",$data);
    }
    public function viewprediction()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewprediction";
        $data["base_url"]=site_url("site/viewpredictionjson");
        $data["title"]="View prediction";
        $this->load->view("template",$data);
    }
    function viewpredictionjson()
    {
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`predicto_prediction`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`predicto_prediction`.`predictiongroup`";
        $elements[1]->sort="1";
        $elements[1]->header="Prediction Group";
        $elements[1]->alias="predictiongroupid";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`predicto_prediction`.`name`";
        $elements[2]->sort="1";
        $elements[2]->header="Name";
        $elements[2]->alias="name";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`predicto_prediction`.`status`";
        $elements[3]->sort="1";
        $elements[3]->header="Status";
        $elements[3]->alias="status";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`predicto_prediction`.`predictionteam`";
        $elements[4]->sort="1";
        $elements[4]->header="Winner";
        $elements[4]->alias="predictionteamid";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`predicto_prediction`.`endtime`";
        $elements[5]->sort="1";
        $elements[5]->header="End Time";
        $elements[5]->alias="endtime";
        
        $elements[6]=new stdClass();
        $elements[6]->field="`predicto_prediction`.`order`";
        $elements[6]->sort="1";
        $elements[6]->header="Order";
        $elements[6]->alias="order";
        
        $elements[7]=new stdClass();
        $elements[7]->field="`predicto_predictiongroup`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="Prediction Group";
        $elements[7]->alias="predictiongroup";
        
        $elements[8]=new stdClass();
        $elements[8]->field="`predicto_teamgroup`.`name`";
        $elements[8]->sort="1";
        $elements[8]->header="Winner";
        $elements[8]->alias="predictionteam";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_prediction` LEFT OUTER JOIN `predicto_predictiongroup` ON `predicto_prediction`.`predictiongroup`=`predicto_predictiongroup`.`id` LEFT OUTER JOIN `predicto_predictionteam` ON `predicto_prediction`.`predictionteam`=`predicto_predictionteam`.`id` 
LEFT OUTER JOIN  `predicto_teamgroup`ON `predicto_predictionteam`.`teamgroup`=`predicto_teamgroup`.`id`");
        $this->load->view("json",$data);
    }

    public function createprediction()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createprediction";
        $data["title"]="Create prediction";
        $data['status']=$this->prediction_model->getpredictionstatusdropdown();
        $data['predictiongroup']=$this->predictiongroup_model->getpredictiongroupdropdown();
        $data['predictionteam']=$this->predictionteam_model->getpredictionteamdropdown();
        $this->load->view("template",$data);
    }
    public function createpredictionsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("predictiongroup","Prediction Group","trim");
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("status","Status","trim");
        $this->form_validation->set_rules("predictionteam","Winner","trim");
        $this->form_validation->set_rules("endtime","End Time","trim");
        $this->form_validation->set_rules("order","Order","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createprediction";
            $data['status']=$this->prediction_model->getpredictionstatusdropdown();
            $data['predictiongroup']=$this->predictiongroup_model->getpredictiongroupdropdown();
            $data['predictionteam']=$this->predictionteam_model->getpredictionteamdropdown();
            $data["title"]="Create prediction";
            $this->load->view("template",$data);
        }
        else
        {
            $predictiongroup=$this->input->get_post("predictiongroup");
            $name=$this->input->get_post("name");
            $status=$this->input->get_post("status");
            $predictionteam=$this->input->get_post("predictionteam");
            $endtime=$this->input->get_post("endtime");
            $order=$this->input->get_post("order");
            if($this->prediction_model->create($predictiongroup,$name,$status,$predictionteam,$endtime,$order)==0)
                $data["alerterror"]="New prediction could not be created.";
            else
                $data["alertsuccess"]="prediction created Successfully.";
            $data["redirect"]="site/viewprediction";
            $this->load->view("redirect",$data);
        }
    }
    public function editprediction()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editprediction";
        $data["title"]="Edit prediction";
        $data['status']=$this->prediction_model->getpredictionstatusdropdown();
        $data['predictiongroup']=$this->predictiongroup_model->getpredictiongroupdropdown();
        $data['predictionteam']=$this->predictionteam_model->getpredictionteamdropdown();
        $data["before"]=$this->prediction_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editpredictionsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("predictiongroup","Prediction Group","trim");
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("status","Status","trim");
        $this->form_validation->set_rules("predictionteam","Winner","trim");
        $this->form_validation->set_rules("endtime","End Time","trim");
        $this->form_validation->set_rules("order","Order","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editprediction";
            $data["title"]="Edit prediction";
            $data['status']=$this->prediction_model->getpredictionstatusdropdown();
            $data['predictiongroup']=$this->predictiongroup_model->getpredictiongroupdropdown();
            $data['predictionteam']=$this->predictionteam_model->getpredictionteamdropdown();
            $data["before"]=$this->prediction_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $predictiongroup=$this->input->get_post("predictiongroup");
            $name=$this->input->get_post("name");
            $status=$this->input->get_post("status");
            $predictionteam=$this->input->get_post("predictionteam");
            $endtime=$this->input->get_post("endtime");
            $order=$this->input->get_post("order");
            if($this->prediction_model->edit($id,$predictiongroup,$name,$status,$predictionteam,$endtime,$order)==0)
                $data["alerterror"]="New prediction could not be Updated.";
            else
                $data["alertsuccess"]="prediction Updated Successfully.";
            $data["redirect"]="site/viewprediction";
            $this->load->view("redirect",$data);
        }
    }
    public function deleteprediction()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->prediction_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewprediction";
        $this->load->view("redirect",$data);
    }
    public function viewpredictionteam()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewpredictionteam";
        $data["base_url"]=site_url("site/viewpredictionteamjson");
        $data["title"]="View predictionteam";
        $this->load->view("template",$data);
    }
    function viewpredictionteamjson()
    {
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`predicto_predictionteam`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`predicto_predictionteam`.`prediction`";
        $elements[1]->sort="1";
        $elements[1]->header="Prediction";
        $elements[1]->alias="predictionid";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`predicto_predictionteam`.`teamgroup`";
        $elements[2]->sort="1";
        $elements[2]->header="Team Group";
        $elements[2]->alias="teamgroupid";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`predicto_predictionteam`.`order`";
        $elements[3]->sort="1";
        $elements[3]->header="Order";
        $elements[3]->alias="order";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`predicto_prediction`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Prediction";
        $elements[4]->alias="prediction";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`predicto_teamgroup`.`name`";
        $elements[5]->sort="1";
        $elements[5]->header="Team Group";
        $elements[5]->alias="teamgroup";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_predictionteam` LEFT OUTER JOIN `predicto_prediction` ON `predicto_predictionteam`.`prediction`=`predicto_prediction`.`id` LEFT OUTER JOIN `predicto_teamgroup` ON `predicto_predictionteam`.`teamgroup`=`predicto_teamgroup`.`id`");
        $this->load->view("json",$data);
    }

    public function createpredictionteam()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createpredictionteam";
        $data["title"]="Create predictionteam";
        $data['prediction']=$this->prediction_model->getpredictiondropdown();
        $data['teamgroup']=$this->teamgroup_model->getteamgroupdropdown();
        $this->load->view("template",$data);
    }
    public function createpredictionteamsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("prediction","Prediction","trim");
        $this->form_validation->set_rules("teamgroup","Team Group","trim");
        $this->form_validation->set_rules("order","Order","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createpredictionteam";
            $data["title"]="Create predictionteam";
            $data['prediction']=$this->prediction_model->getpredictiondropdown();
            $data['teamgroup']=$this->teamgroup_model->getteamgroupdropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $prediction=$this->input->get_post("prediction");
            $teamgroup=$this->input->get_post("teamgroup");
            $order=$this->input->get_post("order");
            if($this->predictionteam_model->create($prediction,$teamgroup,$order)==0)
                $data["alerterror"]="New predictionteam could not be created.";
            else
                $data["alertsuccess"]="predictionteam created Successfully.";
            $data["redirect"]="site/viewpredictionteam";
            $this->load->view("redirect",$data);
        }
    }
    public function editpredictionteam()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editpredictionteam";
        $data["title"]="Edit predictionteam";
        $data['prediction']=$this->prediction_model->getpredictiondropdown();
        $data['teamgroup']=$this->teamgroup_model->getteamgroupdropdown();
        $data["before"]=$this->predictionteam_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editpredictionteamsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("prediction","Prediction","trim");
        $this->form_validation->set_rules("teamgroup","Team Group","trim");
        $this->form_validation->set_rules("order","Order","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editpredictionteam";
            $data["title"]="Edit predictionteam";
            $data['prediction']=$this->prediction_model->getpredictiondropdown();
            $data['teamgroup']=$this->teamgroup_model->getteamgroupdropdown();
            $data["before"]=$this->predictionteam_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $prediction=$this->input->get_post("prediction");
            $teamgroup=$this->input->get_post("teamgroup");
            $order=$this->input->get_post("order");
            if($this->predictionteam_model->edit($id,$prediction,$teamgroup,$order)==0)
                $data["alerterror"]="New predictionteam could not be Updated.";
            else
                $data["alertsuccess"]="predictionteam Updated Successfully.";
            $data["redirect"]="site/viewpredictionteam";
            $this->load->view("redirect",$data);
        }
    }
    public function deletepredictionteam()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->predictionteam_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewpredictionteam";
        $this->load->view("redirect",$data);
    }
    public function viewuserprediction()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewuserprediction";
        $data["base_url"]=site_url("site/viewuserpredictionjson");
        $data["title"]="View userprediction";
        $this->load->view("template",$data);
    }
    function viewuserpredictionjson()
    {
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`predicto_userprediction`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`predicto_userprediction`.`user`";
        $elements[1]->sort="1";
        $elements[1]->header="User";
        $elements[1]->alias="userid";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`predicto_userprediction`.`teamgroup`";
        $elements[2]->sort="1";
        $elements[2]->header="Team Group";
        $elements[2]->alias="teamgroupid";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`predicto_userprediction`.`prediction`";
        $elements[3]->sort="1";
        $elements[3]->header="Prediction";
        $elements[3]->alias="predictionid";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`user`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="User";
        $elements[4]->alias="user";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`predicto_teamgroup`.`name`";
        $elements[5]->sort="1";
        $elements[5]->header="Team Group";
        $elements[5]->alias="teamgroup";
        
        $elements[6]=new stdClass();
        $elements[6]->field="`predicto_prediction`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Prediction";
        $elements[6]->alias="prediction";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_userprediction` LEFT OUTER JOIN `predicto_prediction` ON `predicto_userprediction`.`prediction`=`predicto_prediction`.`id` LEFT OUTER JOIN `user` ON `predicto_userprediction`.`user`=`user`.`id`  LEFT OUTER JOIN `predicto_teamgroup` ON `predicto_userprediction`.`teamgroup`=`predicto_teamgroup`.`id` ");
        $this->load->view("json",$data);
    }

    public function createuserprediction()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createuserprediction";
        $data["title"]="Create userprediction";
        $data['user']=$this->user_model->getuserdropdown();
        $data['teamgroup']=$this->teamgroup_model->getteamgroupdropdown();
        $data['prediction']=$this->prediction_model->getpredictiondropdown();
        $this->load->view("template",$data);
    }
    public function createuserpredictionsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("user","User","trim");
        $this->form_validation->set_rules("teamgroup","Team Group","trim");
        $this->form_validation->set_rules("prediction","Prediction","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createuserprediction";
            $data["title"]="Create userprediction";
            $data['user']=$this->user_model->getuserdropdown();
            $data['teamgroup']=$this->teamgroup_model->getteamgroupdropdown();
            $data['prediction']=$this->prediction_model->getpredictiondropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $user=$this->input->get_post("user");
            $teamgroup=$this->input->get_post("teamgroup");
            $prediction=$this->input->get_post("prediction");
            if($this->userprediction_model->create($user,$teamgroup,$prediction)==0)
                $data["alerterror"]="New userprediction could not be created.";
            else
                $data["alertsuccess"]="userprediction created Successfully.";
            $data["redirect"]="site/viewuserprediction";
            $this->load->view("redirect",$data);
        }
    }
    public function edituserprediction()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="edituserprediction";
        $data["title"]="Edit userprediction";
        $data['user']=$this->user_model->getuserdropdown();
        $data['teamgroup']=$this->teamgroup_model->getteamgroupdropdown();
        $data['prediction']=$this->prediction_model->getpredictiondropdown();
        $data["before"]=$this->userprediction_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function edituserpredictionsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("user","User","trim");
        $this->form_validation->set_rules("teamgroup","Team Group","trim");
        $this->form_validation->set_rules("prediction","Prediction","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="edituserprediction";
            $data["title"]="Edit userprediction";
            $data['user']=$this->user_model->getuserdropdown();
            $data['teamgroup']=$this->teamgroup_model->getteamgroupdropdown();
            $data['prediction']=$this->prediction_model->getpredictiondropdown();
            $data["before"]=$this->userprediction_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $user=$this->input->get_post("user");
            $teamgroup=$this->input->get_post("teamgroup");
            $prediction=$this->input->get_post("prediction");
            if($this->userprediction_model->edit($id,$user,$teamgroup,$prediction)==0)
            $data["alerterror"]="New userprediction could not be Updated.";
            else
            $data["alertsuccess"]="userprediction Updated Successfully.";
            $data["redirect"]="site/viewuserprediction";
            $this->load->view("redirect",$data);
        }
    }
    public function deleteuserprediction()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->userprediction_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewuserprediction";
        $this->load->view("redirect",$data);
    }
    
    
    public function viewpredictionhash()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewpredictionhash";
        $data["base_url"]=site_url("site/viewpredictionhashjson");
        $data["title"]="View predictionhash";
        $this->load->view("template",$data);
    }
    function viewpredictionhashjson()
    {
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`predicto_predictionhash`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`predicto_predictionhash`.`prediction`";
        $elements[1]->sort="1";
        $elements[1]->header="Prediction";
        $elements[1]->alias="prediction";
        
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
            $maxrow=20;
        }
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_predictionhash`");
        $this->load->view("json",$data);
    }

    public function createpredictionhash()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createpredictionhash";
        $data["title"]="Create predictionhash";
        $data['prediction']=$this->prediction_model->getpredictiondropdown();
        $this->load->view("template",$data);
    }
    public function createpredictionhashsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("prediction","Prediction","trim");
        $this->form_validation->set_rules("hashtag","Hash Tag","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createpredictionhash";
            $data["title"]="Create predictionhash";
            $data['prediction']=$this->prediction_model->getpredictiondropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $prediction=$this->input->get_post("prediction");
            $hashtag=$this->input->get_post("hashtag");
            if($this->predictionhash_model->create($prediction,$hashtag)==0)
                $data["alerterror"]="New predictionhash could not be created.";
            else
                $data["alertsuccess"]="predictionhash created Successfully.";
            $data["redirect"]="site/viewpredictionhash";
            $this->load->view("redirect",$data);
        }
    }
    public function editpredictionhash()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editpredictionhash";
        $data["title"]="Edit predictionhash";
        $data['prediction']=$this->prediction_model->getpredictiondropdown();
        $data["before"]=$this->predictionhash_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editpredictionhashsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("prediction","Prediction","trim");
        $this->form_validation->set_rules("hashtag","Hash Tag","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editpredictionhash";
            $data["title"]="Edit predictionhash";
            $data['prediction']=$this->prediction_model->getpredictiondropdown();
            $data["before"]=$this->predictionhash_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $prediction=$this->input->get_post("prediction");
            $hashtag=$this->input->get_post("hashtag");
            if($this->predictionhash_model->edit($id,$prediction,$hashtag)==0)
                $data["alerterror"]="New predictionhash could not be Updated.";
            else
                $data["alertsuccess"]="predictionhash Updated Successfully.";
            $data["redirect"]="site/viewpredictionhash";
            $this->load->view("redirect",$data);
        }
    }
    public function deletepredictionhash()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->predictionhash_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewpredictionhash";
        $this->load->view("redirect",$data);
    }
    public function viewusershare()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewusershare";
        $data["base_url"]=site_url("site/viewusersharejson");
        $data["title"]="View usershare";
        $this->load->view("template",$data);
    }
    function viewusersharejson()
    {
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`predicto_usershare`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`predicto_usershare`.`user`";
        $elements[1]->sort="1";
        $elements[1]->header="User";
        $elements[1]->alias="userid";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`predicto_usershare`.`sharecontent`";
        $elements[2]->sort="1";
        $elements[2]->header="Share Content";
        $elements[2]->alias="sharecontent";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`predicto_usershare`.`total`";
        $elements[3]->sort="1";
        $elements[3]->header="Total";
        $elements[3]->alias="total";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`predicto_usershare`.`prediction`";
        $elements[4]->sort="1";
        $elements[4]->header="Prediction";
        $elements[4]->alias="predictionid";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`predicto_prediction`.`name`";
        $elements[5]->sort="1";
        $elements[5]->header="Prediction";
        $elements[5]->alias="prediction";
        
        $elements[6]=new stdClass();
        $elements[6]->field="`user`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="User";
        $elements[6]->alias="user";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_usershare` LEFT OUTER JOIN `predicto_prediction` ON `predicto_usershare`.`prediction`=`predicto_prediction`.`id` LEFT OUTER JOIN `user` ON `predicto_usershare`.`user`=`user`.`id`  ");
        $this->load->view("json",$data);
    }

    public function createusershare()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createusershare";
        $data["title"]="Create usershare";
        $data['user']=$this->user_model->getuserdropdown();
        $data['prediction']=$this->prediction_model->getpredictiondropdown();
        $data['predictionhash']=$this->predictionhash_model->getpredictionhashdropdown();
        $this->load->view("template",$data);
    }
    public function createusersharesubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("user","User","trim");
        $this->form_validation->set_rules("sharecontent","Share Content","trim");
        $this->form_validation->set_rules("total","Total","trim");
        $this->form_validation->set_rules("prediction","Prediction","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createusershare";
            $data["title"]="Create usershare";
            $data['user']=$this->user_model->getuserdropdown();
            $data['predictionhash']=$this->predictionhash_model->getpredictionhashdropdown();
            $data['prediction']=$this->prediction_model->getpredictiondropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $user=$this->input->get_post("user");
            $sharecontent=$this->input->get_post("sharecontent");
            $total=$this->input->get_post("total");
            $prediction=$this->input->get_post("prediction");
            $predictionhash=$this->input->get_post("predictionhash");
            if($this->usershare_model->create($user,$sharecontent,$total,$prediction,$predictionhash)==0)
                $data["alerterror"]="New usershare could not be created.";
            else
                $data["alertsuccess"]="usershare created Successfully.";
            $data["redirect"]="site/viewusershare";
            $this->load->view("redirect",$data);
        }
    }
    public function editusershare()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editusershare";
        $data["title"]="Edit usershare";
        $data['user']=$this->user_model->getuserdropdown();
        $data['predictionhash']=$this->predictionhash_model->getpredictionhashdropdown();
        $data['selectedpredictionhash']=$this->usershare_model->getusersharehashbyusershare($this->input->get_post('id'));
        $data['prediction']=$this->prediction_model->getpredictiondropdown();
        $data["before"]=$this->usershare_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editusersharesubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("user","User","trim");
        $this->form_validation->set_rules("sharecontent","Share Content","trim");
        $this->form_validation->set_rules("total","Total","trim");
        $this->form_validation->set_rules("prediction","Prediction","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editusershare";
            $data["title"]="Edit usershare";
            $data['user']=$this->user_model->getuserdropdown();
            $data['prediction']=$this->prediction_model->getpredictiondropdown();
            $data["before"]=$this->usershare_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $user=$this->input->get_post("user");
            $sharecontent=$this->input->get_post("sharecontent");
            $total=$this->input->get_post("total");
            $prediction=$this->input->get_post("prediction");
            $predictionhash=$this->input->get_post("predictionhash");
            if($this->usershare_model->edit($id,$user,$sharecontent,$total,$prediction,$predictionhash)==0)
                $data["alerterror"]="New usershare could not be Updated.";
            else
                $data["alertsuccess"]="usershare Updated Successfully.";
            $data["redirect"]="site/viewusershare";
            $this->load->view("redirect",$data);
        }
    }
    public function deleteusershare()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->usershare_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewusershare";
        $this->load->view("redirect",$data);
    }
    public function viewusersharehash()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewusersharehash";
        $data["base_url"]=site_url("site/viewusersharehashjson");
        $data["title"]="View usersharehash";
        $this->load->view("template",$data);
    }
    function viewusersharehashjson()
    {
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`predicto_usersharehash`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`predicto_usersharehash`.`usershare`";
        $elements[1]->sort="1";
        $elements[1]->header="User Share";
        $elements[1]->alias="usershare";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`predicto_usersharehash`.`predictionhash`";
        $elements[2]->sort="1";
        $elements[2]->header="Prediction Hash";
        $elements[2]->alias="predictionhash";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`predicto_usershare`.`sharecontent`";
        $elements[3]->sort="1";
        $elements[3]->header="User Share";
        $elements[3]->alias="usershare";
        
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
            $maxrow=20;
        }
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_usersharehash`  LEFT OUTER JOIN `predicto_usershare` ON `predicto_usersharehash`.`usershare`=`predicto_usershare`.`id` LEFT OUTER JOIN `user` ON `predicto_usershare`.`user`=`user`.`id` ");
        $this->load->view("json",$data);
    }

    public function createusersharehash()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createusersharehash";
        $data["title"]="Create usersharehash";
        $data['predictionhash']=$this->predictionhash_model->getpredictionhashdropdown();
        $data['usershare']=$this->usershare_model->getusersharedropdown();
        $this->load->view("template",$data);
    }
    public function createusersharehashsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("usershare","User Share","trim");
        $this->form_validation->set_rules("predictionhash","Prediction Hash","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createusersharehash";
            $data["title"]="Create usersharehash";
            $data['predictionhash']=$this->predictionhash_model->getpredictionhashdropdown();
            $data['usershare']=$this->usershare_model->getusersharedropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $usershare=$this->input->get_post("usershare");
            $predictionhash=$this->input->get_post("predictionhash");
            if($this->usersharehash_model->create($usershare,$predictionhash)==0)
                $data["alerterror"]="New usersharehash could not be created.";
            else
                $data["alertsuccess"]="usersharehash created Successfully.";
            $data["redirect"]="site/viewusersharehash";
            $this->load->view("redirect",$data);
        }
    }
    public function editusersharehash()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editusersharehash";
        $data["title"]="Edit usersharehash";
        $data['predictionhash']=$this->predictionhash_model->getpredictionhashdropdown();
        $data['usershare']=$this->usershare_model->getusersharedropdown();
        $data["before"]=$this->usersharehash_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editusersharehashsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("usershare","User Share","trim");
        $this->form_validation->set_rules("predictionhash","Prediction Hash","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editusersharehash";
            $data["title"]="Edit usersharehash";
            $data['predictionhash']=$this->predictionhash_model->getpredictionhashdropdown();
            $data['usershare']=$this->usershare_model->getusersharedropdown();
            $data["before"]=$this->usersharehash_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $usershare=$this->input->get_post("usershare");
            $predictionhash=$this->input->get_post("predictionhash");
            if($this->usersharehash_model->edit($id,$usershare,$predictionhash)==0)
            $data["alerterror"]="New usersharehash could not be Updated.";
            else
            $data["alertsuccess"]="usersharehash Updated Successfully.";
            $data["redirect"]="site/viewusersharehash";
            $this->load->view("redirect",$data);
        }
    }
    public function deleteusersharehash()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->usersharehash_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewusersharehash";
        $this->load->view("redirect",$data);
    }
    public function viewuserpointlog()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewuserpointlog";
        $data["base_url"]=site_url("site/viewuserpointlogjson");
        $data["title"]="View userpointlog";
        $this->load->view("template",$data);
    }
    function viewuserpointlogjson()
    {
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`predicto_userpointlog`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`predicto_userpointlog`.`point`";
        $elements[1]->sort="1";
        $elements[1]->header="Point";
        $elements[1]->alias="point";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`predicto_userpointlog`.`for`";
        $elements[2]->sort="1";
        $elements[2]->header="For";
        $elements[2]->alias="for";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`predicto_userpointlog`.`prediction`";
        $elements[3]->sort="1";
        $elements[3]->header="Prediction";
        $elements[3]->alias="predictionid";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`predicto_userpointlog`.`shareid`";
        $elements[4]->sort="1";
        $elements[4]->header="share ID";
        $elements[4]->alias="shareid";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`predicto_prediction`.`name`";
        $elements[5]->sort="1";
        $elements[5]->header="Prediction";
        $elements[5]->alias="prediction";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `predicto_userpointlog` LEFT OUTER JOIN  `predicto_prediction`ON `predicto_userpointlog`.`prediction`=`predicto_prediction`.`id`");
        $this->load->view("json",$data);
    }

    public function createuserpointlog()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createuserpointlog";
        $data["title"]="Create userpointlog";
        $data['prediction']=$this->prediction_model->getpredictiondropdown();
        $data['for']=$this->userpointlog_model->getfordropdown();
        $this->load->view("template",$data);
    }
    public function createuserpointlogsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("point","Point","trim");
        $this->form_validation->set_rules("for","For","trim");
        $this->form_validation->set_rules("prediction","Prediction","trim");
        $this->form_validation->set_rules("shareid","share ID","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createuserpointlog";
            $data["title"]="Create userpointlog";
            $data['prediction']=$this->prediction_model->getpredictiondropdown();
            $data['for']=$this->userpointlog_model->getfordropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $point=$this->input->get_post("point");
            $for=$this->input->get_post("for");
            $prediction=$this->input->get_post("prediction");
            $shareid=$this->input->get_post("shareid");
            if($this->userpointlog_model->create($point,$for,$prediction,$shareid)==0)
            $data["alerterror"]="New userpointlog could not be created.";
            else
            $data["alertsuccess"]="userpointlog created Successfully.";
            $data["redirect"]="site/viewuserpointlog";
            $this->load->view("redirect",$data);
        }
    }
    public function edituserpointlog()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="edituserpointlog";
        $data["title"]="Edit userpointlog";
        $data['prediction']=$this->prediction_model->getpredictiondropdown();
        $data['for']=$this->userpointlog_model->getfordropdown();
        $data["before"]=$this->userpointlog_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function edituserpointlogsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("point","Point","trim");
        $this->form_validation->set_rules("for","For","trim");
        $this->form_validation->set_rules("prediction","Prediction","trim");
        $this->form_validation->set_rules("shareid","share ID","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="edituserpointlog";
            $data["title"]="Edit userpointlog";
            $data['prediction']=$this->prediction_model->getpredictiondropdown();
            $data['for']=$this->userpointlog_model->getfordropdown();
            $data["before"]=$this->userpointlog_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $point=$this->input->get_post("point");
            $for=$this->input->get_post("for");
            $prediction=$this->input->get_post("prediction");
            $shareid=$this->input->get_post("shareid");
            if($this->userpointlog_model->edit($id,$point,$for,$prediction,$shareid)==0)
                $data["alerterror"]="New userpointlog could not be Updated.";
            else
                $data["alertsuccess"]="userpointlog Updated Successfully.";
            $data["redirect"]="site/viewuserpointlog";
            $this->load->view("redirect",$data);
        }
    }
    public function deleteuserpointlog()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->userpointlog_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewuserpointlog";
        $this->load->view("redirect",$data);
    }

}
?>
