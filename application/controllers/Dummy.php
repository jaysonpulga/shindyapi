<?php
	class Dummy extends CI_Controller
	{
		public function __construct(){
			parent ::__construct();
		}

		public function index(){
			echo "this is a dummy controller";
		}
	}
?>