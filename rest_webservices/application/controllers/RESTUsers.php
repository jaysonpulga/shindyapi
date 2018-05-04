<?php
require(APPPATH . 'libraries/REST_Controller.php');
	class RESTUsers extends REST_Controller
	{
		public function __construct(){
			parent ::__construct();
			$this->load->model('RESTUsers_model','trymod');
			
			$this->load->helper('form');
			
			 /*Load the URL helper*/ 
			 $this->load->helper('url'); 
			 
			  /*Load the cookie */
			 $this->load->helper('cookie');
		 
		}
		

		
		public function index_post()
		{
			$data= $this->post();

			if(isset($data['id'])&&($data['intent']==='login'))
			{
				
				$trial = array();
				$trial =$this->trymod->user_login($data);
				echo $trial;
			}
			if(isset($data['email'])&&($data['intent']==='logout'))
			{
				
				$trial = array();
				$trial =$this->trymod->user_logout($data);
				echo $trial;
			}
			if(isset($data)&&($data['intent']==='eventreact'))
			{
				$trial = array();
				$trial =$this->trymod->event_react($data);
				echo $trial;
			}

			if(isset($data)&&($data['intent']==='cancelreact'))
			{
				$trial = array();
				$trial =$this->trymod->event_cancelreact($data);
				echo $trial;
			}
			if(isset($data['sender_email'])&&isset($data['receiver_email'])&&($data['intent']==='cancelinvite'))
			{
				
				$trial = array();
				$trial =$this->trymod->event_cancelinvite($data);
				echo $trial;
			}
			if(isset($data['email'])&&($data['intent']==='premiumacct'))
			{
				
				$trial = array();
				$trial =$this->trymod->user_topremium($data);
				echo $trial;
			}
			if(isset($data['email'])&&($data['intent']==='editaccount'))
			{
				
				$trial = array();
				$trial =$this->trymod->edit_account($data);
				echo $trial;
			}
			if(isset($data)&&($data['intent']==='signup'))
			{
				$trial = array();
				$trial =$this->trymod->user_register($data);
				echo $trial;
				$yea = json_decode($trial);
				if($yea->status==='success')
				{
					$dirname = "application/assets/images/".$data['email'];
					mkdir($dirname,0777, TRUE);
				}
				echo realpath("/WebServices/");
			}
			if(isset($data['host'])&&($data['intent']==='hostedevents'))
			{
				$trial = array();
				$trial =$this->trymod->hosted_events($data);
				echo $trial;
			}
			if(isset($data['email'])&&($data['intent']==='searchfriends'))
			{
				$trial = array();
				$trial =$this->trymod->friend_display($data);
				echo $trial;
			}
			if(isset($data['email'])&&($data['intent']==='searchevents'))
			{
				$trial = array();
				$trial =$this->trymod->events_display($data);
				echo $trial;
			}
			if(isset($data['email'])&&($data['intent']==='friendchoose'))
			{
				$trial = array();
				$trial =$this->trymod->friend_click($data);
				echo $trial;
			}
			if(isset($data['event_ID'])&&isset($data['email'])&&($data['intent']==='eventchoose'))
			{
				$trial = array();
				$trial =$this->trymod->event_click($data);
				echo $trial;
			}
			if($data['intent']==='eventhost')
			{
				$trial = array();
				$trial =$this->trymod->event_host($data);
				echo $trial;
			}
			if(isset($data['email'])&&($data['intent']==='usersblocked'))
			{
				$trial = array();
				$trial =$this->trymod->users_blocked($data);
				echo $trial;
			}
			if(isset($data['event_ID'])&&($data['intent']==='eventinvitations'))
			{
				$trial = array();
				$trial =$this->trymod->event_invited($data);
				echo $trial;
			}
			if(isset($data)&&($data['intent']==='eventcomment'))
			{
				$trial = array();
				$trial =$this->trymod->event_comment($data);
				echo $trial;
			}
			if(isset($data)&&($data['intent']==='userinvite'))
			{
				$trial = array();
				$trial =$this->trymod->user_invite($data);
				echo $trial;
			}
			if($data['intent']==='addfriend')
			{
				$trial = array();
				$trial =$this->trymod->friend_request($data);
				echo $trial;
			}
			if($data['intent']==='acceptfriend')
			{
				$trial = array();
				$trial =$this->trymod->accept_request($data);
				echo $trial;
			}
			if($data['intent']==='viewpeople')
			{
				$trial = array();
				$trial =$this->trymod->user_view($data);
				echo $trial;
			}
			if(isset($data['user_email'])&&$data['intent']==='allchat')
			{
				$trial = array();
				$trial =$this->trymod->all_recent_messages($data);
				echo $trial;
			}
			if(isset($data['sender_email'])&&isset($data['recipient_email'])&&($data['intent']==='chat'))
			{
				$trial = array();
				$trial =$this->trymod->send_message($data);
				echo $trial;
			}
			if(isset($data['thread_ID'])&&isset($data['user_email'])&&($data['intent']==='viewchat'))
			{
				$trial = array();
				$trial =$this->trymod->message_thread($data);
				echo $trial;
			}
			if(isset($data['user_email'])&&isset($data['friend_email'])&&($data['intent']==='acceptinvite'))
			{
				$trial = array();
				$trial =$this->trymod->event_accept_invite($data);
				echo $trial;
			}
		
			

			if($data['intent']==='admincreateevent')
			{
				$trial = array();
				$trial =$this->trymod->admin_create_event($data);
				echo $trial;
			}
			if($data['intent']==='admingetevents')
			{
				$trial = array();
				$trial =$this->trymod->admin_get_events($data);
				echo $trial;
			}
			if($data['intent']==='getevents')
			{
				$trial = array();
				$trial =$this->trymod->get_shareable_events($data);
				echo $trial;
			}
			if($data['intent']==='admingetusers')
			{
				$trial = array();
				$trial =$this->trymod->admin_get_users($data);
				echo $trial;
			}
			if($data['intent']==='admingetfriendship')
			{
				$trial = array();
				$trial =$this->trymod->admin_get_friendship($data);
				echo $trial;
			}
			if($data['intent']==='adminremoveeventoninvites')
			{
				$trial = array();
				$trial =$this->trymod->admin_remove_event_invites($data);
				echo $trial;
			}
			if($data['intent']==='adminremoveallevents')
			{
				$trial = array();
				$trial =$this->trymod->admin_remove_all_events($data);
				echo $trial;
			}
			if($data['intent']==='adminremoveallimages')
			{
				$trial = array();
				$trial =$this->trymod->admin_remove_all_images($data);
				echo $trial;
			}
			if($data['intent']==='adminremoveevent')
			{
				$trial = array();
				$trial =$this->trymod->admin_remove_event($data);
				echo $trial;
			}
			if($data['intent']==='adminremoveuser')
			{
				$trial = array();
				$trial =$this->trymod->admin_remove_user($data);
				echo $trial;
			}

			

			if($data['intent']==='shindyhost')
			{
				$trial = array();
				$trial =$this->trymod->shindy_event_host($data);
				echo $trial;
			}

		if(isset($data)&&($data['intent']==='shindyinvite'))
			{
				$trial = array();
				$trial =$this->trymod->shindy_invite($data);
				echo $trial;
			}
			if($data['intent']==='uploadimage')
			{
				$trial = array();
				$trial =$this->trymod->upload_image($data);
				echo $trial;
			}
			if($data['intent']==='findmutual')
			{
				$trial = array();
				$trial =$this->trymod->find_mutual($data);
				echo $trial;
			}
			if($data['intent']==='newusers')
			{
				$trial = array();
				$trial =$this->trymod->new_users($data);
				echo $trial;
			}
			if(isset($data['user_email'])&&isset($data['friend_email'])&&($data['intent']==='messagefriend'))
			{
				$trial = array();
				$trial =$this->trymod->message_friend($data);
				echo $trial;
			}
			if(isset($data['pick'])&&isset($data['user_email'])&&isset($data['friend_email'])&&($data['intent']==='newuserpick'))
			{
				$trial = array();
				$trial =$this->trymod->new_user_view($data);
				echo $trial;
			}
			if(isset($data['user_email'])&&isset($data['friend_email'])&&isset($data['notification_invitation'])&&($data['intent']==='changeblockstat'))
			{
				$trial = array();
				$trial =$this->trymod->friend_change_blockstat($data);
				echo $trial;
			}
			if(isset($data['email'])&&($data['intent']==='likedevents'))
			{
				$trial = array();
				$trial =$this->trymod->events_liked($data);
				echo $trial;
			}
			if($data['intent']==='availdelete')
			{
				$trial = array();
				$trial =$this->trymod->delete_availability($data);
				echo $trial;
			}
			if(isset($data['email'])&&($data['intent']==='availcreate'))
			{
				$trial = array();
				$trial =$this->trymod->create_availability($data);
				echo $trial;
			}
			if($data['intent']==='availview')
			{
				$trial = array();
				$trial =$this->trymod->view_availability($data);
				echo $trial;
			}
			if(isset($data['chat_ID'])&&($data['intent']==='read'))
			{
				$trial = array();
				$trial =$this->trymod->view_message($data);
				echo $trial;
			}
			if(isset($data['email'])&&($data['intent']==='blockedevents'))
			{
				$trial = array();
				$trial =$this->trymod->events_blocked($data);
				echo $trial;
			}
			if($data['intent']==='deleteevents')
			{
				$trial = array();
				$trial =$this->trymod->delete_event($data);
				echo $trial;
			}
			if(isset($data['email'])&&($data['intent']==='unratedevents'))
			{
				$trial = array();
				$trial =$this->trymod->events_unrated($data);
				echo $trial;
			}
			if(isset($data['sender_email'])&&isset($data['event_ID'])&&isset($data['comment'])&&$data['intent']==='comment')
			{
				$trial = array();
				$trial =$this->trymod->event_comment($data);
				echo $trial;
			}

		if(isset($data['sender_email'])&&isset($data['event_ID'])&&isset($data['rating'])&&$data['intent']==='rate')
			{
				$trial = array();
				$trial =$this->trymod->event_rate($data);
				echo $trial;
			}
		}
	}
?>