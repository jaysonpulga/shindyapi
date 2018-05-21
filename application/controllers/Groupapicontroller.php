<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');

/**
 * Description of RestPostController
 *
 * @author https://roytuts.com
 */
class Groupapicontroller extends REST_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('RESTgroup_model', 'group');
		$this->load->model('RESTUsers_model', 'user');
		$this->load->library('form_validation');
    }
	
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	 function create_group_post(){
		
		$data = array();
		$data['title'] 			= $this->post('title');
		$data['description'] 	= $this->post('description');
		$data['code']  			= $this->generateRandomString(6);
		$data['tag']			= $this->post('tag');
		$data['bool'] 			= $this->post('bool');
		$data['createdby'] 		= $this->post('createdby');
		$data['createdate'] 	= gmdate("Y-m-d h:i:s");
		$data['updatedate'] 	= gmdate("Y-m-d h:i:s");
		
		 $this->form_validation
		->set_rules('title', 'title', 'required')
		->set_rules('createdby', 'created user', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'title' => form_error('title'),
                'createdby' => form_error('createdby'),	
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		} 
       

	
		$resultid = $this->group->add_group($data);
		
	
	
        if($resultid > 0 )
		{
			$this->response(array('status' => 'success' , 'result' =>  $data['code']));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
    }
	
	function update_group_post()
	{
		
		$data 		= array();

		$data['title'] 			= $this->post('title');
		$data['description'] 	= $this->post('description');
		$data['tag']			= $this->post('tag');
		$data['bool'] 			= $this->post('bool');
		$data['createdby'] 		= $this->post('createdby');
		$data['updatedate'] 	= gmdate("Y-m-d h:i:s");
		
		$condition 				= array('code' => $this->post('code'),'id' => $this->post('id'));
		
		
		$this->form_validation
		->set_rules('title', 'title', 'required')
		->set_rules('code', 'code', 'required')
		->set_rules('id', 'id', 'required')
		->set_rules('createdby', 'createdby', 'required|valid_email')
		->set_error_delimiters('', '');
		
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'title' => form_error('title'),
                'code' => form_error('code'),	
				'id' => form_error('id'),
				'createdby' => form_error('createdby')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
  
		
		$resultid = $this->group->update_group($data,$condition);
		
        if($resultid > 0 )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
    }
	
	function grouplist_get()
	{
	
		
		if (!$this->get('param_search'))
		{
             $user = $this->group->grouplist($param_search='');
        }
		else
		{
			  $user = $this->group->grouplist($this->get('param_search'));
		}
	
		
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
    }
	
	function joingroup_post()
	{
		
		
		$data = array();
		$data['member_status'] 	= 1;
		$data['groupid'] 		= $this->post('groupid');
		$data['user_fbid'] 	= $this->post('user_fbid');
		$data['joindate'] 		= gmdate("Y-m-d h:i:s");
		
		
		 $this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('groupid', 'groupid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
				'groupid' => form_error('groupid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		
		$count = $this->group->checkifgroupexist($data['groupid']);
		if($count == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid group id or  there's no existing group on database "));
			exit();
        }
		
		
		$count = $this->group->checkifuserxistin_userdb($data['user_fbid']);
		if($count == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		
		
		$count = $this->group->checkifuserjoined($data['user_fbid'],$data['groupid']);
		if($count > 0 )
		{
           
			$this->response(array('status'=> 'failed' , 'result' => " ".$data['user_fbid']." is already joined in this group"));
			exit();
        }
       
		

	
		$resultid = $this->group->joingroup($data);
		
	
        if($resultid > 0 )
		{
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	}
	
	
	function joingroupentrycode_post()
	{
		
		
		$data = array();
	
		$data['member_status'] 	= 1;
		$data['user_fbid'] 	= $this->post('user_fbid');
		$data['groupcode'] 		= $this->post('groupcode');
		$data['joindate'] 		= gmdate("Y-m-d h:i:s");
		
		$this->form_validation->set_rules('groupcode', 'groupcode', 'required')
		  ->set_rules('user_fbid', 'user_fbid', 'required')
		  ->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE){
			
			$error_data[] = array(
                'groupcode' => form_error('groupcode'),
                'user_fbid' => form_error('user_fbid')
         );
			
			$this->response(array("status" => False,'error' =>$error_data));
			exit();
			
		}
		
		$dataresponse = $this->group->checkifcodeexist($this->post('groupcode'));
		if(count($dataresponse) == 0 )
		{
           
			$this->response(array('status'=> 'failed' , 'result' => 'invalid group code'));
			exit();
        }
		
		
		$data['groupid'] = $dataresponse[0]->id;
		
		
		$count = $this->group->checkifuserxistin_userdb($data['user_fbid']);
		if($count == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		
		$count = $this->group->checkifuserjoined($data['user_fbid'],$data['groupid']);
		if($count > 0 )
		{
           
			$this->response(array('status'=> 'failed' , 'result' => " ".$data['user_fbid']." is already joined in this group"));
			exit();
        }
		
        

	
		$resultid = $this->group->joingroup($data);

	
        if($resultid > 0 )
		{
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	}
	
	
	function leavegroup_post()
	{
		$data = array();
		$data['member_status'] 	= 2;
		$data['groupid'] 		= $this->post('groupid');
		$data['user_fbid'] 	= $this->post('user_fbid');
		$data['leavedate'] 		= gmdate("Y-m-d h:i:s");
		
	
		 $this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('groupid', 'groupid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
				'groupid' => form_error('groupid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$condition =  array('groupid' => $this->post('groupid'),'user_fbid' => $this->post('user_fbid'));
	
		$resultid = $this->group->leavegroup($data,$condition);
		
	
        if($resultid > 0 )
		{
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed', 'result'=>'either group is not exist or user fbid is not in group please check the value'));
        }
		
	}
	
	
	function blockuseringroup_post()
	{
		$data = array();
		$data['member_status'] 	= 3;
		$data['groupid'] 		= $this->post('groupid');
		$data['user_fbid'] 		= $this->post('user_fbid');
		$data['blockdate'] 		= gmdate("Y-m-d h:i:s");
		
	
		 $this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('groupid', 'groupid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
				'groupid' => form_error('groupid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$condition =  array('groupid' => $this->post('groupid'),'user_fbid' => $this->post('user_fbid'));
	
		$resultid = $this->group->blockuseringroup($data,$condition);
		
	
        if($resultid > 0 )
		{
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed', 'result'=>'either group is not exist or user fbid is not in group please check the value'));
        }
		
	}
	
	function unblockusergroup_post()
	{
		$data = array();
		$data['member_status'] 	= 1;
		$data['groupid'] 		= $this->post('groupid');
		$data['user_fbid'] 	= $this->post('user_fbid');

		 $this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('groupid', 'groupid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
				'groupid' => form_error('groupid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$condition =  array('groupid' => $this->post('groupid'),'user_fbid' => $this->post('user_fbid'));
	
		$resultid = $this->group->unblockusergroup($data,$condition);
		
	
        if($resultid > 0 )
		{
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed', 'result'=>'either group is not exist or user fbid is not in group please check the value'));
        }
		
	}
	
	
	
	
	function grouplistactivemember_get()
	{
		
	
		$user = $this->group->grouplistactivemember($this->get('groupid'));
		
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
		
	}
	
	function blockedmemberofgroup_get()
	{
		
	
		$user = $this->group->blockedmemberofgroup($this->get('groupid'));
		
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
		
	}
	
	function leavedmemberofgroup_get()
	{
		
	
		$user = $this->group->leavedmemberofgroup($this->get('groupid'));
		
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
		
	}
	
	
	function Sendgroup_message_post()
	{
		
		
		$data = array();
		$data['groupid'] 		= $this->post('groupid');
		$data['sender_fbid'] 	= $this->post('sender_fbid');
		$data['message'] 		= $this->post('message');
		$data['msg_date'] 		= gmdate("Y-m-d h:i:s");
		
		
		 $this->form_validation
		->set_rules('sender_fbid', 'user fbid', 'required')
		->set_rules('groupid', 'groupid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'sender_fbid' => form_error('sender_fbid'),
				'groupid' => form_error('groupid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		
		$count1 = $this->group->checkifgroupexist($data['groupid']);
		if($count1 == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid group id or  there's no existing group on database "));
			exit();
        }
		
		
		$count3 = $this->user->checkifuserxistin_userdb($data['sender_fbid']);
		if($count3 == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid sender_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		
		
		$count2 = $this->group->checkifuserisjoinedingroup($data['sender_fbid'],$data['groupid']);
		if($count2 == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "this user cannot send message either not a group member or user status is not active"));
			exit();
        }
       
		

	
		$resultid = $this->group->Sendgroup_message($data);
		
	
        if($resultid > 0 )
		{
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	}
	
	function listmessageofgroup_get()
	{
		
	
		$user = $this->group->listmessageofgroup($this->get('groupid'));
		
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
		
	}
	
	
	
}