<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Createuser extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		
		$this->load->helper('form');
		
		 /*Load the URL helper*/ 
         $this->load->helper('url'); 
		 
		  /*Load the cookie */
		 $this->load->helper('cookie'); 
		 
	}
	
	
	public function createuser()
	{
		
		$this->load->view("create_user");
	}
	
	public function create_event()
	{
		$this->load->view("create_event");	
		
	}


}