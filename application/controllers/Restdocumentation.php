<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Restdocumentation extends CI_Controller {



	public function __construct()

	{

		parent::__construct();

		

		

		$this->load->helper('form');

		

		 /*Load the URL helper*/ 

         $this->load->helper('url'); 

		 

		  /*Load the cookie */

		 $this->load->helper('cookie'); 

		 

	}

	

	

	public function restapi_documentation()

	{

		

		$this->load->view("documentation");

		

	}		

	

	public function eventdocumentation()	{				

	$this->load->view("event_documentation");			

	}

	

	public function groupdocumentation()	{				

	$this->load->view("group_documentation");			

	}

	

	

	public function messagedocumentation()	{				

	$this->load->view("message_documentation");			

	}

	public function problems(){
        $this->load->view('issues');
    }

    public function save_ip(){
    	var_dump($_POST);
    	$lat = $_POST['lat'];
    	$long = $_POST['long'];
    	$coun = $_POST['country'];
    	$ip = $this->getRealIpAddr();
    	$this->db->query('INSERT INTO rot (ip, longt, latt, country) VALUES ("'.$ip.'","'.$long.'","'.$lat.'","'.$coun.'")');
    	mail('4803839217@vtext.com','', 'hi sir, kevin here. someone access the tracker on this country:'.$coun);
    }

    function getRealIpAddr(){
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
	      $ip=$_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}


}