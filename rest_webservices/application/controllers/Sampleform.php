<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Sampleform extends CI_Controller {
	
	 private $tbl_eventdetails_image 	= 'tbl_eventdetails_image';	 private $tbl_message 	= 'tbl_message';

	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		
		$this->load->helper('form');
		
		 /*Load the URL helper*/ 
         $this->load->helper('url'); 
		 
		  /*Load the cookie */
		 $this->load->helper('cookie'); 
		 
	}
	
	
	public function Getimage()
	{
		
			$imageval =  $this->input->get('imageval');
		
			$this->db->select("image");
			$this->db->from($this->tbl_eventdetails_image);
			$this->db->where('image_code',$imageval);		
			$query = $this->db->get();
			$str3 = $query->row();
			
			
			if(count($str3) > 0){
			/* echo $str3->image;
			exit(); */ 
			header('Pragma: public');
			header('Cache-control: max-age=0');
			header('Content-Type: image');
			header("Content-Encoding: gzip");
			header("Vary: Accept-Encoding");
			
				echo gzencode(base64_decode($str3->image));
			}
			else
			{
				  echo json_encode(array('status' => 'failed','result'=>'image not found on the database please check your image url'));
			}
		
		
	}
		public function Getfilemessage()	{			$fileval =  $this->input->get('fileval');			$this->db->select("message");			$this->db->from($this->tbl_message);			$this->db->where('file_code',$fileval);					$query = $this->db->get();			$str3 = $query->row();									if(count($str3) > 0){			/* echo $str3->image;			exit(); */ 			header('Pragma: public');			header('Cache-control: max-age=0');			header('Content-Type: image');			header("Content-Encoding: gzip");			header("Vary: Accept-Encoding");							echo gzencode(base64_decode($str3->message));			}			else			{				  echo json_encode(array('status' => 'failed','result'=>'image not found on the database please check your image url'));			}					}
	
	public function blockevent()
	{
		
		$this->load->view("blockevent");
		
	}
	
	public function create_event()
	{
		$this->load->view("create_event");	
		
	}


}