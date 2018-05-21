<?php



defined('BASEPATH') OR exit('No direct script access allowed');







/**

 * Description of RestPostController

 *

 * @author https://roytuts.com

 */

class Imageapicontroller extends CI_Controller {

private $tbl_eventdetails_image 	= 'tbl_eventdetails_image';
 private $tbl_message 	= 'tbl_message';

    function __construct() {

        parent::__construct();

        $this->load->model('RESTevent_model', 'event');

		$this->load->model('RESTUsers_model', 'user');

		$this->load->library('form_validation');

		$this->load->helper('url');
		
		$this->load->helper('file');
		
		
		
		
	
    }
	
	

	function getimage($imageval)
	{
		
	
		
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
	
	public function getfilemessage($fileval)
	{

			$this->db->select("message");

			$this->db->from($this->tbl_message);

			$this->db->where('file_code',$fileval);		

			$query = $this->db->get();

			$str3 = $query->row();

		

			if(count($str3) > 0){

			/* echo $str3->image;

			exit(); */ 
			//$datafilename = gzencode(base64_decode($str3->message));
			$datafilename = base64_decode($str3->message);

			$f = finfo_open();
			$mime_type = finfo_buffer($f, $datafilename, FILEINFO_MIME_TYPE);
			
		
			$datafilename = gzencode(base64_decode($str3->message));
			

			header('Pragma: public');

			header('Cache-control: max-age=0');
			
			header("Content-type: $mime_type");
			
			//header("Content-type: application/pdf");
			
			header("Content-Encoding: gzip");

			header("Vary: Accept-Encoding");

			
			echo $datafilename;
				

			}

			else

			{

				  echo json_encode(array('status' => 'failed','result'=>'file not found on the database please check your file url'));

			}

		

		

	}
	
	
	public function userphoto()
	{
		$image_path = 'http://shindygo.com/rest_webservices/application/assets/user/person_placeholder.jpg';

		$this->output->set_content_type(get_mime_by_extension($image_path));
		$this->output->set_output(file_get_contents($image_path));
	}

	
}