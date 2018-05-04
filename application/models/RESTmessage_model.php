<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RESTmessage_model extends CI_Model{
	
	
	private $tbl_message 	= 'tbl_message';	private $tbl_user = 'tbl_user';
	
	public function __construct()
	{

		parent::__construct();
		$this->load->database();
		  /*Load the cookie */

	}
	
	
	public function SendMessage($datamessage)
	{
		$this->db->insert($this->tbl_message,$datamessage);
		$id	= $this->db->insert_id();
		return $id;	
		
	}
	
	public function Seenmessage($field,$condition)
	{
		$this->db->update($this->tbl_message,$field,$condition);
		return $this->db->affected_rows();
	}
	
	public function checkifhaveamessage($condition)
	{
		
		$query = $this->db->get_where($this->tbl_message,$condition);		 
		if ($query) 
		{	
			return $query->result();			
			exit();		 
		}        
		return NULL;
	}
	
	public function deletemessage($user_fbid,$condition)
	{
		$query = $this->db->get_where($this->tbl_message,$condition);		 
		$datax = $query->row();
		$mrkasdelete = $datax->markasdelete;
		if(!empty($mrkasdelete)){
			$user_fbid = array($user_fbid);
			$mrkasdelete = array($mrkasdelete);
			$newvalue = array_merge($mrkasdelete,$user_fbid);
			$field['markasdelete'] =  implode(",",$newvalue);
			
		}
		else
		{
			$field['markasdelete'] = $user_fbid;
			
		}
	
	
	
		$this->db->update($this->tbl_message,$field,$condition);
		return $this->db->affected_rows();
	}
	
	
	public function getPMmessage($user_fbid,$friend_fbid)
	{
		
			$this->db->from($this->tbl_message);		
			$where = "((sender_id = '$user_fbid' and recipient_id = '$friend_fbid') OR (recipient_id = '$user_fbid' and sender_id = '$friend_fbid') )";
			$this->db->where($where);
			$this->db->where_not_in('markasdelete',$user_fbid);			
			$query = $this->db->get();
			return $query->result();
	
		

	}
	
	
	public function getAllmessage($user_fbid,$search)
	{
		$this->db->select("t1.sender_id,t1.recipient_id,t2.fullname as friend_fullname,t2.photo as friend_photo");
		//$this->db->select("t1.sender_id,t1.recipient_id");
		$this->db->from($this->tbl_message.' '.'as t1');			
		$where = "((t1.sender_id = '$user_fbid') OR (t1.recipient_id = '$user_fbid' ))";
		$con = "((t1.sender_id = t2.fbid) OR (t1.recipient_id = t2.fbid ))";			
		$this->db->join($this->tbl_user.' '.'as t2', "(t2.fbid != {$user_fbid} AND  {$con})", 'left');
		$this->db->where($where);						
		if(!empty($search))	{					
			$searchwhere = "(t2.fullname like '%$search%' OR t1.message like '%$search%' OR  t1.sent_date like '%$search%') AND {$where}";	$this->db->where($searchwhere);	
		}			
		$this->db->where_not_in('t1.markasdelete',$user_fbid);			
		//$this->db->group_by('t1.recipient_id','t1.sender_id');
		
		$group = "IF(t1.sender_id > t1.recipient_id, t1.sender_id,t1.recipient_id),IF(t1.sender_id > t1.recipient_id, t1.recipient_id,t1.sender_id)";
		$this->db->group_by($group);
		/*$this->db->order_by('t1.msg_id');*/
		$query = $this->db->get();
								
		//return $result =  $query->result();
		//exit();
		
		$result =  $query->result();
		$events = array();			
		
		if(!empty($result)){				
			foreach($result as $row) 
			{										
				
				$newsenderval = $row->sender_id;					
				$newreciverval = $row->recipient_id;
				
				
								
				$msgstatus ="(CASE 
								WHEN  t1.sender_id = {$user_fbid} AND t1.msg_status = '1' THEN 'SENT' 
								WHEN  t1.sender_id = {$user_fbid} AND t1.msg_status = '2' THEN 'SEEN'									
								WHEN  t1.recipient_id = {$user_fbid} AND t1.msg_status = '1' THEN 'UNREAD'									
								WHEN  t1.recipient_id = {$user_fbid} AND t1.msg_status = '2' THEN 'READ'									
								END	) as msg_status";	
							
				$isuploadedfile = "(CASE WHEN t1.file_code !='' THEN '1' ELSE '0'  END ) as isuploadedfile";												
				$path = base_url().'getfile/';										
				$message = "(CASE WHEN t1.file_code !='' THEN CONCAT('$path','',t1.file_code) ELSE t1.message  END ) as message";
				
				$isMsgcreatebyyou = "(CASE WHEN t1.sender_id = {$user_fbid} THEN 1 ELSE 0 END ) as youcreateMsg";
				
				$this->db->select("t1.msg_id,{$isuploadedfile},{$message},{$isMsgcreatebyyou},DATE_FORMAT(t1.sent_date,'%Y-%m-%d %H:%i:%s %p') as sent_date,{$msgstatus}");			
				$this->db->join($this->tbl_user.' '.'as t2', "(t2.fbid != {$user_fbid} AND  {$con})", 'left');										
				$this->db->from($this->tbl_message.' '.'as t1');					
				$where = "((t1.sender_id = '$newsenderval' and t1.recipient_id = '$newreciverval') OR (t1.recipient_id = '$newsenderval' and t1.sender_id = '$newreciverval') )";					
				$this->db->where($where);					
				$this->db->where_not_in('t1.markasdelete',$user_fbid);
						
						if(!empty($search))
						{							
							$searchwhere = "(t2.fullname like '%$search%' OR t1.message like '%$search%' OR  t1.sent_date like '%$search%') AND {$where}";						
							$this->db->where($searchwhere);	
						}										
						$this->db->order_by('t1.sent_date','desc');					
						//$this->db->limit(1);				
						$query2 = $this->db->get();											
						if($user_fbid  == $row->sender_id && $user_fbid  != $row->recipient_id)
						{							
							$eventsArray['myfbid']  =  $row->sender_id;							
							$eventsArray['fiend_fbid']	 =  $row->recipient_id;
						}						
						else if($user_fbid  == $row->recipient_id && $user_fbid  != $row->sender_id)						
						{								
							$eventsArray['myfbid']	 =  $row->recipient_id;								
							$eventsArray['fiend_fbid']  =  $row->sender_id;						
						}						
						$eventsArray['friend_fullname']  =  $row->friend_fullname;						
						$eventsArray['friend_photo'] 	 =  $row->friend_photo;							
						$eventsArray['message']		 	 = 	$query2->result();
						
											  											
						$events[] = $eventsArray;						 							
			}										
			return $events;				
		}			
		return NULL;
		
			
	}
}