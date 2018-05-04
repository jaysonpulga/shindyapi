<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');

/**
 * Description of RestPostController
 *
 * @author https://roytuts.com
 */
class Messageapicontroller extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('RESTmessage_model', 'message');
		$this->load->library('form_validation');				
		$this->load->helper('url'); 
    }		
	
	function generateRandomString($length = 10)
	{		
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';		
		$charactersLength = strlen($characters);		
		$randomString = '';		
		for ($i = 0; $i < $length; $i++)
		{			
			$randomString .= $characters[rand(0, $charactersLength - 1)];		
		}		
		return $randomString;	
	}	
	
	function SendMessage_post()
	{
		
		$datamessage = array();
		$datamessage['sender_id']  	 = $this->post('sender_id');
		$datamessage['recipient_id'] = $this->post('recipient_id');
		$datamessage['message']		 = $this->post('message');
		$datamessage['msg_status'] 	 = 1;
		$datamessage['sent_date'] 	 = gmdate("Y-m-d h:i:s");
		if(base64_encode(base64_decode($datamessage['message'], true)) ===  $datamessage['message'])
		{          		   
			$datamessage['message']   	= 	$this->post('message');	
			$datamessage['file_code']   =  $this->generateRandomString(10);       		
		}		
		else 
		{	
			$datamessage['message']  = $this->post('message');		
		}				
				
		$this->form_validation
		->set_rules('sender_id', 'sender_id', 'required')
		->set_rules('recipient_id', 'recipient_id', 'required')
		->set_rules('message', 'message', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'sender_id' => form_error('sender_id'),
                'recipient_id' => form_error('recipient_id'),
				'message' => form_error('message')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$result = $this->message->SendMessage($datamessage);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }		
		
	}
	
	function Seenmessage_post()
	{
		$datamessage = array();
		$datamessage['recipient_id']  = $this->post('recipient_id');
		$datamessage['msg_id']  	  = $this->post('msg_id');
		$datamessage['msg_status'] 	  = 2;
		$datamessage['seen_date'] 	  = gmdate("Y-m-d h:i:s");
		
		
		$this->form_validation
		->set_rules('recipient_id', 'recipient_id', 'required')
		->set_rules('msg_id', 'msg_id', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'msg_id' => form_error('msg_id'),
                'recipient_id' => form_error('recipient_id')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$condition =  array('recipient_id' => $this->post('recipient_id'),'msg_id' => $this->post('msg_id'));
		
		
		$count = $this->message->checkifhaveamessage($condition);
		if(count($count) == 0 )
		{
			$msgid = $datamessage['msg_id'];
			$rid = $datamessage['recipient_id'];
            $msg = "no sent message belong to this messageid = '$msgid' and recipient_id = '$rid' ";
			$this->response(array('status' => 'failed','result'=>$msg));
			exit();
        }
		
	
		$resultid = $this->message->Seenmessage($datamessage,$condition);
        if($resultid > 0 )
		{
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
		
		
	}
	
	
	function deletemessage_post()
	{
		$datamessage = array();
		$user_fbid 	  = $this->post('user_fbid');
		$msg_id 	  = $this->post('msg_id');
		
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('msg_id', 'msg_id', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'msg_id' => form_error('msg_id'),
                'user_fbid' => form_error('user_fbid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$condition =  array('msg_id' => $this->post('msg_id'));
	
		$resultid = $this->message->deletemessage($user_fbid,$condition);
		
	
        if($resultid > 0 )
		{
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
		
		
	}
	
	function getPMmessage_post()
	{
		
		$datamessage = array();
		$user_fbid 	  	  = $this->post('user_fbid');
		$friend_fbid 	  = $this->post('friend_fbid');
		
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('friend_fbid', 'friend_fbid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'friend_fbid' => form_error('friend_fbid'),
                'user_fbid' => form_error('user_fbid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$user = $this->message->getPMmessage($user_fbid,$friend_fbid);
			
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
		
		
	}
	
	function getAllmessage_post()
	{
	
		$datamessage = array();
		$user_fbid 	  	  = $this->post('user_fbid');		
		$search 	  	  = $this->post('search');
	
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
	
		$user = $this->message->getAllmessage($user_fbid,$search);
		
		
	        if (count($user)> 0) {
	            $this->response($user, 200);
	        } else {
				$this->response(array('status' => 'false','message' => 'no record found'));
	        }
	        
		
	}
	
}