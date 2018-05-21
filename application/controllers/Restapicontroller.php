<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');

/**
 * Description of RestPostController
 *
 * @author https://roytuts.com
 */
class Restapicontroller extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('RESTUsers_model', 'cm');
		$this->load->library('form_validation');
    }
	
	function clean($string) {
	   $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.

	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}

    function check_user_post(){
		
		
		$data = array();
		$data['fbid'] 			= $this->clean($this->post('fbid'));
		
		/*
		$data['fullname'] 		= $this->post('fullname');
		$data['photo'] 			= $this->post('photo');
		if(!empty($this->post('photo')))
		{
			$data['photo'] 			= $this->post('photo');
		}
		$data['email_address']  = $this->post('email_address');
		$data['about']			= $this->post('about');
		$data['age'] 			= $this->post('age');
		$data['age_pref'] 		= $this->post('age_pref');
		$data['religion'] 		= ($this->post('religion') > 4 ? 0 : $this->post('religion') );
		$data['gender'] 		= $this->post('gender');
		$data['gender_pref'] 	= ($this->post('gender_pref') > 2 ? 0 : $this->post('gender_pref') );
		$data['address'] 		= $this->post('address');
		$data['distance'] 		= ($this->post('distance') > 9 ? 3 : $this->post('distance') );
		$data['zipcode'] 		= $this->post('zipcode');
		$data['availability'] 	= $this->post('availability');				
		$data['allow_anonymous_invite'] 	= $this->post('allow_anonymous_invite');
		*/
		if(!empty($this->post('fullname')))
		{
			$data['fullname'] 		= $this->post('fullname');
		}
		
		if(!empty($this->post('photo')))
		{
			$data['photo'] 			= $this->post('photo');
		}
		
		if(!empty($this->post('email_address')))
		{
			$data['email_address']  = $this->post('email_address');
		}
		
		if(!empty($this->post('about')))
		{
			$data['about']  = $this->post('about');
		}
		
		
		if(!empty($this->post('age')))
		{
			$data['age']  = $this->post('age');
		}
		
		
		if(!empty($this->post('age_pref')))
		{
			$data['age_pref']  = $this->post('age_pref');
		}
		
		
		if(!empty($this->post('religion')))
		{
			$data['religion'] 		= ($this->post('religion') > 4 ? 0 : $this->post('religion') );
		}
		
		
		if(!empty($this->post('gender')))
		{
			$data['gender'] 		= $this->post('gender');
		}
		
		
		
		if(!empty($this->post('gender_pref')))
		{
			$data['gender_pref'] 	= ($this->post('gender_pref') > 2 ? 0 : $this->post('gender_pref') );
		}
		
		
		if(!empty($this->post('address')))
		{
			$data['address'] 		= $this->post('address');
		}
		
		
		if(!empty($this->post('distance')))
		{
			$data['distance'] 		= ($this->post('distance') > 9 ? 3 : $this->post('distance') );
		}
		
		
		if(!empty($this->post('zipcode')))
		{
			$data['zipcode'] 		= $this->post('zipcode');
		}
		if(!empty($this->post('allow_anonymous_invite'))) 
		{			
			$data['allow_anonymous_invite'] 	= $this->post('allow_anonymous_invite');		
		}		
						
		if(!empty($this->post('availability')))
		{
			$data['availability'] 	= $this->post('availability');
		}

		
		$data['joineddate'] 	= gmdate("Y-m-d h:i:s");
		$data['updatedate'] 	= gmdate("Y-m-d h:i:s");
		
		$this->form_validation
		  ->set_rules('fbid', 'facebook id', 'required')
		  ->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE){
			
			$error_data[] = array(
				'fbid' => form_error('fbid')
         );
		 
			
			$this->response(array("status" => False,'error' =>$error_data));
			exit();
			
		}
		
		
		
		$count = $this->cm->checkifuserexist($data['fbid']);
		if($count > 0 )
		{
           
			$this->response(array('status' => 'success','authentication'=>'ok'));
			exit();
        }
		
		
		
				
        $result = $this->cm->check_user($data);
	
        if($result > 0 )
		{
           
			$this->response(array('status' => 'success','authentication'=>'ok'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
		
    }
	
	
	
	function update_user_post()
	{
		
		$data = array();
		
		$condition =  array('fbid' => $this->post('fbid'));
		
		if(!empty($this->post('fullname')))
		{
			$data['fullname'] 		= $this->post('fullname');
		}
		
		if(!empty($this->post('photo')))
		{
			$data['photo'] 			= $this->post('photo');
		}
		
		if(!empty($this->post('email_address')))
		{
			$data['email_address']  = $this->post('email_address');
		}
		
		if(!empty($this->post('about')))
		{
			$data['about']  = $this->post('about');
		}
		
		
		if(!empty($this->post('age')))
		{
			$data['age']  = $this->post('age');
		}
		
		
		if(!empty($this->post('age_pref')))
		{
			$data['age_pref']  = $this->post('age_pref');
		}
		
		
		if(!empty($this->post('religion')))
		{
			$data['religion'] 		= ($this->post('religion') > 4 ? 0 : $this->post('religion') );
		}
		
		
		if(!empty($this->post('gender')))
		{
			$data['gender'] 		= $this->post('gender');
		}
		
		
		
		if(!empty($this->post('gender_pref')))
		{
			$data['gender_pref'] 	= ($this->post('gender_pref') > 2 ? 0 : $this->post('gender_pref') );
		}
		
		
		if(!empty($this->post('address')))
		{
			$data['address'] 		= $this->post('address');
		}
		
		
		if(!empty($this->post('distance')))
		{
			$data['distance'] 		= ($this->post('distance') > 9 ? 3 : $this->post('distance') );
		}
		
		
		if(!empty($this->post('zipcode')))
		{
			$data['zipcode'] 		= $this->post('zipcode');
		}
		if(!empty($this->post('allow_anonymous_invite'))) 
		{			
			$data['allow_anonymous_invite'] 	= $this->post('allow_anonymous_invite');		
		}		
						
		if(!empty($this->post('availability')))
		{
			$data['availability'] 	= $this->post('availability');
		}

		
		$data['updatedate'] 	= gmdate("Y-m-d h:i:s");
        
		
		  
		  $this->form_validation
		  ->set_rules('fbid', 'facebook id', 'required')
		  ->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE){
			
			$error_data[] = array(
				'fbid' => form_error('fbid')
         );
		
			$this->response(array("status" => False,'error' =>$error_data));
			exit();
			
		}
		
		
		if($this->post('fbid') == "")
		{
			$this->response(array("status" =>'failed', 'error' =>'fbid is required for this action'));
			exit();
			
		}
		
		
		
		
		$result = $this->cm->update_user($data,$condition);
		
	
        if($result > 0 )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
    }
	
	function userlist_get()
	{
		
		if (!$this->get('fbid'))
		{
             $user = $this->cm->get_user_list($fbid='');
        }
		else
		{
			  $user = $this->cm->get_user_list($this->get('fbid'));
		}
	
		
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
	
	function addfriendrequest_post()
	{
		
		$data = array();
		$data['user_fbid']  			= $this->post('user_fbid');
		$data['friend_fbid']   			= $this->post('friend_fbid');
		$data['request_date']  			= gmdate("Y-m-d h:i:s");
		$data['friendshipcode']  		= $this->generateRandomString(10);
		
		$this->form_validation
		->set_rules('user_fbid', 'user fbid', 'required')
		->set_rules('friend_fbid', 'friend fbid', 'required')
		->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
                'friend_fbid' => form_error('friend_fbid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		
		
		
		if($data['user_fbid']  == $data['friend_fbid'] )
		{
			$this->response(array("status" => False,'error' =>"you send friend request to your own account"));
			exit();	
		}
		
		
		$count = $this->cm->checkifalreadyfriend($data['user_fbid'],$data['friend_fbid']);
		$stat = array(0=>'pending friend request',1=>'Already friend');
		if(count($count) > 0 )
		{
           
			$this->response(array('status' => 'failed','result'=>$stat[$count[0]->relationship_status]));
			exit();
        }
		
	

		$result = $this->cm->addfriendrequest($data);
	
        if($result > 0 )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
	
	}
	
	
	function cancelfriendrequest_post()
	{
		
		$data = array();
		$data['user_cancel']  			= $this->post('user_fbid');
		$data['user_fbid']  			= $this->post('user_fbid');
		$data['cancel_date']  			= gmdate("Y-m-d h:i:s");
		$data['relationship_status']  	= 2;
		$data['friendshipcode']  		= $this->post('friendshipcode');
		
		$this->form_validation
		->set_rules('user_fbid', 'user fbid', 'required')
		->set_rules('friendshipcode', 'friendshipcode', 'required')
		->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'friendshipcode' => form_error('friendshipcode'),
                'user_fbid' => form_error('user_fbid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$result = $this->cm->cancelfriendrequest($data);
        if($result > 0 )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
		
	} 
	
	
	function declinedfriendrequest_post()
	{
		
		$data = array();
		$data['user_declined']  		= $this->post('friend_fbid');
		$data['friend_fbid']  			= $this->post('friend_fbid');
		$data['declined_date']  		= gmdate("Y-m-d h:i:s");
		$data['relationship_status']  	= 3;
		$data['friendshipcode']  		= $this->post('friendshipcode');
		
		$this->form_validation
		->set_rules('friend_fbid', 'friend fbid', 'required')
		->set_rules('friendshipcode', 'friendshipcode', 'required')
		->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'friendshipcode' => form_error('friendshipcode'),
                'friend_fbid' => form_error('friend_fbid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$result = $this->cm->declinedfriendrequest($data);
        if($result > 0 )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
		
	} 
	
	function approvedfriendrequest_post()
	{
		
		$data = array();
		$data['user_approved']  		= $this->post('friend_fbid');
		$data['friend_fbid']  			= $this->post('friend_fbid');
		$data['approved_date']  		= gmdate("Y-m-d h:i:s");
		$data['relationship_status']  	= 1;
		$data['friendshipcode']  		= $this->post('friendshipcode');
		
		$this->form_validation
		->set_rules('friend_fbid', 'friend fbid', 'required')
		->set_rules('friendshipcode', 'friendshipcode', 'required')
		->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'friendshipcode' => form_error('friendshipcode'),
                'friend_fbid' => form_error('friend_fbid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		$result = $this->cm->approvedfriendrequest($data);
        if($result > 0 )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
	} 
	
	
	
	function blokeduser_post()
	{
		
		$data = array();
		$data['user_fbid']  			= $this->post('user_fbid');
		$data['friend_fbid']   			= $this->post('friend_fbid');
		$data['blocked_date']  			= gmdate("Y-m-d h:i:s");
		$data['blocking_status']  		= 1;

		
		$this->form_validation
		->set_rules('user_fbid', 'use fbid', 'required')
		->set_rules('friend_fbid', 'friend fbid', 'required')
		->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'friend_fbid' => form_error('friend_fbid'),
                'user_fbid' => form_error('user_fbid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		
		if($data['user_fbid']  == $data['friend_fbid'] )
		{
			$this->response(array("status" => False,'error' =>"you cannot block your own account"));
			exit();	
		}
	

		$result = $this->cm->blokeduser($data);
	
        if($result > 0 )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
	
	}
	
	function unblocked_post()
	{
		
		$data = array();
		$data['user_fbid']  			= $this->post('user_fbid');
		$data['friend_fbid']   			= $this->post('friend_fbid');
		$data['unblocked_date']  		= gmdate("Y-m-d h:i:s");
		$data['blocking_status']  		= 0;

		
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_rules('friend_fbid', 'friend fbid', 'required')
		->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
				'friend_fbid' => form_error('friend_fbid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		
		if($data['user_fbid']  == $data['friend_fbid'] )
		{
			$this->response(array("status" => False,'error' =>"you cannot unblock your own account"));
			exit();	
		}
		
		$result = $this->cm->unblocked($data);
        if($result > 0 )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
		
	} 
	
	

	
	function addfavoriteuser_post()
	{
		
		$data = array();
		$data['user_fbid']  			= $this->post('user_fbid');
		$data['friend_fbid']   			= $this->post('friend_fbid');
		$data['favorite_date']  		= gmdate("Y-m-d h:i:s");
		$data['favorite_status']  		= 1;
		$data['favoritecode']  			= $this->generateRandomString(10);
		
		$this->form_validation
		->set_rules('user_fbid', 'user fbid', 'required')
		->set_rules('friend_fbid', 'friend fbid', 'required')
		->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'friend_fbid' => form_error('friend_fbid'),
                'user_fbid' => form_error('user_fbid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		if($data['user_fbid']  == $data['friend_fbid'] )
		{
			$this->response(array("status" => False,'error' =>"you set as favorite your own account"));
			exit();	
		}

		$result = $this->cm->addfavoriteuser($data);
	
        if($result > 0 )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
	
	}
	
	
	function unfavoriteuser_post()
	{
		
		$data = array();
		$data['user_fbid']  			= $this->post('user_fbid');
		$data['friend_fbid']   		= $this->post('friend_fbid');
		$data['unfavorite_date']  		= gmdate("Y-m-d h:i:s");
		$data['favorite_status']  		= 0;
		//$data['favoritecode']  			= $this->post('favoritecode');
		
		$this->form_validation
		->set_rules('user_fbid', 'user fbid', 'required')
		->set_rules('friend_fbid', 'friend fbid', 'required')
		
		->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
				'friend_fbid' => form_error('friend_fbid')
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}
		
		if($data['user_fbid']  == $data['friend_fbid'] )
		{
			$this->response(array("status" => False,'error' =>"you set as unfavorite your own account"));
			exit();	
		}
		
		$result = $this->cm->unfavoriteuser($data);
        if($result > 0 )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
		
		
	} 
	
	function userfavoritelist_post()
	{
	
	
		 $user_fbid  = $this->post('user_fbid');

		
		$this->form_validation
		->set_rules('user_fbid', 'user fbid', 'required')
		->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		} 
	
		
		$user = $this->cm->userfavoritelist($user_fbid);
		

        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
    }
	
	
	function userfriendlist_post()
	{
	
		 $user_fbid  = $this->post('user_fbid');

		
		$this->form_validation
		->set_rules('user_fbid', 'user_fbid', 'required')
		->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		} 
		
	
		
		$user = $this->cm->userfriendlist($user_fbid);
		
	
		
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
    }
	
	
	public function SearchAlluserinshindy_post()
	{
		 $user_fbid  = $this->post('user_fbid');
		 $fullname  = $this->post('fullname');
		 $filterby  = $this->post('filterby');
		 
		 $applied_filter = array();
		 $applied_filter['distance']  	= $this->post('distance');
		 $applied_filter['religion']   	= $this->post('religion');
		 $applied_filter['gender_pref'] = $this->post('gender_pref');
		 $applied_filter['min_age']  	= $this->post('min_age');
		 $applied_filter['max_age']  	= $this->post('max_age');
		
		
		$this->form_validation
		->set_rules('user_fbid', 'user fbid', 'required')
		->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		}  
		
		
       $result = $this->cm->SearchAlluserinshindy($user_fbid,$fullname,$filterby,$applied_filter);
	   
	   	if($result == false)
		{
			$this->response(array('status' => 'false','result' => 'zipcode of user must be valid, please provide the valid zipcode code'));
			exit();
		}
	   
		if (count($result)> 0) {
            $this->response($result, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
		
	}
	
	
	function userblockedlist_post()
	{
		
	
		//$user = $this->cm->userblockedlist($this->get('user_fbid'));
		 $applied_filter = array();
		 $user_fbid 				    = $this->post('user_fbid');
		 $fullname 						= $this->post('fullname');
		 
		 $this->form_validation
		->set_rules('user_fbid', 'user fbid', 'required')
		->set_error_delimiters('', '');
		  
		if ($this->form_validation->run() == FALSE)
		{
			$error_data[] = array(
                'user_fbid' => form_error('user_fbid'),
            );
			$this->response(array("status" => False,'error' =>$error_data));
			exit();	
		} 
		
		
		$user = $this->cm->userblockedlist($user_fbid,$fullname);
		
		
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','result' => 'no record found'));
        }
    }
	
	
	

	

}


