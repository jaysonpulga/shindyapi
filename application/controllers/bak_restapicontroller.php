<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');

/**
 * Description of RestPostController
 *
 * @author https://roytuts.com
 */
class restapicontroller extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('RESTUsers_model', 'cm');
    }

    function create_user_post(){
		
		
		$data = array();
		
		$data['fullname'] 		= $this->post('fullname');
		$data['photo'] 			= $this->post('photo');
		$data['email_address']  = $this->post('email_address');
		$data['about']			= $this->post('about');
		$data['age'] 			= $this->post('age');
		$data['age_pref'] 		= $this->post('age_pref');
		$data['religion'] 		= $this->post('religion');
		$data['gender_pref'] 	= $this->post('gender_pref');
		$data['address'] 		= $this->post('address');
		$data['distance'] 		= $this->post('distance');
		$data['zipcode'] 		= $this->post('zipcode');
		$data['availability'] 	= $this->post('availability');
				
        $result = $this->cm->add_user($data);
	
        if($result > 0 )
		{
           
			$this->response(array('status' => 'success'));
        }
		else 
		{
             $this->response(array('status' => 'failed'));
        }
    }
	
	
	
	function update_user_put()
	{
		
		$data = array();
		
		$condition =  array('id' => $this->put('id'));
		
		$data['fullname'] 		= $this->put('fullname');
		$data['photo'] 			= $this->put('photo');
		$data['email_address']  = $this->put('email_address');
		$data['about']			= $this->put('about');
		$data['age'] 			= $this->put('age');
		$data['age_pref'] 		= $this->put('age_pref');
		$data['religion'] 		= $this->put('religion');
		$data['gender_pref'] 	= $this->put('gender_pref');
		$data['address'] 		= $this->put('address');
		$data['distance'] 		= $this->put('distance');
		$data['zipcode'] 		= $this->put('zipcode');
		$data['availability'] 	= $this->put('availability');
	
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
		
		if (!$this->get('id'))
		{
             $user = $this->cm->get_user_list($id='');
        }
		else
		{
			  $user = $this->cm->get_user_list($this->get('id'));
		}
	
		
        if (count($user)> 0) {
            $this->response($user, 200);
        } else {
			$this->response(array('status' => 'false','message' => 'no record found'));
        }
    }
	
	function test_get()

 

}


