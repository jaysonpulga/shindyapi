<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class RESTevent_model extends CI_Model{



	



	  private $tbl_event 	= 'tbl_eventdetails';

	  private $tbl_eventdetails_schedule = 'tbl_eventdetails_schedule';

	  private $tbl_event_block = 'tbl_event_block';

	  private $tbl_event_like = 'tbl_event_like';

	  private $tbl_event_rating = 'tbl_event_rating';

	  private $tbl_event_discussion = 'tbl_event_discussion';

	  private $tbl_event_discussion_reply = 'tbl_event_discussion_reply';

	  private $tbl_event_discussion_like = 'tbl_event_discussion_like';

	  private $tbl_event_attendees = 'tbl_event_attendees';

	  private $tbl_user = 'tbl_user';

	  private $tbl_eventdetails_image = 'tbl_eventdetails_image';
		


	public function __construct()

	{
	
		parent::__construct();
		$this->load->database();						
		/*Load the URL helper*/          
		$this->load->helper('url'); 
		  /*Load the cookie */

	}
	
	public function inviteusers($eventid)
	{
		
		$this->db->select("main.*");
		$this->db->from($this->tbl_user.' '.'as main');
		$this->db->join($this->tbl_event.' '.'as t2', "t2.eventid = {$eventid}", 'left');
		$this->db->where('t2.eventid',$eventid);
		$where = "main.fbid NOT IN ( SELECT block.user_fbid FROM tbl_event_block as block where  block.block_status = 1  AND block.eventid = '$eventid' ) ";
		$where2 = "main.fbid NOT IN ( SELECT attend.attendee_id FROM tbl_event_attendees as attend where  (attend.status = 1 or attend.status = 0) AND attend.eventid = '$eventid' ) ";	
		$this->db->where($where);	
		$this->db->where($where2);			
		
		$query = $this->db->get();
		if($query)
		{
			return $query->result();
			exit();
		}
		return NULL;;
		
	}
	
	
	public function checkifyouareinattendeetable($eventid,$attendee_id)
	{
		$this->db->from('tbl_event_attendees');		
		$this->db->where('eventid',$eventid);
		$this->db->where('attendee_id',$attendee_id);		
		$query = $this->db->get();		
		return count($query->result());	
		
	}
	
	public function checkifvalidinvitationcode($invitecode,$eventid)
	{
		$this->db->from('tbl_event_attendees');		
		$this->db->where('eventid',$eventid);
		$this->db->where('invitecode',$invitecode);		
		$query = $this->db->get();		
		return count($query->result());	

	}
	
	
	
	
	public function checkifuserinvitetootheruser($eventid,$invite_by,$attendee_id)
	{
		$this->db->from('tbl_event_attendees');		
		$this->db->where('eventid',$eventid);
		$this->db->where('attendee_id',$attendee_id);
		$this->db->where('invite_by',$invite_by);		
		$query = $this->db->get();		
		return count($query->result());	
		
	}
	
	
	
	
	public function checkifyouareattendthisevent($eventid,$attendee_id)
	{
		$this->db->from('tbl_event_attendees');		
		$this->db->where('eventid', $eventid);
		$this->db->where('attendee_id', $attendee_id);
		$this->db->where('status', 1);		
		$query = $this->db->get();		
		return count($query->result());	
		
	}
	
	
	
	public function checkifeventExist($eventid)
	{
		$this->db->from('tbl_eventdetails');		
		$this->db->where('eventid', $eventid);		
		$query = $this->db->get();		
		return count($query->result());	
		
	}
	
	public function checkifdiscussionexist($commentid)
	{
		$this->db->from('tbl_event_discussion');		
		$this->db->where('discussion_id', $commentid);		
		$query = $this->db->get();		
		return count($query->result());	
		
	}
	
	

	public function save_image_event($field)
	{

		$this->db->insert($this->tbl_eventdetails_image,$field);
		$id	= $this->db->insert_id();
		return $id;	

	}	



	public function add_event($field)

	{

		$this->db->insert($this->tbl_event,$field);
		$id	= $this->db->insert_id();
		
		$data = array();
		$data['attendee_id'] = $field['user_fbid'];
		$data['eventid'] 	 = $id;
		$data['status'] 			= 1; // active
		$data['acceptdate'] 		= gmdate("Y-m-d h:i:s");
		$this->db->insert($this->tbl_event_attendees,$data);
		
		
		return $id;	

	}

	

	public function add_schedule($field)

	{

		$this->db->insert($this->tbl_eventdetails_schedule,$field);
		$id	= $this->db->insert_id();
		return $id;	

	}





	public function update_event($field,$condition)

	{

		$this->db->update($this->tbl_event,$field,$condition);

		return $this->db->affected_rows();

	}



	

	

	public function update_schedule($field,$condition)

	{

		$this->db->update($this->tbl_eventdetails_schedule,$field,$condition);

		return $this->db->affected_rows();

	}



	function get_event_list($eventid,$user_fbid)
	{

		
			$like = "(CASE WHEN like.id IS NOT NULL THEN 1 ELSE 0 END) AS  like_status";
			$block = "(CASE WHEN block.id IS NOT NULL THEN 1 ELSE 0 END) AS  block_status";
			$leave = "(CASE WHEN leave.id IS NOT NULL AND leave.status = '3' THEN 1 ELSE 0 END) AS  leave_status";
			
		
			$invitedstatus = "(CASE WHEN invitedstatus.id IS NOT NULL THEN '1' ELSE '0' END) AS  invited_status";
			$attendingstatus = "(CASE WHEN attendingstatus.status = 1 THEN '1' ELSE 0 END) AS  attendingstatus";
			$host_review = "(SELECT ROUND(SUM(host_review)/5,1) FROM tbl_event_rating  WHERE eventid = t1.eventid)  as host_review";

			$this->db->select("t1.*,t2.sched_startdate,t2.start_time,t2.sched_enddate,t2.end_time,t2.custom_price,t2.max_male,t2.max_female,(SELECT ROUND(SUM(rating)/5,1) FROM tbl_event_rating  WHERE eventid = t1.eventid)  as rating,{$host_review},t3.fullname as createdby,t3.fbid as createdby_fbid,t4.fullname as cohostname,t4.fbid as cohostname_fbid,{$like},{$block},{$leave},{$invitedstatus},{$attendingstatus}");

			$this->db->from($this->tbl_event.' '.'as t1');

			$this->db->join($this->tbl_eventdetails_schedule.' '.'as t2', 't1.eventid = t2.eventid', 'left');

			//$this->db->join($this->tbl_event_rating.' '.'as t3', 't1.eventid = t3.eventid', 'left');

			$this->db->join($this->tbl_user.' '.'as t3', 't1.user_fbid = t3.fbid', 'left');
			
			$this->db->join($this->tbl_user.' '.'as t4', 't1.representative = t4.fbid', 'left');

			$this->db->join($this->tbl_event_like.' '.'as like', "like.eventid = t1.eventid AND like.user_fbid = '$user_fbid' AND like.like_status = 1 ", 'left');
			$this->db->join($this->tbl_event_block.' '.'as block', "block.eventid = t1.eventid AND block.user_fbid = '$user_fbid' AND block.block_status = 1 ", 'left');
			
			$this->db->join($this->tbl_event_attendees.' '.'as invitedstatus', "invitedstatus.eventid = t1.eventid AND invitedstatus.attendee_id = '$user_fbid' ", 'left');
			
			$this->db->join($this->tbl_event_attendees.' '.'as attendingstatus', "attendingstatus.eventid = t1.eventid AND attendingstatus.attendee_id = '$user_fbid' ", 'left');
			
			$this->db->join($this->tbl_event_attendees.' '.'as leave', "leave.eventid = t1.eventid AND leave.attendee_id = '$user_fbid'  AND leave.status = 3 ", 'left');
			
			if(!empty($eventid)){
			$this->db->where('t1.eventid',$eventid);
			}			
			$this->db->group_by('t1.eventid'); 
			$this->db->order_by('t1.eventid', 'asc');

			$query = $this->db->get();						
			$result =  $query->result();			
			$events = array();
			if(!empty($result)){
				foreach($result as $row) {
				
					$path = base_url().'geteventimage/';					
					$sel = "(CASE WHEN image_code IS NOT NULL THEN CONCAT('$path','',image_code) ELSE ''  END ) as image_path";					
					$this->db->select("id,{$sel}");					
					$this->db->from('tbl_eventdetails_image');							
					$this->db->where('eventid', $row->eventid);							
					$query2 = $this->db->get();	
					
						$eventsArray['eventid'] 		=  $row->eventid;					  
						$eventsArray['eventcode'] =  $row->eventcode;					  
						$eventsArray['eventname'] =  $row->eventname;					  
						$eventsArray['image'] = 	$query2->result();					  
						$eventsArray['fulladdress'] =  $row->fulladdress;					  
						$eventsArray['long'] = $row->long;					  
						$eventsArray['lat'] =  $row->lat;					  
						$eventsArray['zipcode'] =  $row->zipcode;					  
						$eventsArray['website_url'] =  $row->website_url;					  
						$eventsArray['description'] =  $row->description;					  
						$eventsArray['notes'] =  $row->notes;					  
						$eventsArray['ticketprice'] =  $row->ticketprice;					  
						$eventsArray['createdate'] =  $row->createdate;					  
						$eventsArray['expirydate'] =  $row->expirydate;					  
						$eventsArray['sched_startdate'] =  $row->sched_startdate;					 
						$eventsArray['start_time'] =  $row->start_time;					  
						$eventsArray['sched_enddate'] =  $row->sched_enddate;					  
						$eventsArray['end_time'] =  $row->end_time;					 
						$eventsArray['custom_price'] =  $row->custom_price;					  
						$eventsArray['max_male'] =  $row->max_male;					  
						$eventsArray['max_female'] =  $row->max_female;					  
						$eventsArray['rating'] =  $row->rating;	
						$eventsArray['host_review'] =  $row->host_review;

						
						
						
						$eventsArray['cohostname_fbid'] =  $row->cohostname_fbid;
						$eventsArray['cohostname'] =  $row->cohostname;
						$eventsArray['createdby_fbid'] =  $row->createdby_fbid;
						$eventsArray['createdby'] =  $row->createdby;

						
						$eventsArray['like_status'] =  $row->like_status;					  
						$eventsArray['block_status'] =  $row->block_status;
						$eventsArray['leave_status'] =  $row->leave_status;
						$eventsArray['invited_status'] =  $row->invited_status;
						$eventsArray['attendingstatus'] =  $row->attendingstatus;
						
						
						
					
					$events[] = $eventsArray;						 			
				}							
				return $events;	
			}
			
			  return NULL;

    }

	

	function eventlistcreatedbyuser($user_fbid)
	{

		
			
			$like = "(CASE WHEN like.id IS NOT NULL THEN 1 ELSE 0 END) AS  like_status";
			$block = "(CASE WHEN block.id IS NOT NULL THEN 1 ELSE 0 END) AS  block_status";
			$leave = "(CASE WHEN leave.id IS NOT NULL AND leave.status = '3' THEN 1 ELSE 0 END) AS  leave_status";
		
			$invitedstatus = "(CASE WHEN invitedstatus.id IS NOT NULL THEN '1' ELSE '0' END) AS  invited_status";
			$attendingstatus = "(CASE WHEN attendingstatus.status = 1 THEN '1' ELSE 0 END) AS  attendingstatus";
			
			$host_review = "(SELECT ROUND(SUM(host_review)/5,1) FROM tbl_event_rating  WHERE eventid = t1.eventid)  as host_review";

			$this->db->select("t1.*,t2.sched_startdate,t2.start_time,t2.sched_enddate,t2.end_time,t2.custom_price,t2.max_male,t2.max_female,(SELECT ROUND(SUM(rating)/5,1) FROM tbl_event_rating  WHERE eventid = t1.eventid)  as rating,{$host_review},t3.fullname as createdby,{$like},{$block},{$leave},{$invitedstatus},{$attendingstatus}");

			$this->db->from($this->tbl_event.' '.'as t1');

			$this->db->join($this->tbl_eventdetails_schedule.' '.'as t2', 't1.eventid = t2.eventid', 'left');

			//$this->db->join($this->tbl_event_rating.' '.'as t3', 't1.eventid = t3.eventid', 'left');

			$this->db->join($this->tbl_user.' '.'as t3', 't1.user_fbid = t3.fbid', 'left');

			$this->db->join($this->tbl_event_like.' '.'as like', "like.eventid = t1.eventid AND like.user_fbid = '$user_fbid' AND like.like_status = 1 ", 'left');
			$this->db->join($this->tbl_event_block.' '.'as block', "block.eventid = t1.eventid AND block.user_fbid = '$user_fbid' AND block.block_status = 1 ", 'left');
			
			$this->db->join($this->tbl_event_attendees.' '.'as invitedstatus', "invitedstatus.eventid = t1.eventid AND invitedstatus.attendee_id = '$user_fbid' ", 'left');
			
			$this->db->join($this->tbl_event_attendees.' '.'as attendingstatus', "attendingstatus.eventid = t1.eventid AND attendingstatus.attendee_id = '$user_fbid' ", 'left');
			
			$this->db->join($this->tbl_event_attendees.' '.'as leave', "leave.eventid = t1.eventid AND leave.attendee_id = '$user_fbid' AND leave.status = 3 ", 'left');
			$this->db->where('t1.user_fbid',$user_fbid);	
			
			$this->db->group_by('t1.eventid'); 
			$this->db->order_by('t1.eventid', 'asc');

			$query = $this->db->get();						
			$result =  $query->result();			
			$events = array();
			if(!empty($result)){
				foreach($result as $row) {
				
					$path = base_url().'geteventimage/';					
					$sel = "(CASE WHEN image_code IS NOT NULL THEN CONCAT('$path','',image_code) ELSE ''  END ) as image_path";					
					$this->db->select("id,{$sel}");					
					$this->db->from('tbl_eventdetails_image');							
					$this->db->where('eventid', $row->eventid);							
					$query2 = $this->db->get();	
					
						$eventsArray['eventid'] 		=  $row->eventid;					  
						$eventsArray['eventcode'] =  $row->eventcode;					  
						$eventsArray['eventname'] =  $row->eventname;					  
						$eventsArray['image'] = 	$query2->result();					  
						$eventsArray['fulladdress'] =  $row->fulladdress;					  
						$eventsArray['long'] = $row->long;					  
						$eventsArray['lat'] =  $row->lat;					  
						$eventsArray['zipcode'] =  $row->zipcode;					  
						$eventsArray['website_url'] =  $row->website_url;					  
						$eventsArray['description'] =  $row->description;					  
						$eventsArray['notes'] =  $row->notes;					  
						$eventsArray['ticketprice'] =  $row->ticketprice;					  
						$eventsArray['createdate'] =  $row->createdate;					  
						$eventsArray['expirydate'] =  $row->expirydate;					  
						$eventsArray['sched_startdate'] =  $row->sched_startdate;					 
						$eventsArray['start_time'] =  $row->start_time;					  
						$eventsArray['sched_enddate'] =  $row->sched_enddate;					  
						$eventsArray['end_time'] =  $row->end_time;					 
						$eventsArray['custom_price'] =  $row->custom_price;
						$eventsArray['custom_price'] =  $row->custom_price;							
						$eventsArray['max_male'] =  $row->max_male;					  
						$eventsArray['max_female'] =  $row->max_female;					  
						$eventsArray['rating'] =  $row->rating;
						$eventsArray['host_review'] =  $row->host_review;							
						$eventsArray['createdby'] =  $row->createdby;
						$eventsArray['user_fbid'] =  $row->user_fbid;						
						$eventsArray['like_status'] =  $row->like_status;					  
						$eventsArray['block_status'] =  $row->block_status;
						$eventsArray['leave_status'] =  $row->leave_status;
						$eventsArray['invited_status'] =  $row->invited_status;
						$eventsArray['attendingstatus'] =  $row->attendingstatus;
						
					$events[] = $eventsArray;						 			
				}							
				return $events;	
			}
			
			  return NULL;



    }
	
	
	
	function listeventyousendinvite($user_fbid)
	{

		
			$joinmale = "(Select count(male.id) from tbl_event_attendees as male LEFT JOIN tbl_user as user ON user.fbid = male.attendee_id Where male.status = '1' and user.gender = '1') join_male";
			$joinfemale = "(Select count(male.id) from tbl_event_attendees as male LEFT JOIN tbl_user as user ON user.fbid = male.attendee_id Where male.status = '1' and user.gender = '2') joinfemale";
			$sched2 = "t2.sched_startdate,t2.start_time,t2.sched_enddate,t2.end_time,t2.custom_price,t2.max_male,t2.max_female";

			$like = "(CASE WHEN like.id IS NOT NULL THEN 1 ELSE 0 END) AS  like_status";
			$block = "(CASE WHEN block.id IS NOT NULL THEN 1 ELSE 0 END) AS  block_status";
			
			$rating = "(SELECT ROUND(SUM(rating)/5,1) FROM tbl_event_rating  WHERE eventid = t1.eventid)  as rating";
			
			$host_review = "(SELECT ROUND(SUM(host_review)/5,1) FROM tbl_event_rating  WHERE eventid = t1.eventid)  as host_review";
			
			$invitedstatus = "(CASE WHEN invitedstatus.id IS NOT NULL THEN '1' ELSE '0' END) AS  invited_status";
			$attendingstatus = "(CASE WHEN attendingstatus.status = 1 THEN '1' ELSE 0 END) AS  attendingstatus";
		
		
			$this->db->select("t1.*,{$sched2},t5.fullname as private_host,{$rating},{$host_review},{$joinmale},{$joinfemale},{$like},{$block},{$invitedstatus},{$attendingstatus}");

			$this->db->from($this->tbl_event.' '.'as t1');

			$this->db->join($this->tbl_eventdetails_schedule.' '.'as t2', 't1.eventid = t2.eventid', 'left');

			$this->db->join($this->tbl_event_attendees.' '.'as t3', 't1.eventid = t3.eventid', 'left');

			$this->db->join($this->tbl_user.' '.'as t4', 't3.invite_by = t4.fbid', 'left');

			$this->db->join($this->tbl_user.' '.'as t5', 't1.representative = t5.fbid', 'left');
			
			$this->db->join($this->tbl_event_like.' '.'as like', "like.eventid = t1.eventid AND like.user_fbid = '$user_fbid' AND like.like_status = 1 ", 'left');
			$this->db->join($this->tbl_event_block.' '.'as block', "block.eventid = t1.eventid AND block.user_fbid = '$user_fbid' AND block.block_status = 1 ", 'left');
			
			$this->db->join($this->tbl_event_attendees.' '.'as invitedstatus', "invitedstatus.eventid = t1.eventid AND invitedstatus.attendee_id = '$user_fbid' ", 'left');
			
			$this->db->join($this->tbl_event_attendees.' '.'as attendingstatus', "attendingstatus.eventid = t1.eventid AND attendingstatus.attendee_id = '$user_fbid' ", 'left');
			
			
			$this->db->where('t3.invite_by',$user_fbid);


			$this->db->group_by('t1.eventid'); 
			
			$query = $this->db->get();						
			$result =  $query->result();			
			$events = array();
			if(!empty($result)){
				foreach($result as $row) {
				
					$path = base_url().'geteventimage/';					
					$sel = "(CASE WHEN image_code IS NOT NULL THEN CONCAT('$path','',image_code) ELSE ''  END ) as image_path";					
					$this->db->select("id,{$sel}");					
					$this->db->from('tbl_eventdetails_image');							
					$this->db->where('eventid', $row->eventid);							
					$query2 = $this->db->get();	
					
						$eventsArray['eventid'] 		=  $row->eventid;					  
						$eventsArray['eventcode'] =  $row->eventcode;					  
						$eventsArray['eventname'] =  $row->eventname;					  
						$eventsArray['image'] = 	$query2->result();					  
						$eventsArray['fulladdress'] =  $row->fulladdress;					  
						$eventsArray['long'] = $row->long;					  
						$eventsArray['lat'] =  $row->lat;					  
						$eventsArray['zipcode'] =  $row->zipcode;					  
						$eventsArray['website_url'] =  $row->website_url;					  
						$eventsArray['description'] =  $row->description;					  
						$eventsArray['notes'] =  $row->notes;					  
						$eventsArray['ticketprice'] =  $row->ticketprice;					  
						$eventsArray['createdate'] =  $row->createdate;					  
						$eventsArray['expirydate'] =  $row->expirydate;					  
						$eventsArray['sched_startdate'] =  $row->sched_startdate;					 
						$eventsArray['start_time'] =  $row->start_time;					  
						$eventsArray['sched_enddate'] =  $row->sched_enddate;					  
						$eventsArray['end_time'] =  $row->end_time;					 
						$eventsArray['custom_price'] =  $row->custom_price;					  
						$eventsArray['max_male'] =  $row->max_male;					  
						$eventsArray['max_female'] =  $row->max_female;
						$eventsArray['private_host'] =  $row->private_host;					  
						$eventsArray['rating'] =  $row->rating;	
						$eventsArray['host_review'] =  $row->host_review;							
						$eventsArray['join_male'] =  $row->join_male;
						$eventsArray['joinfemale'] =  $row->joinfemale;						
						$eventsArray['like_status'] =  $row->like_status;					  
						$eventsArray['block_status'] =  $row->block_status;
						$eventsArray['invited_status'] =  $row->invited_status;
						$eventsArray['attendingstatus'] =  $row->attendingstatus;
						
						
						
					
					$events[] = $eventsArray;						 			
				}							
				return $events;	
			}
			
			  return NULL;	
			



    }

	

	function suggested_eventlist($eventid)

	{

			$this->db->select("eventid,eventname,image");

			$this->db->from($this->tbl_event);

			if(!empty($eventid)){

				$this->db->where('eventid',$eventid);		

			}

			$query = $this->db->get();

			if($query)

			{

				return $query->result();

				exit();

			}

			

        return NULL;



    }

	
	function attending_event($user_fbid,$attend_status)
	{

					
			$joinmale = "(Select count(male.id) from tbl_event_attendees as male LEFT JOIN tbl_user as user ON user.fbid = male.attendee_id Where male.status = '1' and user.gender = '1') join_male";
			$joinfemale = "(Select count(male.id) from tbl_event_attendees as male LEFT JOIN tbl_user as user ON user.fbid = male.attendee_id Where male.status = '1' and user.gender = '2') joinfemale";
			$sched2 = "t2.sched_startdate,t2.start_time,t2.sched_enddate,t2.end_time,t2.custom_price,t2.max_male,t2.max_female";

			$like = "(CASE WHEN like.id IS NOT NULL THEN 1 ELSE 0 END) AS  like_status";
			$block = "(CASE WHEN block.id IS NOT NULL THEN 1 ELSE 0 END) AS  block_status";
			
			$rating = "(SELECT ROUND(SUM(rating)/5,1) FROM tbl_event_rating  WHERE eventid = t1.eventid)  as rating";
			
			$host_review = "(SELECT ROUND(SUM(host_review)/5,1) FROM tbl_event_rating  WHERE eventid = t1.eventid)  as host_review";
			
			$invitedstatus = "(CASE WHEN invitedstatus.id IS NOT NULL THEN '1' ELSE '0' END) AS  invited_status";
			$attendingstatus = "(CASE WHEN attendingstatus.status = 1 THEN '1' ELSE 0 END) AS  attendingstatus";
			

			$select = "(CASE WHEN t3.anonymous_invite = '1' THEN 'anonymous' ELSE t4.fullname END) as invitedby, t3.invite_by as invited_by_id";
			$offertopay = "(CASE WHEN t3.offer_to_pay = '1' THEN '1' ELSE '0' END) as offer_to_pay, t3.invitecode";

			$this->db->select("t3.id as invitation_id,t1.*,{$sched2},t5.fullname as private_host,t5.fbid as private_host_fbid,{$select},{$offertopay},{$rating},{$host_review},{$joinmale},{$joinfemale},{$like},{$block},{$invitedstatus},{$attendingstatus}");
			
			
			
			$this->db->from($this->tbl_event.' '.'as t1');

			$this->db->join($this->tbl_eventdetails_schedule.' '.'as t2', 't1.eventid = t2.eventid', 'left');

			$this->db->join($this->tbl_event_attendees.' '.'as t3', 't1.eventid = t3.eventid', 'left');

			$this->db->join($this->tbl_user.' '.'as t4', 't3.invite_by = t4.fbid', 'left');

			$this->db->join($this->tbl_user.' '.'as t5', 't1.representative = t5.fbid', 'left');
			
			$this->db->join($this->tbl_event_like.' '.'as like', "like.eventid = t1.eventid AND like.user_fbid = '$user_fbid' AND like.like_status = 1 ", 'left');
			$this->db->join($this->tbl_event_block.' '.'as block', "block.eventid = t1.eventid AND block.user_fbid = '$user_fbid' AND block.block_status = 1 ", 'left');
			
			$this->db->join($this->tbl_event_attendees.' '.'as invitedstatus', "invitedstatus.eventid = t1.eventid AND invitedstatus.attendee_id = '$user_fbid' ", 'left');
			$this->db->join($this->tbl_event_attendees.' '.'as attendingstatus', "attendingstatus.eventid = t1.eventid AND attendingstatus.attendee_id = '$user_fbid' ", 'left');
			
			
			$whereblock = "t3.attendee_id NOT IN ( SELECT block.user_fbid FROM tbl_event_block as block where  block.block_status = 1  AND block.eventid = t3.eventid ) ";
			
			$this->db->where($whereblock);
			
			$this->db->where('t3.attendee_id',$user_fbid);

			$this->db->where('t3.status',$attend_status);

			$this->db->group_by('t3.id','t3.eventid','t3.invite_by');
			
			$this->db->order_by('t3.invitedate','desc');
			
			
			$query = $this->db->get();						
			$result =  $query->result();			
			$events = array();
			if(!empty($result)){
				foreach($result as $row) {
				
					$path = base_url().'geteventimage/';					
					$sel = "(CASE WHEN image_code IS NOT NULL THEN CONCAT('$path','',image_code) ELSE ''  END ) as image_path";					
					$this->db->select("id,{$sel}");					
					$this->db->from('tbl_eventdetails_image');							
					$this->db->where('eventid', $row->eventid);							
					$query2 = $this->db->get();
					
					
					
						$eventsArray['invitation_id'] 	=  $row->invitation_id;
						$eventsArray['eventid'] 		=  $row->eventid;					  
						//$eventsArray['eventcode'] =  $row->eventcode;					  
						$eventsArray['eventname'] =  $row->eventname;					  
						$eventsArray['image'] = 	$query2->result();					  
						$eventsArray['fulladdress'] =  $row->fulladdress;					  
						$eventsArray['long'] = $row->long;					  
						$eventsArray['lat'] =  $row->lat;					  
						$eventsArray['zipcode'] =  $row->zipcode;					  
						$eventsArray['website_url'] =  $row->website_url;					  
						$eventsArray['description'] =  $row->description;					  
						$eventsArray['notes'] =  $row->notes;					  
						$eventsArray['ticketprice'] =  $row->ticketprice;					  
						$eventsArray['createdate'] =  $row->createdate;					  
						$eventsArray['expirydate'] =  $row->expirydate;					  
						$eventsArray['sched_startdate'] =  $row->sched_startdate;					 
						$eventsArray['start_time'] =  $row->start_time;					  
						$eventsArray['sched_enddate'] =  $row->sched_enddate;					  
						$eventsArray['end_time'] =  $row->end_time;					 
						$eventsArray['custom_price'] =  $row->custom_price;					  
						$eventsArray['max_male'] =  $row->max_male;					  
						$eventsArray['max_female'] =  $row->max_female;
						$eventsArray['rating'] =  $row->rating;	
						$eventsArray['host_review'] =  $row->host_review;							
						$eventsArray['join_male'] =  $row->join_male;
						$eventsArray['joinfemale'] =  $row->joinfemale;						
						$eventsArray['like_status'] =  $row->like_status;					  
						$eventsArray['block_status'] =  $row->block_status;
						$eventsArray['invited_status'] =  $row->invited_status;
						$eventsArray['attendingstatus'] =  $row->attendingstatus;
						
						
						$eventsArray['private_host_fbid'] =  $row->private_host_fbid;
						$eventsArray['private_host'] =  $row->private_host;
			
						$eventsArray['invited_by_id'] =  $row->invited_by_id;			
						$eventsArray['invitedby'] =  $row->invitedby;	
						$eventsArray['offer_to_pay'] =  $row->offer_to_pay;
						$eventsArray['invitecode'] =  $row->invitecode;
						
						
					
						
					
					$events[] = $eventsArray;						 			
				}							
				return $events;	
			}
			
			  return NULL;
			
	
	}

	


	


	public function whoisinvited_event($dataevent)

	{

			$like = "(CASE WHEN like.id IS NOT NULL THEN 1 ELSE 0 END) AS  like_status";
			$block = "(CASE WHEN block.id IS NOT NULL THEN 1 ELSE 0 END) AS  block_status";

			$invite_anonymous = "(CASE WHEN t1.anonymous_invite = '1' THEN '1' ELSE '0' END) as anonymous_invite";
			$offertopay = "(CASE WHEN t1.offer_to_pay = '1' THEN '1' ELSE '0' END) as offer_to_pay";
			
			//$joinstatus = "(CASE WHEN t1.status = '1' THEN '1' ELSE '0' END) as invitestatus";
			
			$invitedstatus = "(CASE WHEN t1.id IS NOT NULL THEN '1' ELSE '0' END) AS  invitestatus";
			$attendingstatus = "(CASE WHEN t1.status = 1 THEN '1' ELSE 0 END) AS  attendingstatus";
			
			
			$this->db->select("t1.id,t1.eventid,t1.invitecode,t3.eventname,t2.fbid,t2.fullname,t2.photo,t1.invitedate,{$invitedstatus},{$attendingstatus},{$like},{$block},{$invite_anonymous},{$offertopay}");
			$this->db->from($this->tbl_event_attendees.' '.'as t1');
			$this->db->join($this->tbl_user.' '.'as t2', 't1.attendee_id = t2.fbid', 'left');
			$this->db->join($this->tbl_event.' '.'as t3', 't3.eventid = t1.eventid', 'left');
			
			$this->db->join($this->tbl_event_like.' '.'as like', "like.eventid = t1.eventid AND like.user_fbid = t1.attendee_id  AND like.like_status = 1 ", 'left');
			$this->db->join($this->tbl_event_block.' '.'as block', "block.eventid = t1.eventid AND block.user_fbid = t1.attendee_id  AND block.block_status = 1 ", 'left');
			
			
			/*$this->db->join($this->tbl_event_attendees.' '.'as cancel', "cancel.eventid = t1.eventid AND cancel.attendee_id = t1.attendee_id  AND cancel.status = 2 ", 'left');*/
			
			$whereblock = "t1.attendee_id NOT IN ( SELECT blockevent.user_fbid FROM tbl_event_block as blockevent where  blockevent.block_status = 1  AND blockevent.eventid = t1.eventid ) ";
			
			$this->db->where($whereblock);
			
			$this->db->where('t1.eventid',$dataevent['eventid']);
			
			/* 
				if(!empty($dataevent['invitestatus']))
				{
					$this->db->where('t1.status',$dataevent['invitestatus']);
				} 
			*/
			
			$this->db->where('t1.invite_by',$dataevent['user_fbid']);
			
			$wherestat = "(t1.status = 0 OR  t1.status = 1)";
			$this->db->where($wherestat);
			
			$this->db->order_by('t1.acceptdate','desc');
			
			$query = $this->db->get();
			
			
			$othereventid =   $dataevent['eventid'];
			$otheruser_fbid =   $dataevent['user_fbid'];
			
			$invite_anonymous_other = "(CASE WHEN t1new.anonymous_invite = '1' THEN '1' ELSE '0' END) as anonymous_invite";
			$offertopay_other = "(CASE WHEN t1new.offer_to_pay = '1' THEN '1' ELSE '0' END) as offer_to_pay";
			//$joinstatus_other = "(CASE WHEN t1new.status = '1' THEN '1' ELSE '0' END) as invitestatus";
			$inviteby = "invite_by.fbid as invite_by_fbid , invite_by.fullname as invite_by";
			
			$invitedstatus_other = "(CASE WHEN t1new.id IS NOT NULL THEN '1' ELSE '0' END) AS  invitestatus";
			$attendingstatus_other = "(CASE WHEN t1new.status = 1 THEN '1' ELSE 0 END) AS  attendingstatus";
			
			$this->db->select("t1new.id,t1new.eventid,t1new.invitecode,t3new.eventname,t2new.fbid,t2new.fullname,t2new.photo,t1new.invitedate,{$invitedstatus_other},{$attendingstatus_other},{$invite_anonymous_other},{$offertopay_other},{$inviteby}");
			$this->db->from($this->tbl_event_attendees.' '.'as t1new');
			$this->db->join($this->tbl_user.' '.'as t2new', 't1new.attendee_id = t2new.fbid', 'left');
			$this->db->join($this->tbl_user.' '.'as invite_by', 't1new.invite_by = invite_by.fbid', 'left');
			$this->db->join($this->tbl_event.' '.'as t3new', 't3new.eventid = t1new.eventid', 'left');
			//$whereko = "t1new.eventid = {$othereventid} AND  (t1new.status = 0 OR  t1new.status = 1)   AND (t1new.invite_by != {$otheruser_fbid} OR t1new.invite_by != '')";
			//$this->db->where($whereko);
			
			$whereko = "t1new.eventid = {$othereventid} AND  (t1new.status = 0 OR  t1new.status = 1)";
			$this->db->where($whereko);
			$this->db->where('t1new.invite_by !=', $otheruser_fbid);
			
			$this->db->order_by('t1new.acceptdate','desc');
			$query2 = $this->db->get();
			
			
		
			$datareturn = array();

			$datareturn['my_invites'] =  $query->result();
			$datareturn['others_invite'] =  $query2->result();
			
			return $datareturn;
			exit();

		

			

	

		

	}

	

	

	public function block_event($field)

	{

	

		

		$this->db->from($this->tbl_event_block);

		$this->db->where('user_fbid', $field['user_fbid']);

		$this->db->where('eventid', $field['eventid']);

		$query = $this->db->get();

		

		if(count($query->result()) == 0){

			$this->db->insert($this->tbl_event_block,$field);		

			$id	= $this->db->insert_id();		

			return $id;

		}else{

			

			$newdata = array();

			$newdata['update_date']  		= gmdate("Y-m-d h:i:s");

			$newdata['block_status']  		= 1;

			

			$this->db->where('user_fbid', $field['user_fbid']);

			$this->db->where('eventid', $field['eventid']);

			

			

			$this->db->update($this->tbl_event_block, $newdata);

			return $this->db->affected_rows();

		}	

		

		

	}

	

	

	public function unblock_event($field,$condition)

	{

		$this->db->update($this->tbl_event_block,$field,$condition);

		return $this->db->affected_rows();

	}

		

	public function eventblockedlist($user_fbid)
	{
			
			$invitedstatus = "(CASE WHEN invitedstatus.id IS NOT NULL THEN '1' ELSE '0' END) AS  invited_status";
			$attendingstatus = "(CASE WHEN attendingstatus.status = 1 THEN '1' ELSE 0 END) AS  attendingstatus";
			$like = "(CASE WHEN like.id IS NOT NULL THEN 1 ELSE 0 END) AS  like_status";
			$block = "(CASE WHEN block.id IS NOT NULL THEN 1 ELSE 0 END) AS  block_status";
			$leave = "(CASE WHEN leave.id IS NOT NULL AND leave.status = '3' THEN 1 ELSE 0 END) AS  leave_status";
			
			$sched = "t3.sched_startdate,t3.start_time,t3.sched_enddate,t3.end_time,t3.custom_price,t3.max_male,t3.max_female";
			
			$userdetail = "t5.fullname as createdby,t5.fbid as createdby_fbid,t4.fullname as cohostname,t4.fbid as cohostname_fbid";
		
			$this->db->select("t1.id as blocked_id,t1.blockcode,t1.block_status,t1.block_date,t1.update_date,t2.eventid as eventid,t2.*,{$sched},{$like},{$block},{$leave},{$invitedstatus},{$attendingstatus},{$userdetail}");

			$this->db->from($this->tbl_event_block.' '.'as t1');

			$this->db->join($this->tbl_event.' '.'as t2', 't1.eventid = t2.eventid', 'left');

			$this->db->join($this->tbl_eventdetails_schedule.' '.'as t3', 't1.eventid = t3.eventid', 'left');
			
			
			$this->db->join($this->tbl_user.' '.'as t5', 't2.user_fbid = t5.fbid', 'left');
			
			$this->db->join($this->tbl_user.' '.'as t4', 't2.representative = t4.fbid', 'left');
			
		
			$this->db->join($this->tbl_event_like.' '.'as like', "like.eventid = t1.eventid AND like.user_fbid = '$user_fbid' AND like.like_status = 1 ", 'left');

			$this->db->join($this->tbl_event_block.' '.'as block', "block.eventid = t1.eventid AND block.user_fbid = '$user_fbid' AND block.block_status = 1 ", 'left');

			$this->db->join($this->tbl_event_attendees.' '.'as invitedstatus', "invitedstatus.eventid = t1.eventid AND invitedstatus.attendee_id = '$user_fbid' ", 'left');

			$this->db->join($this->tbl_event_attendees.' '.'as attendingstatus', "attendingstatus.eventid = t1.eventid AND attendingstatus.attendee_id = '$user_fbid' ", 'left');
			
			$this->db->join($this->tbl_event_attendees.' '.'as leave', "leave.eventid = t1.eventid AND leave.attendee_id = '$user_fbid' AND leave.status = 3 ", 'left');
			
			$this->db->where('t1.user_fbid',$user_fbid);

			$this->db->where('t1.block_status',1);
			
			$this->db->group_by('t1.id','t1.eventid','t1.user_fbid');
			
			$this->db->order_by('t1.block_date','desc');
			
			$query = $this->db->get();
			

			$result =  $query->result();			
			$events = array();
			if(!empty($result)){
				foreach($result as $row) {
				
					$path = base_url().'geteventimage/';					
					$sel = "(CASE WHEN image_code IS NOT NULL THEN CONCAT('$path','',image_code) ELSE ''  END ) as image_path";					
					$this->db->select("id,{$sel}");					
					$this->db->from('tbl_eventdetails_image');							
					$this->db->where('eventid', $row->eventid);							
					$query2 = $this->db->get();	
						
					
						$eventsArray['blocked_id'] 		=  $row->blocked_id;					  
						$eventsArray['blockcode'] =  $row->blockcode;					  
						$eventsArray['block_status'] =  $row->block_status;
						$eventsArray['block_date'] =  $row->block_date;
						$eventsArray['update_date'] =  $row->update_date;
						$eventsArray['eventid'] 	=  $row->eventid;					  
						$eventsArray['eventcode'] =  $row->eventcode;					  
						$eventsArray['eventname'] =  $row->eventname;					  
						$eventsArray['image'] = 	$query2->result();					  
						$eventsArray['fulladdress'] =  $row->fulladdress;					  
						$eventsArray['long'] = $row->long;					  
						$eventsArray['lat'] =  $row->lat;					  
						$eventsArray['zipcode'] =  $row->zipcode;					  
						$eventsArray['website_url'] =  $row->website_url;					  
						$eventsArray['description'] =  $row->description;					  
						$eventsArray['notes'] =  $row->notes;					  
						$eventsArray['ticketprice'] =  $row->ticketprice;
						$eventsArray['user_fbid'] =  $row->user_fbid;
						
						/* $eventsArray['representative'] =  $row->representative;
						$eventsArray['createdate'] =  $row->createdate; */
						
						$eventsArray['cohostname_fbid'] =  $row->cohostname_fbid;
						$eventsArray['cohostname'] =  $row->cohostname;
						$eventsArray['createdby_fbid'] =  $row->createdby_fbid;
						$eventsArray['createdby'] =  $row->createdby;

						
				
						
						
						$eventsArray['expirydate'] =  $row->expirydate;					  
						$eventsArray['sched_startdate'] =  $row->sched_startdate;					 
						$eventsArray['start_time'] =  $row->start_time;					  
						$eventsArray['sched_enddate'] =  $row->sched_enddate;					  
						$eventsArray['end_time'] =  $row->end_time;					 
						$eventsArray['custom_price'] =  $row->custom_price;					  
						$eventsArray['max_male'] =  $row->max_male;					  
						$eventsArray['max_female'] =  $row->max_female;
						$eventsArray['like_status'] =  $row->like_status;					  
						$eventsArray['block_status'] =  $row->block_status;
						$eventsArray['leave_status'] =  $row->leave_status;
						$eventsArray['invited_status'] =  $row->invited_status;
						$eventsArray['attendingstatus'] =  $row->attendingstatus;
						
							
					$events[] = $eventsArray;						 			
				}							
				return $events;	
			}
			
			  return NULL;

	}

	

	public function like_event($field)

	{

		

		

		$this->db->from($this->tbl_event_like);

		$this->db->where('user_fbid', $field['user_fbid']);

		$this->db->where('eventid', $field['eventid']);

		$query = $this->db->get();

		

		if(count($query->result()) == 0){

			$this->db->insert($this->tbl_event_like,$field);		

			$id	= $this->db->insert_id();		

			return $id;

		}else{

			

			$newdata = array();

			$newdata['update_date']  		= gmdate("Y-m-d h:i:s");

			$newdata['like_status']  		= 1;

			

			$this->db->where('user_fbid', $field['user_fbid']);

			$this->db->where('eventid', $field['eventid']);

			

			

			$this->db->update($this->tbl_event_like, $newdata);

			return $this->db->affected_rows();

		}	

		

	}

	

	

	public function unlike_event($field,$condition)

	{

		$this->db->update($this->tbl_event_like,$field,$condition);

		return $this->db->affected_rows();

	}

	

	

	public function eventlikelist($user_fbid)

	{	

			$invitedstatus = "(CASE WHEN invitedstatus.id IS NOT NULL THEN '1' ELSE '0' END) AS  invited_status";
			$attendingstatus = "(CASE WHEN attendingstatus.status = 1 THEN '1' ELSE 0 END) AS  attendingstatus";

			$like = "(CASE WHEN like.id IS NOT NULL THEN 1 ELSE 0 END) AS  like_status";
			$block = "(CASE WHEN block.id IS NOT NULL THEN 1 ELSE 0 END) AS  block_status";
			$leave = "(CASE WHEN leave.id IS NOT NULL AND leave.status = '3' THEN 1 ELSE 0 END) AS  leave_status";
			
			$sched2 = "t3.sched_startdate,t3.start_time,t3.sched_enddate,t3.end_time,t3.custom_price,t3.max_male,t3.max_female";
			
			
			
			$userdetails = "t5.fullname as createdby,t5.fbid as createdby_fbid,t4.fullname as cohostname,t4.fbid as cohostname_fbid";

			$this->db->select("t1.id as liked_id,t1.like_status,t1.like_date,t1.update_date,t2.*,{$sched2},{$like},{$block},{$leave},{$invitedstatus},{$attendingstatus},{$userdetails}");

			$this->db->from($this->tbl_event_like.' '.'as t1');

			$this->db->join($this->tbl_event.' '.'as t2', 't1.eventid = t2.eventid', 'left');

			$this->db->join($this->tbl_eventdetails_schedule.' '.'as t3', 't1.eventid = t3.eventid', 'left');
			
			$this->db->join($this->tbl_user.' '.'as t5', 't2.user_fbid = t5.fbid', 'left');
			
			$this->db->join($this->tbl_user.' '.'as t4', 't2.representative = t4.fbid', 'left');
			
			$this->db->join($this->tbl_event_like.' '.'as like', "like.eventid = t1.eventid AND like.user_fbid = '$user_fbid' AND like.like_status = 1 ", 'left');

			$this->db->join($this->tbl_event_block.' '.'as block', "block.eventid = t1.eventid AND block.user_fbid = '$user_fbid' AND block.block_status = 1 ", 'left');

			$this->db->join($this->tbl_event_attendees.' '.'as invitedstatus', "invitedstatus.eventid = t1.eventid AND invitedstatus.attendee_id = '$user_fbid' ", 'left');

			$this->db->join($this->tbl_event_attendees.' '.'as attendingstatus', "attendingstatus.eventid = t1.eventid AND attendingstatus.attendee_id = '$user_fbid' ", 'left');
			
			$this->db->join($this->tbl_event_attendees.' '.'as leave', "leave.eventid = t1.eventid AND leave.attendee_id = '$user_fbid' AND leave.status = 3 ", 'left');
			
			$this->db->where('t1.user_fbid',$user_fbid);

			$this->db->where('t1.like_status',1);

			$this->db->group_by('t1.id'); 

			$query = $this->db->get();

			$result =  $query->result();			
			$events = array();
			if(!empty($result)){
				foreach($result as $row) {
				
					$path = base_url().'geteventimage/';					
					$sel = "(CASE WHEN image_code IS NOT NULL THEN CONCAT('$path','',image_code) ELSE ''  END ) as image_path";					
					$this->db->select("id,{$sel}");					
					$this->db->from('tbl_eventdetails_image');							
					$this->db->where('eventid', $row->eventid);							
					$query2 = $this->db->get();	
						
					
						$eventsArray['liked_id'] 	=  $row->liked_id;					  				  
						$eventsArray['like_status'] =  $row->like_status;
						$eventsArray['like_date'] =  $row->like_date;
						$eventsArray['update_date'] =  $row->update_date;
						$eventsArray['eventid'] 	=  $row->eventid;					  
						$eventsArray['eventcode'] =  $row->eventcode;					  
						$eventsArray['eventname'] =  $row->eventname;					  
						$eventsArray['image'] = 	$query2->result();					  
						$eventsArray['fulladdress'] =  $row->fulladdress;					  
						$eventsArray['long'] = $row->long;					  
						$eventsArray['lat'] =  $row->lat;					  
						$eventsArray['zipcode'] =  $row->zipcode;					  
						$eventsArray['website_url'] =  $row->website_url;					  
						$eventsArray['description'] =  $row->description;					  
						$eventsArray['notes'] =  $row->notes;					  
						$eventsArray['ticketprice'] =  $row->ticketprice;
						/*
						$eventsArray['user_fbid'] =  $row->user_fbid;
						$eventsArray['representative'] =  $row->representative;
						*/
						
						$eventsArray['cohostname_fbid'] =  $row->cohostname_fbid;
						$eventsArray['cohostname'] =  $row->cohostname;
						$eventsArray['createdby_fbid'] =  $row->createdby_fbid;
						$eventsArray['createdby'] =  $row->createdby;
						
						$eventsArray['createdate'] =  $row->createdate;					  
						$eventsArray['expirydate'] =  $row->expirydate;					  
						$eventsArray['sched_startdate'] =  $row->sched_startdate;					 
						$eventsArray['start_time'] =  $row->start_time;					  
						$eventsArray['sched_enddate'] =  $row->sched_enddate;					  
						$eventsArray['end_time'] =  $row->end_time;					 
						$eventsArray['custom_price'] =  $row->custom_price;					  
						$eventsArray['max_male'] =  $row->max_male;					  
						$eventsArray['max_female'] =  $row->max_female;
						$eventsArray['like_status'] =  $row->like_status;					  
						$eventsArray['block_status'] =  $row->block_status;
						$eventsArray['leave_status'] =  $row->leave_status;
						$eventsArray['invited_status'] =  $row->invited_status;
						$eventsArray['attendingstatus'] =  $row->attendingstatus;
						
							
					$events[] = $eventsArray;						 			
				}							
				return $events;	
			}
			
			  return NULL;


		

		

	}

	

	

	

	public function rate_event($field)

	{

		

		$this->db->from($this->tbl_event_rating);

		$this->db->where('eventid', $field['eventid']);

		$this->db->where('user_fbid', $field['user_fbid']);

		$query = $this->db->get();

		

		if(count($query->result()) == 0){

			$id	= $this->db->insert($this->tbl_event_rating, $field);

			return $id;	

			exit();

		}else{

			$this->db->where('eventid', $field['eventid']);

			$this->db->where('user_fbid', $field['user_fbid']);

			$this->db->update($this->tbl_event_rating, $field);

			return $this->db->affected_rows();

			exit();

		}

		return NULL; 

		

	}

	

	public function updaterate_event($field,$condition)

	{

		

		$this->db->update($this->tbl_event_rating,$field,$condition);

		return $this->db->affected_rows();

		

	}

	

	public function eventratelist($eventid)

	{	

	

	

			$this->db->select("t1.*,t2.fullname");

			$this->db->from($this->tbl_event_rating.' '.'as t1');

			$this->db->join($this->tbl_user.' '.'as t2', 't1.user_fbid = t2.fbid', 'left');

			$this->db->where('t1.eventid',$eventid);

	
			$query = $this->db->get();

		

			if($query)

			{

				return $query->result();

				exit();

			}

			

			return NULL;

	}

	

	public function eventreviewlist($user_fbid)

	{	

			$sched2 = "t3.sched_startdate,t3.start_time,t3.sched_enddate,t3.end_time,t3.custom_price,t3.max_male,t3.max_female";

	

			$this->db->select("t1.id,t1.feedback,t1.rating,t1.host_review,t1.rate_date,t1.update_date ,t2.*,{$sched2}");

			$this->db->from($this->tbl_event_rating.' '.'as t1');

			$this->db->join($this->tbl_event.' '.'as t2', 't1.eventid = t2.eventid', 'left');

			$this->db->join($this->tbl_eventdetails_schedule.' '.'as t3', 't2.eventid = t3.eventid', 'left');

			$this->db->where('t1.user_fbid',$user_fbid);

			$query = $this->db->get();

			
			$result =  $query->result();			
			$events = array();
			if(!empty($result)){
				foreach($result as $row) {
				
					$path = base_url().'geteventimage/';					
					$sel = "(CASE WHEN image_code IS NOT NULL THEN CONCAT('$path','',image_code) ELSE ''  END ) as image_path";					
					$this->db->select("id,{$sel}");					
					$this->db->from('tbl_eventdetails_image');							
					$this->db->where('eventid', $row->eventid);							
					$query2 = $this->db->get();	
						
					
						$eventsArray['id'] 	=  $row->id;					  				  
						$eventsArray['feedback'] =  $row->feedback;
						$eventsArray['rating'] =  $row->rating;
						$eventsArray['host_review'] =  $row->host_review;
						$eventsArray['rate_date'] =  $row->rate_date;
						$eventsArray['update_date'] =  $row->update_date;
						$eventsArray['eventid'] 	=  $row->eventid;					  
						$eventsArray['eventcode'] =  $row->eventcode;					  
						$eventsArray['eventname'] =  $row->eventname;					  
						$eventsArray['image'] = 	$query2->result();					  
						$eventsArray['fulladdress'] =  $row->fulladdress;					  
						$eventsArray['long'] = $row->long;					  
						$eventsArray['lat'] =  $row->lat;					  
						$eventsArray['zipcode'] =  $row->zipcode;					  
						$eventsArray['website_url'] =  $row->website_url;					  
						$eventsArray['description'] =  $row->description;					  
						$eventsArray['notes'] =  $row->notes;					  
						$eventsArray['ticketprice'] =  $row->ticketprice;
						$eventsArray['user_fbid'] =  $row->user_fbid;
						$eventsArray['representative'] =  $row->representative;
						$eventsArray['createdate'] =  $row->createdate;					  
						$eventsArray['expirydate'] =  $row->expirydate;					  
						$eventsArray['sched_startdate'] =  $row->sched_startdate;					 
						$eventsArray['start_time'] =  $row->start_time;					  
						$eventsArray['sched_enddate'] =  $row->sched_enddate;					  
						$eventsArray['end_time'] =  $row->end_time;					 
						$eventsArray['custom_price'] =  $row->custom_price;					  
						$eventsArray['max_male'] =  $row->max_male;					  
						$eventsArray['max_female'] =  $row->max_female;					  
						
							
					$events[] = $eventsArray;						 			
				}							
				return $events;	
			}
			
			  return NULL;

	}

	



	public function checkifuseralreadyjoined($eventid,$attendee_id)
	{				

	
			$array = array();

			$this->db->select("*");

			$this->db->from('tbl_event_attendees');

			$this->db->where('eventid',$eventid);

			$this->db->where('attendee_id',$attendee_id);

			$this->db->where('status',1);			

			$query = $this->db->get();

			return count($query->result());	

	}
	
	public function checkifreachmaximuninvite($eventid,$attendee_id)
	{				

	
			$array = array();

			$this->db->select("count(eventid) as number_of_invite");

			$this->db->from('tbl_event_attendees');

			$this->db->where('eventid',$eventid);

			$this->db->where('attendee_id',$attendee_id);
			
			$this->db->group_by('eventid','attendee_id');

			$query = $this->db->get();

			$res = $query->row();
			
			return $res->number_of_invite;

	}

	

	

	public function checkifuserblockevent($eventid,$attendee_id)

	{				

		

		 

			$array = array();

			$this->db->select("*");

			$this->db->from('tbl_event_block');

			$this->db->where('eventid',$eventid);

			$this->db->where('user_fbid',$attendee_id);			

			$where = "(block_status = 1)";

			$this->db->where($where);	

			$query = $this->db->get();

			return count($query->result());	

	

	}

	

	

	public function checkifcodeExist($eventcode)
	{


			$array = array();

			$this->db->select("*");

			$this->db->from('tbl_z_mailsenthistory');

			$this->db->where('invitecode',$eventcode);			

			$query = $this->db->get();

			return count($query->result());	

	}
	
	public function getDetailforsentemail($eventcode)
	{


			$array = array();

			$this->db->select("eventid,user_fbid,sentdate");

			$this->db->from('tbl_z_mailsenthistory');

			$this->db->where('invitecode',$eventcode);			

			$query = $this->db->get();

			$val = $query->row();
			
			return $val;

	}
	
	


	public function sendinvite($field)

	{

		$this->db->insert('tbl_event_attendees',$field);

		$id	= $this->db->insert_id();

		return $id;	

	}

	

	public function cancelinvitation($field,$conditions)

	{

		/*$this->db->delete('tbl_event_attendees',$field,$conditions);*/

 		$this->db->where($conditions);
   		$this->db->delete('tbl_event_attendees'); 
		return $this->db->affected_rows();

	}



	public function acceptinvitation($field,$conditions)

	{

		$this->db->update('tbl_event_attendees',$field,$conditions);

		return $this->db->affected_rows();

	}

	

	public function leave_event($field,$conditions)

	{

		$this->db->update('tbl_event_attendees',$field,$conditions);

		return $this->db->affected_rows();

	}

	

	

	public function addeventdiscussion($field)

	{

			$this->db->insert($this->tbl_event_discussion,$field);

			$id	= $this->db->insert_id();

			return $id;

	}

	

	public function updateeventdiscussion($field,$condition)

	{

			$this->db->update($this->tbl_event_discussion,$field,$condition);

			return $this->db->affected_rows();

	}

	

	public function geteventdiscussion($eventid,$user_fbid)

	{

			

			
			$like = "(CASE WHEN like.id IS NOT NULL THEN 1 ELSE 0 END) AS  like_status";


			$this->db->select("dis.eventid,dis.discussion_id,dis.user_fbid,dis.comment,dis.comment_date,t2.fullname,t2.photo,count(DISTINCT(likestat.id)) as num_likes,{$like}");

			$this->db->from($this->tbl_event_discussion.' '.'as dis');

			$this->db->join($this->tbl_event_discussion_like.' '.'as likestat', 'likestat.commentid = dis.discussion_id AND  likestat.like_status = 1', 'left');

			$this->db->join($this->tbl_user.' '.'as t2', 'dis.user_fbid = t2.fbid', 'left');

			$this->db->join($this->tbl_event_discussion_like.' '.'as like', "like.commentid = dis.discussion_id AND like.user_fbid = '$user_fbid' AND like.like_status = 1 ", 'left');

			$this->db->where('dis.eventid',$eventid);
			

			$this->db->group_by('dis.discussion_id');
	

			$query = $this->db->get();

		

			/* if($query)

			{

				return $query->result();

				exit();

			} */
			$result =  $query->result();			
			$events = array();
			if(!empty($result)){
				foreach($result as $row) {
				
							
					$this->db->select("t1.reply_id,t1.reply_comment,t1.reply_date,t2.fbid,t2.fullname,t2.photo");					
					$this->db->from($this->tbl_event_discussion_reply.' '.'as t1');
					$this->db->join($this->tbl_user.' '.'as t2', 't1.user_fbid = t2.fbid', 'left');					
					$this->db->where('t1.eventid',$row->eventid);
					$this->db->where('t1.discussion_id',$row->discussion_id);						
					$query2 = $this->db->get();	
						
						
						$eventsArray['discussion_id'] = $row->discussion_id;	
						$eventsArray['eventid'] 	=  $row->eventid;					  					  
						$eventsArray['comment'] =  $row->comment;
						$eventsArray['comment_date'] =  $row->comment_date;
						$eventsArray['user_fbid'] =  $row->user_fbid;
						$eventsArray['fullname'] =  $row->fullname;
						$eventsArray['photo'] =  $row->photo;
						$eventsArray['num_likes'] =  $row->num_likes;
						$eventsArray['like_status'] =  $row->like_status;
						$eventsArray['reply'] = 	$query2->result();					  			
						$events[] = $eventsArray;						 			
				}							
				return $events;	
				exit();
			}
			

			return NULL;

			

			

			

		

		

	}

	

	public function like_discussion($field)

	{

	
		$this->db->from($this->tbl_event_discussion_like);

		$this->db->where('user_fbid', $field['user_fbid']);

		$this->db->where('commentid', $field['commentid']);

		$query = $this->db->get();

		

		if(count($query->result()) == 0){

			$this->db->insert($this->tbl_event_discussion_like,$field);		

			$id	= $this->db->insert_id();		

			return $id;

		}else{

			

			$newdata = array();

			$newdata['update_date']  		= gmdate("Y-m-d h:i:s");

			$newdata['like_status']  		= 1;

			

			$this->db->where('user_fbid', $field['user_fbid']);

			$this->db->where('commentid', $field['commentid']);

			

			

			$this->db->update($this->tbl_event_discussion_like, $newdata);

			return $this->db->affected_rows();

		}	

		

	}

	

	

	public function unlike_discussion($field,$condition)

	{

		$this->db->update($this->tbl_event_discussion_like,$field,$condition);

		return $this->db->affected_rows();

	}

	

	

	public function discussionlikelist($commentid)

	{



			$this->db->select("t1.*,t2.fullname,t2.photo");

			$this->db->from($this->tbl_event_discussion_like.' '.'as t1');

			$this->db->join($this->tbl_user.' '.'as t2', 't1.user_fbid = t2.fbid', 'left');

			$this->db->where('t1.commentid',$commentid);

			$this->db->where('t1.like_status',1);

			$query = $this->db->get();

		

			if($query)

			{

				return $query->result();

				exit();

			}

			

			return NULL;

			

	}

	

	

	public function replyeventdiscussion($field)

	{

			$this->db->insert($this->tbl_event_discussion_reply,$field);

			$id	= $this->db->insert_id();

			return $id;

	}

	

	public function update_replyeventdiscussion($field,$condition)

	{

			$this->db->update($this->tbl_event_discussion_reply,$field,$condition);

			return $this->db->affected_rows();

	}

	

	public function replydiscussionlist($eventid,$discussion_id)

	{

		

			$this->db->select("t1.*,t2.fullname,t2.photo");

			$this->db->from($this->tbl_event_discussion_reply.' '.'as t1');

			$this->db->join($this->tbl_user.' '.'as t2', 't1.user_fbid = t2.fbid', 'left');
			
			if(!empty($eventid)){
			$this->db->where('t1.eventid',$eventid);
			}
			if(!empty($discussion_id)){
			$this->db->where('t1.discussion_id',$discussion_id);
			}
			
			
			$query = $this->db->get();

		

			if($query)

			{

				return $query->result();

				exit();

			}   

			

			return NULL;

		

	}

	

	

	public function sendinviteby_email($field)
	{
	
		$result = $this->sendinvitationviaemail($field);
		return $result;
		
	}
	
	public function sendinvitationviaemail($field)
	{
		
		include 'mail_credential/class.phpmailer.php';
		include 'mail_credential/class.smtp.php';
	  
		$this->db->select("t1.eventname,t1.eventcode,t2.sched_startdate,t2.start_time");
		$this->db->from($this->tbl_event.' '.'as t1');
		$this->db->join($this->tbl_eventdetails_schedule.' '.'as t2', 't1.eventid = t2.eventid', 'left');
		$this->db->where('t1.eventid',$field['eventid']);		
		$query = $this->db->get();
		$res = $query->row();
		
		
		$this->db->select("t1.fullname");
		$this->db->from($this->tbl_user.' '.'as t1');
		$this->db->where('t1.fbid',$field['invited_by']);		
		$query = $this->db->get();
		$person = $query->row();

	
	  $nameofsender =  $person->fullname;
	  $nameofevent =  $res->eventname;
	  $eventschedule = "";
	  $note = $field['note'];
	  $eventinvitecode =  $field['invitecode'];
	  $emailrequest = $field['user_email'];
	  
	  if(!empty($res->sched_startdate))
	  {
		  $newDate = date('F d, Y', strtotime($res->sched_startdate));
		  $newTime = date('h:i A', strtotime($res->start_time));
		  
		  $eventschedule = ",the event schedule will be on date {$newDate} {$newTime}";
	  }
	  
	  
	  
	  
	$field['messages'] = "<div style='margin-left:50px'>
						<p style='font-size:12px;line-height:1.4;font-family:Helvetica,Arial,sans-serif;text-align:left'>
						Hello,
						<br>
						<br>
						<i>{$nameofsender}</i>
						from <b>Shindig</b> has invited youto join <strong>{$nameofevent}</strong> {$eventschedule}
						<br><br>
						{$note}
						<br>
						<br>
						If you want to join this event you may download shindig application and use the event code for this comming event 
						<br>
						<b>Event Invite Code: </b>{$eventinvitecode}
						<br>
						<br>
						Thank you
				  </p></div>";
	  
				  $subject = "Event Invitation From Shindig";
				  $headers = "MIME-Version: 1.0\n";
				  $headers .= "Content-Type: text/html; charset=iso-8859-1\n";
					
				  $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
				  $mail->IsSMTP(); 								  // telling the class to use SMTP
					
				  $mail->SMTPAuth   = true;
				  $mail->SMTPSecure = "ssl";
				  $mail->Host       = "smtp.gmail.com";    		  // sets GMAIL as the SMTP server
				  $mail->Port       =  465;						  //"465"; 
				  $mail->Username   = "jaysonpulga22@gmail.com";  //"noreply@acumed.com.sg";  // GMAIL username
				  $mail->Password   = "jaysonpulga123";           // GMAIL password
				  
				  $mail->AddReplyTo("noreply@gmail.com",'');
				  $mail->SetFrom("no-reply@gmail.com","no-reply");
					  
				  $mail->AddAddress($emailrequest);
				  $mail->Subject = $subject;
				  $mail->Header  = $headers;
				  $mail->MsgHTML($field['messages']);
				  
					if($mail->Send())
					{		
							$data['eventid']    = $field['eventid'];
							$data['invitecode'] = $field['invitecode'];
							$data['user_fbid']  = $field['invited_by'];
							$data['user_email'] = $field['user_email'];
							$data['message']    = $field['messages'];
							$data['sentdate']   = gmdate("Y-m-d h:i:s");
							$this->db->insert('tbl_z_mailsenthistory',$data);
							return true;
							
							
					}
					else
					{
							
						return false;
					} 

		
		
		
	}

	


}



?>