<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class RESTUsers_model extends CI_Model{
		
		public function user_login($data){
			if(isset($data)){
				$temp['status']=0;
				$this->db->select('status');
				$this->db->from('users');
				$this->db->where('email',$data['email']);
				$this->db->where('status',$temp['status']);
				$query = $this->db->get();
				$query = $query->result_array();	
				$result=$query;
				print_r($result);
				if(!empty($result)){
					$data2=array('status'=>1);
					$this->db->where('email',$data['email']);
					$this->db->update('users',$data2);

					$response = json_encode(array('status'=>'success'));
					return $response;
				}
				else
				{
					$response = json_encode(array('status'=>'already logged out'));
					return $response;
				}
			}
			else{
				$response = json_encode(array('status'=>'failed'));
				return $response;
			}
					
					$this->db->select('*');
					$this->db->from('users');
					$this->db->where('email',$data['email']);
					$this->db->where('password',sha1($data['password']));	
				
					$query = $this->db->get();
					$response = json_encode(array('status'=>'success'));
					return $response;
				if(isset($data)){
				$temp['status']=1;
				$this->db->select('status');
				$this->db->from('users');
				$this->db->where('email',$data['email']);
				$this->db->where('status',$temp['status']);
				$query = $this->db->get();
				$query = $query->result_array();	
				$result=$query;
				if(!empty($result)){
					$data2=array('status'=>0);
					$this->db->where('email',$data['email']);
					$this->db->update('users',$data2);

					$response = json_encode(array('status'=>'success'));
					return $response;
				}
				else
				{
					$response = json_encode(array('status'=>'already logged out'));
					return $response;
				}
			}
			else{
				$response = json_encode(array('status'=>'failed'));
				return $response;
			}
		}
		public function user_logout($data){
			if(isset($data)){
				$temp['status']=1;
				$this->db->select('status');
				$this->db->from('users');
				$this->db->where('email',$data['email']);
				$this->db->where('status',$temp['status']);
				$query = $this->db->get();
				$query = $query->result_array();	
				$result=$query;
				if(!empty($result)){
					$data2=array('status'=>0);
					$this->db->where('email',$data['email']);
					$this->db->update('users',$data2);

					$response = json_encode(array('status'=>'success'));
					return $response;
				}
				else
				{
					$response = json_encode(array('status'=>'already logged out'));
					return $response;
				}
			}
			else{
				$response = json_encode(array('status'=>'failed'));
				return $response;
			}
		}
		public function user_register($data){
			if(isset($data))
			{
				$this->db->select('email');
				$this->db->from('users');
				$this->db->where('email',$data['email']);
				$query = $this->db->get();
				$em = $query->result();
				if(empty($em))
				{
					unset($data['intent']);
					$data['password']=sha1($data['password']);
					$this->db->insert('users',$data);
					$main = "success";
					$user = $data['email'];
					unset($data);
					$this->db->distinct();
					$this->db->select('event_ID');
					$this->db->from('invites');
					$this->db->where('sender_email','shindyadmin@yahoo.com');
					$query = $this->db->get();
					$se = $query->result();
					$shindyevents = array();
					foreach ($se as $search)
					{
						$shindyevents[] = $search->event_ID;
					}
					print_r($shindyevents);
					for($x=0;$x<=(count($shindyevents)-1);$x++)
					{
						$data['event_ID']=$shindyevents[$x];
						$data['receiver_email']=$user;
						$data['sender_email']='shindyadmin@yahoo.com';
						$this->db->insert('invites',$data);
					}
				}
				else
				{
					$main = "failed";
				}
				
				$response = json_encode(array('status'=>$main));
				return $response;
			}
			else
			{
				$response = json_encode(array('status'=>'missing credentials'));
				return $response;
			}
		}
		public function user_invite($data){
			if(isset($data))
			{
				$this->db->select('sender_email');
				$this->db->from('invites');
				$this->db->where('sender_email',$data['sender_email']);
				$this->db->where('receiver_email',$data['receiver_email']);
				$this->db->where('event_ID',$data['event_ID']);
				$query = $this->db->get();
				$em = $query->result();
				if(empty($em))
				{
					$data['status']='0';
					unset($data['intent']);
					$this->db->insert('invites',$data);
					$main = "success";
				}
				else
				{
					$main = "invitation already sent";
				}
				
				$response = json_encode(array('status'=>$main));
				return $response;
			}
			else
			{
				$response = json_encode(array('status'=>'missing credentials'));
				return $response;
			}
		}
		public function user_topremium($data){
			if(isset($data)){
				$temp['account_type']=0;
				$this->db->select('account_type');
				$this->db->from('users');
				$this->db->where('email',$data['email']);
				$this->db->where('account_type',$temp['account_type']);
				$query = $this->db->get();
				$query = $query->result_array();	
				$result=$query;
				if(!empty($result)){
					$data2=array('account_type'=>1);
					$this->db->where('email',$data['email']);
					$this->db->update('users',$data2);

					$response = json_encode(array('status'=>'success'));
					return $response;
				}
				else
				{
					$response = json_encode(array('status'=>'already in premium'));
					return $response;
				}
			}
			else{
				$response = json_encode(array('status'=>'failed'));
				return $response;
			}
		}
		public function edit_account($data){
			if(isset($data)){
				unset($data['intent']);
				$this->db->where('email',$data['email']);
				$this->db->update('users',$data);

				$response = json_encode(array('status'=>'success'));
				return $response;
			}
			else{
				$response = json_encode(array('status'=>'already in premium'));
				return $response;
			}
		}
		public function event_host($data){
			if(isset($data))
			{
				unset($data['intent']);
				$this->db->insert('events',$data);
				$main = "success";
				$response = json_encode(array('status'=>$main));
				return $response;
			}
			else
			{
				$response = json_encode(array('status'=>'missing credentials'));
				return $response;
			}
		}
		public function friend_display($data){
			$this->db->select('friend_email,friendship_status');
			$this->db->from('friendships');
			$this->db->where('user_email',$data['email']);
			$this->db->where('friendship_status','1');
			$query = $this->db->get();

			$resp1=array();
			foreach ($query->result() as $row){
				$resp1[] = $row;
			}

			$resp2 = array();
			foreach($resp1 as $search)
			{
				$resp2[] = $search->friend_email;
			}
			if(!empty($resp1))
			{
				$x=1;
				$this->db->select('email,image,first_name,last_name,ZIP_code,gender');
				$this->db->from('users');
				$this->db->where_in('email',$resp2);
				$query = $this->db->get();
				$resp = $query->result();
				$response = json_encode(array('friendship_status'=>$resp1,'friends'=>$resp));
				return $response;
			}
			else
			{
				$response = json_encode(array('friendship_status'=>'no friends'));
				return $response;
			}
		}
		public function events_hosted($data)
		{
			$this->db->select('');
			$this->db->from('invites');
			$this->db->where('receiver_email',$data['email']);
			$query = $this->db->get();
		}
		public function hosted_events($data)
		{
			$this->db->select('*');
			$this->db->from('events');
			$this->db->where('host',$data['host']);
			$query=$this->db->get();
			#foreach ($query as $key => $value) {
				# code...
			#}
			$response=json_encode(array('hostedEvents'=>$query->result()));
			return $response;
		}
		public function event_cancelreact($data){
			$this->db->where('email',$data['email']);
			$this->db->where('event_ID',$data['event_ID']);
			$this->db->delete('eventpreferences');
			$response = array('status'=>'success');
			return $response;
		}
		public function event_cancelinvite($data){
			$this->db->where('sender_email',$data['sender_email']);
			$this->db->where('receiver_email',$data['receiver_email']);
			$this->db->where('status','0');
			$this->db->delete('invites');
			$response = json_encode(array('status'=>'success'));
			return $response;
		}
		public function events_display($data){
			$this->db->select('event_ID,sender_email,status,treat');
			$this->db->from('invites');
			$this->db->where('receiver_email',$data['email']);
			$query = $this->db->get();

			foreach ($query->result() as $row){
				$resp1[] = $row;
			}
			
			$resp2 = array();

			foreach($resp1 as $search)
			{
				$resp2[] = $search->event_ID;
			}
			foreach($resp1 as $search)
			{
				$resp3[] = $search->sender_email;
			}
			$this->db->select('event_ID,host,event_image,event_name,time,date,guest_invitation,max_female,max_male,expiry');
			$this->db->from('events');
			$this->db->where_in('event_ID',$resp2);
			//$this->db->or_where('host','shindyadmin@yahoo.com');
			$query = $this->db->get();
			$event = $query->result();
			$this->db->select('*');
			$this->db->from('images');
			$this->db->where_in('event_ID',$resp2);
			$query = $this->db->get();
			$images = $query->result();
			$this->db->select('event_ID,block_status');
			$this->db->from('eventpreferences');
			$this->db->where('email',$data['email']);
			$query = $this->db->get();
			$like = $query->result();
			$this->db->select('email,first_name,last_name');
			$this->db->from('users');
			$this->db->where_in('email',$resp3);
			$query = $this->db->get();
			$names = $query->result();
			$response = json_encode(array('events'=>$event,'senders'=>$resp1,'sender_name'=>$names,'like'=>$like,'photos'=>$images));
			return $response;
		}
		public function event_click($data){
			$this->db->select('*');
			$this->db->from('events');
			$this->db->where('event_ID',$data['event_ID']);
			$query = $this->db->get();
			$event = $query->result();

			$this->db->select('block_status');
			$this->db->from('eventpreferences');
			$this->db->where('event_ID',$data['event_ID']);
			$query = $this->db->get();
			$like = $query->result();

			$this->db->select('event_ID,preview_image');
			$this->db->from('images');
			$this->db->where('event_ID',$data['event_ID']);
			$query = $this->db->get();
			$images = $query->result();
			
			$response = json_encode(array('picked_event'=>$event,'like'=>$like,'images'=>$images));
			return $response;
		}
		public function friend_click($data){
			$this->db->select('email,first_name,last_name,image,background,gender,ZIP_code,introduction,gender_prefs,display_gender_prefs,religion,religion_display');
			$this->db->from('users');
			$this->db->where('email',$data['email']);
			$query = $this->db->get();
			$friend = $query->result();	
			
			$response = json_encode(array('friend'=>$friend));
			return $response;
		}
		public function event_invited($data){
			$this->db->select('sender_email,receiver_email,event_ID,status,anonymous,treat');
			$this->db->from('invites');
			$this->db->where('event_ID',$data['event_ID']);
			$this->db->where('sender_email',$data['sender_email']);
			$query1=$this->db->get();
			$myinvitations = $query1->result();
			$this->db->select('sender_email,receiver_email,event_ID,status,anonymous,treat');
			$this->db->from('invites');
			$this->db->where('event_ID',$data['event_ID']);
			$this->db->where('sender_email !=',$data['sender_email']);
			$query2=$this->db->get();
			$others = $query2->result();
			$this->db->select('receiver_email');
			$this->db->from('invites');
			$this->db->where('event_ID',$data['event_ID']);
			$query4=$this->db->get();
			$names = $query4->result();
			$temp = array();
			foreach ($names as $search)
			{
				$temp[] = $search->receiver_email;
			}
			$this->db->select('email,first_name,last_name,image');
			$this->db->from('users');
			$this->db->where_in('email',$temp);
			$query3 = $this->db->get();
			$profiles= $query3->result();
			$response = json_encode(array('userinvites'=>$myinvitations,'otherinvites'=>$others,'profiles'=>$profiles));
			return $response;
		}
		public function friend_request($data)
		{
			if(isset($data['friend_email']))
			{
				unset($data['intent']);
				$this->db->insert('friendships',$data);
				$main = "request sent";
				$response = json_encode(array('status'=>$main));
				return $response;
			}
			else
			{
				$response = json_encode(array('status'=>'failed'));
				return $response;
			}
		}
		public function accept_request($data){
			if(isset($data)){
				$this->db->select_max('thread_ID');
				$this->db->from('friendships');
				$query = $this->db->get();
				$response = $query->result();
				$dummy=array();
				foreach ($response as $search)
				{
					$dummy[] = $search->thread_ID;	
				}
				$max = ((int)$dummy[0]) + 1;
				unset($data['intent']);
				$data['thread_ID']=$max;
				$data['friendship_status']='1';
				$this->db->where('friend_email',$data['user_email']);
				$this->db->where('user_email',$data['friend_email']);
				$this->db->update('friendships',$data);
				$temp = $data['friend_email'];
				$data['friend_email']=$data['user_email'];
				$data['user_email']=$temp;
				$this->db->insert('friendships',$data);
				$response = json_encode(array('status'=>'friend accepted'));
				return $response;
			}
			else{
				$response = json_encode(array('status'=>'failed to accept'));
				return $response;
			}
		}
		public function user_view($data)
		{
			$this->db->select('friend_email,friendship_status');
			$this->db->from('friendships');
			$this->db->where('user_email',$data['user_email']);
			$this->db->where('friendship_status','1');
			$query1=$this->db->get();
			$friends = $query1->result();
			$this->db->select('friend_email,friendship_status');
			$this->db->from('friendships');
			$this->db->where('user_email',$data['user_email']);
			$this->db->where('friendship_status','0');
			$query2=$this->db->get();
			$myadds = $query2->result();
			$this->db->select('user_email,friendship_status');
			$this->db->from('friendships');
			$this->db->where('friend_email',$data['user_email']);
			$this->db->where('friendship_status','0');
			$query3=$this->db->get();
			$myrequests = $query3->result();
			$frnd = array();
			foreach($friends as $search)
			{
				$frnd[] = $search->friend_email;
			}
			$adds = array();
			foreach($myadds as $search)
			{
				$adds[] = $search->friend_email;
			}
			$reqs = array();
			foreach($myrequests as $search)
			{
				$reqs[] = $search->user_email;
			}
			$this->db->select('email,first_name,last_name,image,gender,religion,ZIP_code,introduction,religion_display');
			$this->db->from('users');
			if($frnd!=null)
			{
			$this->db->where_in('email',$frnd);
		}
		else if($adds!=null)
		{
			$this->db->or_where_in('email',$adds);
		}
		else if($reqs)
		{
			$this->db->or_where_in('email',$reqs);
		}
			$query4 = $this->db->get();
			$conn_accounts = $query4->result();
			$this->db->select('email,first_name,last_name,image,gender,religion,ZIP_code,introduction,religion_display');
			$this->db->from('users');
		if($frnd!=null)
		{
			$this->db->where_not_in('email',$frnd);
		}
		else if($adds)
		{
			$this->db->where_not_in('email',$adds);
		}
		else if($reqs)
		{
			$this->db->where_not_in('email',$reqs);
		}
			$query5 = $this->db->get();
			$other_accounts = $query5->result();
			$response = json_encode(array('friends'=>$friends,'myadds'=>$myadds,'myrequests'=>$myrequests,'accounts'=>$conn_accounts,'other accounts'=>$other_accounts));
			return $response;
		}
		public function send_message($data)
		{	
			if(isset($data['message'])){
				$this->db->select('thread_ID');
				$this->db->from('friendships');
				$this->db->where('user_email',$data['sender_email']);
				$this->db->where('friend_email',$data['recipient_email']);
				$query = $this->db->get();
				$response=json_encode($query->result());
				$temp = $query->result();
				$dummy=array();
				foreach ($temp as $search)
				{
					$thread = $search->thread_ID;	
				};
				$data['message_date'] = gmdate("Y-m-d");
				$data['message_time'] = gmdate("H:i:s");
				$data['thread_ID'] = $thread;
				unset($data['intent']);
				$this->db->insert('messages',$data);
				$response = json_encode(array('status'=>'message sent'));
				return $response;
			}
			else{
				$response = json_encode(array('status'=>'message sending failed'));
				return $response;
			}
		}
		public function message_thread($data)
		{
			$this->db->select('*');
			$this->db->from('messages');
			$this->db->where('thread_ID',$data['thread_ID']);
			$query=$this->db->get();
			$chat_thread = $query->result();
			$response = json_encode(array('thread'=>$chat_thread));
			return $response;
		}
		public function all_recent_messages($data)
		{
			$this->db->distinct();
			$this->db->select('thread_ID');
			$this->db->from('messages');
			$this->db->where('sender_email',$data['user_email']);
			$this->db->or_where('recipient_email',$data['user_email']);
			$query= $this->db->get();
			$threads = $query->result();
			$temp1 = array();
			$temp2 = array();
			foreach ($threads as $search)
			{
				$temp1[] = $search->thread_ID;
			}
			$num = sizeof($temp1)-1;
			$x=0;
			while($x <= $num)
			{
				$this->db->select_max('chat_ID');
				$this->db->from('messages');
				$this->db->where('thread_ID',$temp1[$x]);
				$query=$this->db->get();
				$temp3 = $query->result();
				$temp4=array();
				foreach ($temp3 as $search2) {
					$temp4 = $search2->chat_ID;
				}
				$temp2[$x]=$temp4;
				$x++;
			}
			$this->db->select('sender_email,thread_ID,message,message_time,message_date');
			$this->db->from('messages');
			$this->db->where_in('chat_ID',$temp2);
			$query2=$this->db->get();
			$final = $query2->result();
			$threads = array();
			foreach($final as $search3)
			{
				$threads[] = $search3->thread_ID;
			}
			$this->db->distinct();
			$this->db->select('recipient_email,thread_ID');
			$this->db->from('messages');
			$this->db->where('sender_email',$data['user_email']);
			$this->db->where_in('chat_ID',$temp2);
			$query3 = $this->db->get();
			$mysends = $query3->result();
			$this->db->distinct();
			$this->db->select('sender_email,thread_ID');
			$this->db->from('messages');
			$this->db->where('recipient_email',$data['user_email']);
			$this->db->where_in('chat_ID',$temp2);
			$query4 = $this->db->get();
			$othersends = $query4->result();
			$temp5 = array();
			$temp6 = array();
			foreach ($mysends as $search4)
			{
				$temp5[] = $search4->recipient_email;
			}
			foreach ($othersends as $search5)
			{
				$temp6[] = $search5->sender_email;
			}
			$this->db->select('email,first_name,last_name,image');
			$this->db->from('users');
			if($temp6!=null)
			{
				$this->db->where_in('email',$temp6);
		}
		else
		{
			$this->db->where_in('email',$temp5);
		}
			//$this->db->or_where_in('email',$temp5);
			$query5=$this->db->get();
			$allchats = $query5->result();
			$response = json_encode(array('results'=>$final,'mysends'=>$mysends,'othersends'=>$othersends,'allchats'=>$allchats));
			return $response;
		}
		public function event_accept_invite($data){
			if(isset($data))
			{
				$this->db->select('gender');
				$this->db->from('users');
				$this->db->where('email',$data['user_email']);
				$query=$this->db->get();
				$gend = $query->result();
				$temp = array();
				$event_ID = $data['event_ID'];
				foreach ($gend as $search)
				{
					$temp[] = $search->gender;
				}
				$gender = $temp[0];
				$this->db->where('sender_email',$data['friend_email']);
				$this->db->where('receiver_email',$data['user_email']);
				$this->db->where('event_ID',$data['event_ID']);
				unset($data);
				$data['status']='2';
				$this->db->update('invites',$data);
				if($gender==='1')
				{
					unset($data);
					$this->db->select('max_male');
					$this->db->from('events');
					$this->db->where('event_ID',$event_ID);
					$query = $this->db->get();
					$mm = $query->result();
					$temp = array();
					foreach ($mm as $search)
					{
						$temp[] = $search->max_male;
					}
					$max = (int)$temp[0];
					$max = $max-1;
					$data['max_male']=$max;
					$this->db->where('event_ID',$event_ID);
					$this->db->update('events',$data);
				}
				else if($gender==='0')
				{
					unset($data);
					$this->db->select('max_female');
					$this->db->from('events');
					$this->db->where('event_ID',$event_ID);
					$query = $this->db->get();
					$mm = $query->result();
					$temp = array();
					foreach ($mm as $search)
					{
						$temp[] = $search->max_male;
					}
					$max = (int)$temp[0];
					$max = $max-1;
					$data['max_female']=$max;
					$this->db->where('event_ID',$event_ID);
					$this->db->update('events',$data);
				}
				$main = "success";
				$response = json_encode(array('status'=>$main));
				return $response;
			}
			else
			{
				$response = json_encode(array('status'=>'failed'));
				return $response;
			}
			
		}
	


		public function admin_create_event($data)
			{
					unset($data['intent']);
					$this->db->insert('events',$data);
					$response=json_encode(array('status'=>'success'));
					return $response;
				
			}
			public function admin_remove_event_invites($data)
			{
					unset($data['intent']);
					
					$this->db->from('invites');
					$this->db->where('event_ID',$data['event_ID']);
					$this->db->delete();
					$response=json_encode(array('status'=>'success'));
					return $response;
				
			}
			public function admin_remove_user($data)
			{
					unset($data['intent']);
					
					$this->db->from('users');
					$this->db->where('email',$data['email']);
					$this->db->delete();
					$response=json_encode(array('status'=>'success'));
					return $response;
				
			}
			public function admin_get_events($data)
			{
				if(isset($data['intent']))
				{
					$this->db->select('*');
					$this->db->from('events');
					$query=$this->db->get();
					$response = json_encode(array('events'=>$query->result()));
					return $response;
		 		}
			}
			public function admin_get_friendship($data)
			{
				if(isset($data['intent']))
				{
					$this->db->select('*');
					$this->db->from('friendships');
					$query=$this->db->get();
					$response = json_encode(array('friendship'=>$query->result()));
					return $response;
		 		}
			}
			public function admin_get_users($data)
			{
				if(isset($data['intent']))
				{
					$this->db->select('*');
					$this->db->from('users');
					$query=$this->db->get();
					$response = json_encode(array('users'=>$query->result()));
					return $response;
		 		}
			}
		


			public function shindy_event_host($data){
			if(isset($data))
			{
				unset($data['intent']);
				$data['host']='shindyadmin@yahoo.com';
				$this->db->insert('events',$data);
				$main = "success";
				$this->db->select('event_ID');
				$this->db->from('events');
				$this->db->where($data);
				$query=$this->db->get();
				$event=$query->result();
				$ev=array();
				foreach($event as $search)
				{
					$ev[] = $search->event_ID;
				}
				$event_ID = $ev[0];
				$response = json_encode(array('status'=>$main,'event_ID'=>$event_ID));
				return $response;
			}
			else
			{
				$response = json_encode(array('status'=>'missing credentials'));
				return $response;
			}
		}

		public function shindy_invite($data){
			if(isset($data))
			{
				$this->db->select('email');
				$this->db->from('users');
				$this->db->where('email !=','shindyadmin@yahoo.com');
				$query=$this->db->get();
				$email = $query->result();
				$allusers=array();
				foreach ($email as $search)
				{
					$allusers[] = $search->email;
				}
				print_r($allusers);
				$data['status']='0';
				unset($data['intent']);
				$data['sender_email']='shindyadmin@yahoo.com';
				for($x=0;$x<=(count($allusers)-1);$x++)
				{	
					$data['receiver_email']=$allusers[$x];
					$this->db->insert('invites',$data);
				}
				$main = "success";
				$response = json_encode(array('status'=>$main));
				return $response;
			}
			else
			{
				$response = json_encode(array('status'=>'missing credentials'));
				return $response;
			}
		}
		public function upload_image($data)
		{
			if(isset($data['event_ID'])&&isset($data['preview_image']))
			{
				unset($data['intent']);
				$this->db->insert('images',$data);
				$main = "upload finished";
				$response = json_encode(array('status'=>$main));
				return $response;
			}
			else
			{
				$response = json_encode(array('status'=>'upload failed'));
				return $response;
			}
		}
	}
?>