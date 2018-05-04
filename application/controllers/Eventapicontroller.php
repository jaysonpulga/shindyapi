<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');

/**
 * Description of RestPostController
 *
 * @author https://roytuts.com
 */
class Eventapicontroller extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('RESTevent_model', 'event');
		$this->load->model('RESTUsers_model', 'user');
		$this->load->library('form_validation');
		$this->load->helper('url');
    }
	
	function inviteusers_get()
	{
		
	
		$user = $this->event->inviteusers($this->get('eventid'));
		
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
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
	
	public function uploadPhoto($img_desc,$resultid='')
	{
		// Upload directory
		$vpb_upload_image_directory = $_SERVER['DOCUMENT_ROOT'].'/rest_webservices/application/assets/event/';

		// Allow file types
		$vpb_allowed_extensions = array("gif", "jpg", "jpeg", "png");
		
		$return = array();
		$i = 0;
		foreach($img_desc as $file)
		{
			/* Variables Declaration and Assignments */
			$vpb_image_filename = basename($file['name']);
			$vpb_image_tmp_name = $file['tmp_name'];;
			$vpb_file_extensions = pathinfo(strtolower($vpb_image_filename), PATHINFO_EXTENSION);
			
			//New file name
			$random_name_generated = time().rand(123456789,987654321).'.'.$vpb_file_extensions;
			
			//path name
			$newpathname = base_url().'application/assets/event/'.$random_name_generated;
		
			if($vpb_image_filename == "") 
			{
				//Browse for a photo that you wish to use
			}
			else
			{
				if (in_array($vpb_file_extensions, $vpb_allowed_extensions)) 
				{
					if(move_uploaded_file($vpb_image_tmp_name, $vpb_upload_image_directory.$random_name_generated)) 
					 {	
								$return[] = base64_encode($newpathname);
								$dataimage = array();
								
								$dataimage['image'] = base64_encode($newpathname);
								$dataimage['eventid'] =$resultid;
								$this->event->save_image_event($dataimage);
							
						 
								//$result[$i] = array( 'pathname' => $random_name_generated );
								//array_push($return,$result[$i]);
								//$i++;	
					 }
				}
				
				
			}
		}

		return implode(",",$return);
	}
	
	
	function uploadPhoto_image($img_encoded,$resultid='')
	{
		$img_encoded = preg_replace('#data:image/[^;]+;base64,#', '',$img_encoded);
		$myArray = explode(',', $img_encoded);
		$dataimage = array();
		
	
		
		foreach($myArray as $newpathname)
		{
					$dataimage['image_code'] = $this->generateRandomString(10);			
				    $dataimage['image'] = $newpathname;
				    $dataimage['eventid'] =$resultid;
				    $this->event->save_image_event($dataimage);
			
		}
		
	}
	
	
	function reArrayFiles($file)
	{
		$file_ary = array();
		$file_count = count($file['name']);
		$file_key = array_keys($file);
		
		
			
			
			for($i=0;$i<$file_count;$i++)
			{
				foreach($file_key as $val)
				{
					$file_ary[$i][$val] = $file[$val][$i];
				}
			}
		
		return $file_ary;
	}
	
	
	function uploadeventimage_post()
	{
		$img_desc   = array(); 
		
		$this->form_validation
		  ->set_rules('image', 'image', 'required')
		  ->set_rules('eventid', 'eventid fbid', 'required') 
		  ->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'image' => form_error('image'),
                'eventid' => form_error('eventid')
			);
			
			$this->response(array("status" => False,'error' =>$error_data));
			exit();
			
		}
		
		$eventexist = $this->event->checkifeventExist($this->post('eventid'));		
		if($eventexist == 0 )		
		{           			
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));			
			exit();        
		}
		
		if(!empty($this->post('image')))
		{
			
			$this->uploadPhoto_image($this->post('image'),$this->post('eventid'));	
			$this->response(array('status' => 'success'));
			
		}
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	}
	
	

    function create_event_post()
	{
		
		$data 		= array();
		$datasched  = array();
		$img_desc   = array(); 
		
		$data['eventcode'] 		= $this->generateRandomString(8);
		
		if(!empty($this->post('eventname')))
		{
			$data['eventname'] 		= $this->post('eventname');
		}
		
		if(!empty($this->post('fulladdress')))
		{
			$data['fulladdress'] 	= $this->post('fulladdress');
		}
		
		
		if(!empty($this->post('long')))
		{
			$data['long']  			= $this->post('long');
		}
		
		if(!empty($this->post('lat')))
		{
			$data['lat']			= $this->post('lat');
		}
		
		if(!empty($this->post('description')))
		{
			$data['description'] 	= $this->post('description');
		}
		
		if(!empty($this->post('notes')))
		{
			$data['notes'] 			= $this->post('notes');
		}
		
		if(!empty($this->post('ticketprice')))
		{
			$data['ticketprice'] 	= $this->post('ticketprice');
		}
		
		if(!empty($this->post('user_fbid')))
		{
			$data['user_fbid'] 		= $this->post('user_fbid');
		}
		
		if(!empty($this->post('representative')))
		{
			$data['representative'] = $this->post('representative');
		}
		
		if(!empty($this->post('website_url')))
		{
			$data['website_url']	 = $this->post('website_url');
		}
		
		
		if(!empty($this->post('guest_invite_friend')))
		{
			$data['guest_invite_friend']	 = $this->post('guest_invite_friend');
		}
		
		if(!empty($this->post('expirydate')))
		{
			$data['expirydate'] 	= $this->post('expirydate');
		}
		
		/* if(!empty(@$_FILES['image']))
		{
			if(@$_FILES['image']>0)
			{
				if(count(@$_FILES['image']) == count(@$_FILES['image'], COUNT_RECURSIVE)) 
				{
				  echo 'image field must be define as multidimensional array e.g fieldname = "image[]" ';
				  exit();
				}
				
				 $img_desc = $this->reArrayFiles(@$_FILES['image']);
				 
			}  
		} */
		
	
		
		$data['createdate'] 	= gmdate("Y-m-d h:i:s");
		$data['modifydate'] 	= gmdate("Y-m-d h:i:s");
	
	
		$this->form_validation
		  ->set_rules('eventname', 'eventname', 'required')
		  ->set_rules('user_fbid', 'user fbid', 'required')
		  ->set_rules('long', 'long', 'required')
		  ->set_rules('lat', 'lat', 'required')
		  ->set_rules('zipcode', 'zipcode', 'required')
		  
		  ->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE){
			
			$error_data[] = array(
                'eventname' => form_error('eventname'),
                'user_fbid' => form_error('user_fbid'),
				'long' => form_error('long'),
				'lat' => form_error('lat'),
				'zipcode' => form_error('zipcode'),
         );
			
			
			$this->response(array("status" => False,'error' =>$error_data));
			exit();
			
		}
				
        $resultid = $this->event->add_event($data);
		
		/* if(!empty($img_desc))
		{
			
			$this->uploadPhoto($img_desc,$resultid);
	
		}
		*/
		

		if(!empty($this->post('image')))
		{
			
			$this->uploadPhoto_image($this->post('image'),$resultid);	
			
		}
	
		

		
		
		
		$datasched['eventid'] 			= $resultid;
		
		
		if(!empty($this->post('sched_startdate')))
		{
			$datasched['sched_startdate'] 	= $this->post('sched_startdate');
		}
		
		if(!empty($this->post('start_time')))
		{
			$datasched['start_time']  		= $this->post('start_time');
		}
		
		if(!empty($this->post('sched_enddate')))
		{
			$datasched['sched_enddate']		= $this->post('sched_enddate');
		}
		
		if(!empty($this->post('end_time')))
		{
			$datasched['end_time'] 			= $this->post('end_time');
		}
		
		if(!empty($this->post('custom_price')))
		{
			$datasched['custom_price'] 		= $this->post('custom_price');
		}
		
		if(!empty($this->post('spot_available')))
		{
			$datasched['spot_available'] 	= $this->post('spot_available');
		}
		
		
		if(!empty($this->post('max_male')))
		{
				$datasched['max_male'] 			= $this->post('max_male');
		}
		
		if(!empty($this->post('max_female')))
		{
			$datasched['max_female'] 		= $this->post('max_female');
		}
		
		
	
		$result = $this->event->add_schedule($datasched);
	
        if($resultid > 0 )
		{
           
			$this->response(array('status' => 'success' , 'eventid' => $resultid , 'eventocde' => $data['eventcode'] ));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
    }
	
	
	
	function update_event_post()
	{
		
		$data 		= array();
		$datasched  = array();
		
		$condition 				= array('eventid' => $this->post('eventid'));
		
		if(!empty($this->post('eventname')))
		{
			$data['eventname'] 		= $this->post('eventname');
		}
		
		if(!empty($this->post('fulladdress')))
		{
			$data['fulladdress'] 	= $this->post('fulladdress');
		}
		
		
		if(!empty($this->post('long')))
		{
			$data['long']  			= $this->post('long');
		}
		
		if(!empty($this->post('lat')))
		{
			$data['lat']			= $this->post('lat');
		}
		
		if(!empty($this->post('description')))
		{
			$data['description'] 	= $this->post('description');
		}
		
		if(!empty($this->post('notes')))
		{
			$data['notes'] 			= $this->post('notes');
		}
		
		if(!empty($this->post('ticketprice')))
		{
			$data['ticketprice'] 	= $this->post('ticketprice');
		}
		
		if(!empty($this->post('user_fbid')))
		{
			$data['user_fbid'] 		= $this->post('user_fbid');
		}
		
		if(!empty($this->post('representative')))
		{
			$data['representative'] = $this->post('representative');
		}
		
		if(!empty($this->post('website_url')))
		{
			$data['website_url']	 = $this->post('website_url');
		}
		
		if(!empty($this->post('expirydate')))
		{
			$data['expirydate'] 	= $this->post('expirydate');
		}
		
		if(!empty($this->post('guest_invite_friend')))
		{
			$data['guest_invite_friend']	 = $this->post('guest_invite_friend');
		}
		
	/* 	if(!empty(@$_FILES['image']))
		{
			if(@$_FILES['image']>0)
			{
				if(count(@$_FILES['image']) == count(@$_FILES['image'], COUNT_RECURSIVE)) 
				{
				  echo 'image field must be define as multidimensional array e.g fieldname = "image[]" ';
				  exit();
				}
				
				 $img_desc = $this->reArrayFiles(@$_FILES['image']);
				 
					if(!empty($img_desc))
					{
						
						$this->uploadPhoto($img_desc,$this->post('eventid'));
				
					}
				 
				 //$dataphotoname  	= $this->uploadPhoto($img_desc);
				 //$data['image']   	= $dataphotoname;
			}  
		} */
		
		if(!empty($this->post('image')))
		{
			
			$this->uploadPhoto_image($this->post('image'),$this->post('eventid'));	
			
		}
		
		
		$data['modifydate'] 	= gmdate("Y-m-d h:i:s");
		
	
		
		$this->form_validation
		  ->set_rules('eventname', 'eventname', 'required')
		  ->set_rules('user_fbid', 'user fbid', 'required')
		  ->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE){
			
			$error_data[] = array(
                'eventname' => form_error('eventname'),
                'user_fbid' => form_error('user_fbid'),
				'fbid' => form_error('fbid')
         );
			
			
			$this->response(array("status" => False,'error' =>$error_data));
			exit();
			
		}
		
        $result = $this->event->update_event($data,$condition);
		
		$condition2 					= array('eventid' => $this->post('eventid'));
		
		if(!empty($this->post('sched_startdate')))
		{
			$datasched['sched_startdate'] 	= $this->post('sched_startdate');
		}
		
		if(!empty($this->post('start_time')))
		{
			$datasched['start_time']  		= $this->post('start_time');
		}
		
		if(!empty($this->post('sched_enddate')))
		{
			$datasched['sched_enddate']		= $this->post('sched_enddate');
		}
		
		if(!empty($this->post('end_time')))
		{
			$datasched['end_time'] 			= $this->post('end_time');
		}
		
		if(!empty($this->post('custom_price')))
		{
			$datasched['custom_price'] 		= $this->post('custom_price');
		}
		
		if(!empty($this->post('spot_available')))
		{
			$datasched['spot_available'] 	= $this->post('spot_available');
		}
		
		
		if(!empty($this->post('max_male')))
		{
				$datasched['max_male'] 			= $this->post('max_male');
		}
		
		if(!empty($this->post('max_female')))
		{
			$datasched['max_female'] 		= $this->post('max_female');
		}
		
		
		
		$resultid = $this->event->update_schedule($datasched,$condition2);
		
        if(($resultid > 0 || ($result > 0)) )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
    }
	
	function eventlist_get()
	{
		
	
		$user = $this->event->get_event_list($this->get('eventid'),$this->get('user_fbid'));
	
		if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        } 
    }
	
	
	function eventlistcreatedbyuser_get()
	{
		
	
		$user = $this->event->eventlistcreatedbyuser($this->get('user_fbid'));
		
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
    }
	
	
	function listeventyousendinvite_get()
	{
		
	
		$user = $this->event->listeventyousendinvite($this->get('user_fbid'));
		
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
    }
	
	
	
	function suggested_eventlist_get()
	{
		
	
		$user = $this->event->suggested_eventlist($this->get('eventid'));
		
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
    }
	
	

	function attending_event_post()
	{
		$dataevent = array();
		$dataevent['user_fbid']	 = $this->post('user_fbid');
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid  user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
	
		
		$user = $this->event->attending_event($dataevent['user_fbid'],$attend_status = 1);
			
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
		
	}
	
	
	function invited_event_post()
	{
		$dataevent = array();
		$dataevent['user_fbid']	 = $this->post('user_fbid');
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid  user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
	
		$user = $this->event->attending_event($dataevent['user_fbid'],$attend_status = 0);	
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
		
	}
	
	
	
	function whoisinvited_event_post()
	{
		$dataevent = array();
		$dataevent['user_fbid']	 	= $this->post('user_fbid');
		$dataevent['eventid']		 = $this->post('eventid');
		//$dataevent['invitestatus']	 = $this->post('invitestatus');
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
				'eventid' => form_error('eventid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		$user = $this->event->whoisinvited_event($dataevent);
			
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
		
	}
	

	function block_event_post()
	{
		
		$dataevent = array();
		$dataevent['blockcode'] 		= $this->generateRandomString(10);
		$dataevent['eventid']  			= preg_replace('/\s+/', '',$this->post('eventid'));
		$dataevent['user_fbid']			= preg_replace('/\s+/', '',$this->post('user_fbid'));
		$dataevent['block_status'] 		= 1;
		$dataevent['block_date'] 		= gmdate("Y-m-d h:i:s");
		
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'user_fbid' => form_error('user_fbid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		
		
		$result = $this->event->block_event($dataevent);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	}
	
	
	function unblock_event_post()
	{
		
		$dataevent = array();
		$dataevent['block_status'] 		= 0;
		$dataevent['unblock_date'] 		= gmdate("Y-m-d h:i:s");
		$dataevent['eventid']  			= preg_replace('/\s+/', '',$this->post('eventid'));
		$dataevent['user_fbid']			= preg_replace('/\s+/', '',$this->post('user_fbid'));
		
		
		$condition = array(
							'eventid' => $this->post('eventid'),
							'user_fbid' => $this->post('user_fbid')
						   );
		
		$this->form_validation
		->set_rules('user_fbid', 'user fbid', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_error_delimiters('', '');
		
		
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'user_fbid' => form_error('user_fbid'),
			
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
						   
						   
		
		$result = $this->event->unblock_event($dataevent,$condition);
		if($result > 0)
		{ 
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	
	}
	
	
	function eventblockedlist_get()
	{
		
	
		$user = $this->event->eventblockedlist($this->get('user_fbid'));
			
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
    }
	
	
	function like_event_post()
	{
		
		$dataevent = array();
		$dataevent['likecode'] 		= $this->generateRandomString(10);
		$dataevent['eventid']  		= preg_replace('/\s+/', '',$this->post('eventid'));
		$dataevent['user_fbid']		= preg_replace('/\s+/', '',$this->post('user_fbid'));
		$dataevent['like_status'] 		= 1;
		$dataevent['like_date'] 		= gmdate("Y-m-d h:i:s");
		
		
		$this->form_validation
		->set_rules('user_fbid', 'user fbid', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'user_fbid' => form_error('user_fbid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		$result = $this->event->like_event($dataevent);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	}
	
	
	function unlike_event_post()
	{
		
		$dataevent = array();
		$dataevent['like_status'] 		= 0;
		$dataevent['unlike_date'] 		= gmdate("Y-m-d h:i:s");
		$dataevent['eventid']  		= preg_replace('/\s+/', '',$this->post('eventid'));
		$dataevent['user_fbid']		= preg_replace('/\s+/', '',$this->post('user_fbid'));
		
		
		$this->form_validation
		->set_rules('user_fbid', 'user fbid', 'required')
		->set_rules('eventid', 'eventid', 'required')
		
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'user_fbid' => form_error('user_fbid')
				
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		
		$condition = array(
							'eventid' => $this->post('eventid'),
							'user_fbid' => $this->post('user_fbid')
						   );
		
		$result = $this->event->unlike_event($dataevent,$condition);
		if($result > 0)
		{ 
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	
	}
	
	
	function eventlikelist_get()
	{
		
	
		$user = $this->event->eventlikelist($this->get('user_fbid'));
			
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
    }
	
	
	
	function rate_event_post()
	{
		
		$dataevent = array();
		$dataevent['eventid']  			= $this->post('eventid');
		$dataevent['user_fbid']			= $this->post('user_fbid');
		
		if(!empty($this->post('rating')))
		{
			$dataevent['rating'] 			= $this->post('rating');
		}
		
		if(!empty($this->post('host_review')))
		{
			$dataevent['host_review'] 		= $this->post('host_review');
		}
		
		if(!empty($this->post('feedback')))
		{
			$dataevent['feedback'] 			= $this->post('feedback');
		}
		
		
		
		$dataevent['rate_date'] 		= gmdate("Y-m-d h:i:s");
		
		
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'user_fbid' => form_error('user_fbid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		$result = $this->event->rate_event($dataevent);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	}
	
	function updaterate_event_post()
	{
		
		$dataevent = array();
		$dataevent['eventid']  			= $this->post('eventid');
		$dataevent['user_fbid']			= $this->post('user_fbid');
		
		
		if(!empty($this->post('rating')))
		{
			$dataevent['rating'] 			= $this->post('rating');
		}
		
		if(!empty($this->post('host_review')))
		{
			$dataevent['host_review'] 		= $this->post('host_review');
		}
		
		if(!empty($this->post('feedback')))
		{
			$dataevent['feedback'] 			= $this->post('feedback');
		}
			
		$dataevent['update_date'] 		= gmdate("Y-m-d h:i:s");
		
		
		
		
		
		
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_error_delimiters('', '');
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'user_fbid' => form_error('user_fbid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$condition = array(
							'eventid' => $this->post('eventid'),
							'user_fbid' => $this->post('user_fbid')
						   );
		
		
		$result = $this->event->updaterate_event($dataevent,$condition);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	}
	
	
	function eventratelist_get()
	{
		
	
		$user = $this->event->eventratelist($this->get('eventid'));
			
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
    }
	
	
	function eventreviewlist_get()
	{
		
	
		$user = $this->event->eventreviewlist($this->get('user_fbid'));

			
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
    }
	
	
	
	/*
	function  joinevent_iamin_post()
	{
		$dataevent = array();
		$dataevent['eventid']  			= $this->post('eventid');
		$dataevent['attendee_id']		= $this->post('attendee_id');
		
		if(!empty($this->post('invite_by'))){
		$dataevent['invite_by']  		= $this->post('invite_by');
		}
		
		$dataevent['status'] 			= 1; // accept
		$dataevent['acceptdate'] 		= gmdate("Y-m-d h:i:s");
		
		$this->form_validation
		->set_rules('attendee_id', 'attendee_id', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_error_delimiters('', '');
		
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'attendee_id' => form_error('attendee_id'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['attendee_id']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		 
		$count = $this->event->checkifuseralreadyjoined($dataevent['eventid'],$dataevent['attendee_id']);
		if($count > 0 )
		{
           
			$this->response(array('status' => 'failed','result'=>'user already joined in this event'));
			exit();
        }
		
		$count = $this->event->checkifuserblockevent($dataevent['eventid'],$dataevent['attendee_id']);
		if($count > 0 )
		{
           
			$this->response(array('status' => 'failed','result'=>'user blocked this event  you cannot join this event'));
			exit();
        }
		
		$result = $this->event->sendinvite($dataevent);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
		
	}
	*/
	
	function sendinvite_post()
	{

		$dataevent = array();
		$dataevent['eventid']  			= $this->post('eventid');
		$dataevent['attendee_id']		= $this->post('attendee_id');
		$dataevent['invite_by'] 		= $this->post('invite_by');
		$dataevent['invitecode'] 		= $this->generateRandomString(10);
		
		if(!empty($this->post('anonymous_invite'))){
		$dataevent['anonymous_invite'] 	= $this->post('anonymous_invite');
		}
		if(!empty($this->post('offer_to_pay'))){
		$dataevent['offer_to_pay'] 	= $this->post('offer_to_pay');
		}
		
		$dataevent['status'] 			= 0; // pending
		$dataevent['invitedate'] 		= gmdate("Y-m-d h:i:s");
		
	
		
		$this->form_validation
		->set_rules('attendee_id', 'attendee_id', 'required')
		->set_rules('invite_by', 'invite_by', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'attendee_id' => form_error('attendee_id'),
				'invite_by' => form_error('invite_by'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
	
		
		$attendee_id = $this->user->checkifuserxistin_userdb($dataevent['attendee_id']);
		if($attendee_id == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid attendee_id for user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$invite_by = $this->user->checkifuserxistin_userdb($dataevent['invite_by']);
		if($invite_by == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid invite_by for user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		$blockuser = $this->user->checkifyoublockthisuser($dataevent['attendee_id'],$dataevent['invite_by']);
		if($blockuser >  0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "you wont be able to send an invitation if you are being blocked by the user"));
			exit();
        }
		

		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		
		if($dataevent['attendee_id'] ==  $dataevent['invite_by'])
		{
			$this->response(array('status' => 'failed','result'=>'you wont send invitation in your own account'));
			exit();
		}
		
		
		
		$count = $this->event->checkifuserblockevent($dataevent['eventid'],$dataevent['attendee_id']);
		if($count > 0 )
		{
           
			$this->response(array('status' => 'failed','result'=>'user blocked this event  you wont send invitation'));
			exit();
        }
		
		
		
		/* $count = $this->event->checkifuseralreadyjoined($dataevent['eventid'],$dataevent['attendee_id']);
		if($count > 0 )
		{
           
			$this->response(array('status' => 'failed','result'=>'user already joined in this event'));
			exit();
        } */
		
		$invitebyme = $this->event->checkifuserinvitetootheruser($dataevent['eventid'],$dataevent['invite_by'],$dataevent['attendee_id']);
		if($invitebyme >  0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "you are already send invitation in this event"));
			exit();
       	}
		
	
		
		$max = $this->event->checkifreachmaximuninvite($dataevent['eventid'],$dataevent['attendee_id']);
		if($max >= 2 )
		{
           
			$this->response(array('status' => 'failed','result'=>'you wont be able to send an invitation to the user because you have reach the allowed maximum invites in that event'));
			exit();
        }
		
		
		$result = $this->event->sendinvite($dataevent);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success' , 'invitecode' =>$dataevent['invitecode']) );
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	
	}
	
	/*
	function sendinvite_post()
	{
		
		$dataevent = array();
		$events = array();
		$data 						= $this->post('dataevent');
		
		//print_r($data);
		//exit();

		// set all the detail before inserting the records
		foreach($data as $recordData)
		{
			
			
			  if (array_key_exists("attendee_id",$recordData))
			  {
				  
					$dataevent['eventid']   	= $this->post('eventid');
					$dataevent['invite_by'] 	= $this->post('invite_by');
					$dataevent['status'] 		= 0; // pending
					$dataevent['invitedate'] 	= gmdate("Y-m-d h:i:s");
					$dataevent['attendee_id'] =  $recordData['attendee_id'];
					
				
					if(!empty($recordData['anonymous_invite']))
					{
						$dataevent['anonymous_invite'] 	= $recordData['anonymous_invite'];
					}
					
					if(!empty($recordData['offer_to_pay']))
					{
						$dataevent['offer_to_pay'] 	= $recordData['offer_to_pay'];
					}
				
				$events[] = $dataevent;	
					
			  }
		  
		}
		
		
		$this->form_validation
		->set_rules('invite_by', 'invite_by', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
				'eventid' => form_error('eventid'),
				'invite_by' => form_error('invite_by'),
			);
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		if(empty($events))
		{
				$this->response(array('status' => 'failed', 'result' => "select atleast one user to be invite in this event or check the parameter name attendee_id if correct"));
				exit();
			
		}
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		$invite_by = $this->user->checkifuserxistin_userdb($dataevent['invite_by']);
		if($invite_by == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid invite_by for user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
	
		$result_error = array();
		$result_success = array();
		$datareturn = array();
		
		foreach($events as $dataevent)
		{
				$error = 0;
				$success = 0;
				
				
				 $attendee_id = $this->user->checkifuserxistin_userdb($dataevent['attendee_id']);
				if($attendee_id == 0 )
				{
					$error++;
					$result_error[]["message"] = "invalid attendee_id value = ".$dataevent['attendee_id']." or  there's no existing user fbid on database";
				}
				
				if($dataevent['attendee_id'] ==  $dataevent['invite_by'])
				{
					$error++;
					$result_error[]["message"]  = "you cannot send invitation in your own account attendee_id  = ".$dataevent['attendee_id']." ";
				}
				
				$count = $this->event->checkifuseralreadyjoined($dataevent['eventid'],$dataevent['attendee_id']);
				if($count > 0 )
				{
					$error++;
				  	$result_error[]["message"]  = "user with attendee_id = ".$dataevent['attendee_id']." is  already joined/invited in this event";
					
				}
				
				$count = $this->event->checkifuserblockevent($dataevent['eventid'],$dataevent['attendee_id']);
				if($count > 0 )
				{	
					$error++;
					$result_error[]["message"] = "user with attendee_id = ".$dataevent['attendee_id']." is blocked this event  you cannot send invitation";
					
				}
				
				if($error == 0)
				{
					$result = $this->event->sendinvite($dataevent);
					if($result > 0)
					{  
						$result_success[]["message"] = "attendee_id = ".$dataevent['attendee_id']." is successfully invited in this event";
					}
					else 
					{
						$error++;
						
						$result_error[]["message"]  = "error inviting user with attendee_id = ".$dataevent['attendee_id']." ";
					}
				}
				
					
				$error = 0; // resert error  
				$datareturn['success'] =  $result_success;
				$datareturn['error'] =  $result_error;
				
			
		}
		
		$this->response(array('result' => $datareturn ));

		exit();
	
	
		$result = $this->event->sendinvite($dataevent);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        } 
		
	
	}
	*/
	

	
	function cancelinvitation_post()
	{
		
		$dataevent = array();
		$dataevent['eventid']  			= $this->post('eventid');
		$dataevent['invite_by']			= $this->post('invite_by');
		$dataevent['attendee_id']			= $this->post('attendee_id');
		$dataevent['status'] 			= 2; // cancel
		$dataevent['canceldate'] 		= gmdate("Y-m-d h:i:s");
		
		$this->form_validation
		->set_rules('invite_by', 'invite_by', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_rules('attendee_id', 'attendee_id', 'required')
		
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'invite_by' => form_error('invite_by'),
                'attendee_id' => form_error('attendee_id'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['invite_by']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid invite_by for user fbid or  there's no existing user fbid on database "));
			exit();
        	}
        	
        	$attendee_id= $this->user->checkifuserxistin_userdb($dataevent['attendee_id']);
		if($attendee_id== 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid attendee_id for user fbid or  there's no existing user fbid on database "));
			exit();
        	}
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
       	 	}
		
		$attendtable = $this->event->checkifuserinvitetootheruser($dataevent['eventid'],$dataevent['invite_by'],$dataevent['attendee_id']);
		if($attendtable == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "there is no record of invitation"));
			exit();
       	}
		
		$condition =  array('eventid' => $this->post('eventid'),'attendee_id' => $this->post('attendee_id'),'invite_by' => $this->post('invite_by'));
		
		$result = $this->event->cancelinvitation($dataevent,$condition);
		
	
	        if($result > 0 )
			{
	           
				$this->response(array('status' => 'success'));
	        }
			else 
			{
	             $this->response(array('status' => 'failed'));
	        }
			
		
		
	}
	
	
	function acceptinvitation_post()
	{
		
		$dataevent = array();
		
		$dataevent['eventid']  			= $this->post('eventid');
		$dataevent['invitecode']		= $this->post('invitecode');
		$dataevent['attendee_id']				= $this->post('attendee_id');
		$dataevent['status'] 			= 1; // active
		$dataevent['acceptdate'] 		= gmdate("Y-m-d h:i:s");
		
		$this->form_validation
		->set_rules('attendee_id', 'attendee_id', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_rules('invitecode', 'invitecode', 'required')
		->set_error_delimiters('', '');
		

		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
				'invitecode' => form_error('invitecode'),
                'attendee_id' => form_error('attendee_id')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$invitecodevalid = $this->event->checkifvalidinvitationcode($dataevent['invitecode'],$dataevent['eventid'] );
		if($invitecodevalid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid invite code or  there's no existing invitecode on database "));
			exit();
        }
		
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['attendee_id']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		$attendtable = $this->event->checkifyouareinattendeetable($dataevent['eventid'],$dataevent['attendee_id']);
		if($attendtable == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "user are not in attendee table or not yet invited to this event"));
			exit();
        }
		
		
		$condition =  array('invitecode' => $this->post('invitecode'),'eventid' => $this->post('eventid'),'attendee_id' => $this->post('attendee_id'));
		
		$result = $this->event->acceptinvitation($dataevent,$condition);
		
	
        if($result > 0 )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
		
		
	}
	
	function leave_event_post()
	{
		
		$dataevent = array();
		$dataevent['eventid']  			= $this->post('eventid');
		$dataevent['attendee_id']		= $this->post('attendee_id');
		$dataevent['status'] 			= 3; // leave
		$dataevent['leavedate'] 		= gmdate("Y-m-d h:i:s");
		
		$this->form_validation
		->set_rules('attendee_id', 'attendee_id', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'attendee_id' => form_error('attendee_id'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['attendee_id']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		$attendtable = $this->event->checkifyouareinattendeetable($dataevent['eventid'],$dataevent['attendee_id']);

		if($attendtable == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "user are not in attendee table or not yet invited in this event"));
			exit();
        }
	
		$attend = $this->event->checkifyouareattendthisevent($dataevent['eventid'],$dataevent['attendee_id']);
		if($attend == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "user are not yet attend in this event"));
			exit();
        }
		
		$condition =  array('eventid' => $this->post('eventid'),'attendee_id' => $this->post('attendee_id'));
		
		$result = $this->event->leave_event($dataevent,$condition);
		
	
        if($result > 0 )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
		
		
	}
	
	
	function addeventdiscussion_post()
	{
		
		$dataevent = array();
		$dataevent['eventid']  			= $this->post('eventid');
		$dataevent['user_fbid']			= $this->post('user_fbid');
		
		if(!empty($this->post('comment')))
		{
			$dataevent['comment'] 			= $this->post('comment');
		}
		$dataevent['comment_date'] 		= gmdate("Y-m-d h:i:s");
		
		
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'user_fbid' => form_error('user_fbid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		
		
		
		$result = $this->event->addeventdiscussion($dataevent);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	}
	
	function updateeventdiscussion_post()
	{
		
		$dataevent = array();
		
		$dataevent['discussion_id']  	= $this->post('discussion_id');
		$dataevent['eventid']  			= $this->post('eventid');
		$dataevent['user_fbid']			= $this->post('user_fbid');
		$dataevent['comment'] 			= $this->post('comment');
		$dataevent['update_date'] 		= gmdate("Y-m-d h:i:s");
		
		
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_rules('discussion_id', 'discussion_id', 'required')
		->set_error_delimiters('', '');
		
		
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'user_fbid' => form_error('user_fbid'),
				'discussion_id' => form_error('discussion_id'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		
		$condition = array(
							'eventid' => $this->post('eventid'),
							'user_fbid' => $this->post('user_fbid'),
							'discussion_id' => $this->post('discussion_id')
						   );
		
		
		$result = $this->event->updateeventdiscussion($dataevent,$condition);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	}
	
	function geteventdiscussion_get()
	{
		
	
		$user = $this->event->geteventdiscussion($this->get('eventid'),$this->get('user_fbid'));
			
			
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        } 
    }
	
	
	
	function like_discussion_post()
	{
		
		$dataevent = array();
		$dataevent['commentid']  	= $this->post('commentid');
		$dataevent['user_fbid']		= $this->post('user_fbid');
		$dataevent['like_status'] 		= 1;
		$dataevent['like_date'] 		= gmdate("Y-m-d h:i:s");
		
		
		$this->form_validation
		->set_rules('user_fbid', 'user fbid', 'required')
		->set_rules('commentid', 'commentid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'commentid' => form_error('commentid'),
                'user_fbid' => form_error('user_fbid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		$commentid = $this->event->checkifdiscussionexist($dataevent['commentid']);
		if($commentid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid commentid  or  there's no existing commentid on discussion table "));
			exit();
        }
		
		
		
		$result = $this->event->like_discussion($dataevent);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	}
	
	
	function unlike_discussion_post()
	{
		
		$dataevent = array();
		$dataevent['like_status'] 		= 0;
		$dataevent['unlike_date'] 		= gmdate("Y-m-d h:i:s");
		$dataevent['commentid']  	= $this->post('commentid');
		$dataevent['user_fbid']		= $this->post('user_fbid');
		
		$this->form_validation
		->set_rules('user_fbid', 'user fbid', 'required')
		->set_rules('commentid', 'commentid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'commentid' => form_error('commentid'),
                'user_fbid' => form_error('user_fbid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		$commentid = $this->event->checkifdiscussionexist($dataevent['commentid']);
		if($commentid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid commentid  or  there's no existing commentid on discussion table "));
			exit();
        }
		
		
		$condition = array(
							'commentid' => $this->post('commentid'),
							'user_fbid' => $this->post('user_fbid')
						   );
		
		$result = $this->event->unlike_discussion($dataevent,$condition);
		if($result > 0)
		{ 
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	
	}
	
	
	function discussionlikelist_get()
	{
		
	
		$user = $this->event->discussionlikelist($this->get('commentid'));
			
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
    }
	
	
	
	
	function replyeventdiscussion_post()
	{
		
		$dataevent = array();
		$dataevent['discussion_id']  	= $this->post('discussion_id');
		$dataevent['eventid']  			= $this->post('eventid');
		$dataevent['user_fbid']			= $this->post('user_fbid');
		$dataevent['reply_comment'] 	= $this->post('reply_comment');
		$dataevent['reply_date'] 		= gmdate("Y-m-d h:i:s");
		
		
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_rules('discussion_id', 'discussion_id', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'user_fbid' => form_error('user_fbid'),
				'discussion_id' => form_error('discussion_id')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		$discussion_id = $this->event->checkifdiscussionexist($dataevent['discussion_id']);
		if($discussion_id == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid discussion_id  or  there's no existing discussion_id on discussion table "));
			exit();
        }
		
		
		$result = $this->event->replyeventdiscussion($dataevent);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	}
	
	
	
	
	
	function update_replyeventdiscussion_post()
	{
		
		$dataevent = array();
		$dataevent['reply_id']  		= $this->post('reply_id');
		$dataevent['discussion_id']  	= $this->post('discussion_id');
		$dataevent['eventid']  			= $this->post('eventid');
		$dataevent['user_fbid']			= $this->post('user_fbid');
		$dataevent['reply_comment'] 	= $this->post('reply_comment');
		$dataevent['update_date'] 		= gmdate("Y-m-d h:i:s");
		
		
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_rules('discussion_id', 'discussion_id', 'required')
		->set_rules('reply_id', 'reply_id', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'user_fbid' => form_error('user_fbid'),
				'discussion_id' => form_error('discussion_id'),
				'reply_id' => form_error('reply_id'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['user_fbid']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		$discussion_id = $this->event->checkifdiscussionexist($dataevent['discussion_id']);
		if($discussion_id == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid discussion_id  or  there's no existing discussion_id on discussion table "));
			exit();
        }
		
		
		
		$condition = array(
							'eventid' => $this->post('eventid'),
							'user_fbid' => $this->post('user_fbid'),
							'discussion_id' => $this->post('discussion_id'),
							'reply_id' => $this->post('reply_id')
						   );
		
		
		$result = $this->event->update_replyeventdiscussion($dataevent,$condition);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	}
	
	
	function replydiscussionlist_get()
	{
		
	
		$user = $this->event->replydiscussionlist($this->get('eventid'),$this->get('discussion_id'));
			
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
    }
	
	
	
	function sendinviteby_email_post()
	{
		
		
		$dataevent = array();
		$dataevent['eventid']  			= $this->post('eventid');
		$dataevent['user_email']		= $this->post('user_email');
		$dataevent['invited_by']		= $this->post('invited_by');
		$dataevent['invitecode']		= $this->generateRandomString(10);
		
		
		
		if(!empty($this->post('note'))){
			$dataevent['note']	= $this->post('note');
		}
		$this->form_validation
		->set_rules('user_email', 'user_email', 'required')
		->set_rules('invited_by', 'invited_by', 'required')
		->set_rules('eventid', 'eventid', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'eventid' => form_error('eventid'),
                'user_email' => form_error('user_email'),
				'invited_by' => form_error('invited_by')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		
		if (!filter_var($dataevent['user_email'], FILTER_VALIDATE_EMAIL)) {
			$this->response(array('status' => 'failed', 'result' => "invalid email address"));
			exit();
		}
		
		$invited_by = $this->user->checkifuserxistin_userdb($dataevent['invited_by']);
		if($invited_by == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid invited_by for user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
		$eventexist = $this->event->checkifeventExist($dataevent['eventid']);
		if($eventexist == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid eventid or there's no existing event on database"));
			exit();
        }
		
		
		
		
		$result = $this->event->sendinviteby_email($dataevent);
		
		if($result == true )
		{
           
			$this->response(array('status' => 'success' , 'result' => 'email sent'));
        }
		else 
		{
             $this->response(array('status' => 'failed','reseult'=>'error upon sending email'));
        }
		
		
		
	}
	
	function enterEventcode_post()
	{
		$dataevent = array();
		$dataevent['attendee_id']		= $this->post('attendee_id');
		$dataevent['invitecode']  		= $this->post('invitecode');
		$dataevent['status'] 			= 1; // accept
		$dataevent['acceptdate'] 		= gmdate("Y-m-d h:i:s");
		
		$this->form_validation
		->set_rules('attendee_id', 'attendee_id', 'required')
		->set_rules('invitecode', 'invitecode', 'required')
		->set_error_delimiters('', '');
		  
		if($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'attendee_id' => form_error('attendee_id'),
				 'invitecode' => form_error('invitecode'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		
		
		
		$userfbid = $this->user->checkifuserxistin_userdb($dataevent['attendee_id']);
		if($userfbid == 0 )
		{
           
			$this->response(array('status' => 'failed', 'result' => "invalid user_fbid or  there's no existing user fbid on database "));
			exit();
        }
		
		
	
		
		$count = $this->event->checkifcodeExist($dataevent['invitecode']);
		if($count ==  0 )
		{
           
			$this->response(array('status' => 'failed','result'=>'invalid event invitecode'));
			exit();
        }
		
		$newData = $this->event->getDetailforsentemail($dataevent['invitecode']);
		
	
		
		$dataevent['eventid'] = $newData->eventid;	
		$dataevent['invite_by'] = $newData->user_fbid;
		$dataevent['invitedate'] = $newData->sentdate;	
		
	
		
		$count = $this->event->checkifuseralreadyjoined($dataevent['eventid'],$dataevent['attendee_id']);
		if($count > 0 )
		{
           
			$this->response(array('status' => 'failed','result'=>'user already joined in this event'));
			exit();
        }
		
		$count = $this->event->checkifuserblockevent($dataevent['eventid'],$dataevent['attendee_id']);
		if($count > 0 )
		{
           
			$this->response(array('status' => 'failed','result'=>'user blocked this event'));
			exit();
        }
		
		$result = $this->event->sendinvite($dataevent);
		if($result > 0)
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
		
	}
	
	
	

	
	
	

}


