<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RESTgroup_model extends CI_Model{
	
	
	 private $tbl_group 			= 'tbl_group';
	 private $tbl_group_message 	= 'tbl_group_message';
	 private $tbl_group_member 		= 'tbl_group_member';
	 private $tbl_user 		= 'tbl_user';
	 private $val = array(1 => 'active', 2=> 'leave', 3=> 'blocked');
	
	public function __construct()
	{

		parent::__construct();
		$this->load->database();
		  /*Load the cookie */

	}
	
	
	
	public function Sendgroup_message($field)
	{
		$this->db->insert($this->tbl_group_message,$field);
		$id	= $this->db->insert_id();
		return $id;	
	}
	
	function listmessageofgroup($groupid)
	{
		$this->db->select("t1.*,t2.title,t3.fullname");
		$this->db->from($this->tbl_group_message.' '.'as t1');
		$this->db->join($this->tbl_group.' '.'as t2', 't1.groupid = t2.id', 'left');
		$this->db->join($this->tbl_user.' '.'as t3', 't1.sender_fbid = t3.fbid', 'left');
		$this->db->where('t1.groupid', $groupid);
		$query = $this->db->get();
		$result =  $query->result();
		return $result;
		
	}
	
	public function add_group($field)
	{
		$this->db->insert($this->tbl_group,$field);
		$id	= $this->db->insert_id();
		return $id;	
	}
	
	
	public function update_group($field,$condition)
	{
		$this->db->update($this->tbl_group,$field,$condition);
		return $this->db->affected_rows();
	}
	
	public function grouplist($param_search)
	{
		
		if(empty($param_search))
		{
			
			
			$array = array();
			$this->db->select("*");
			$this->db->from($this->tbl_group);
			$this->db->where('bool',1);
			$query = $this->db->get();
			$array = $query->result();	
			return $array;
			exit();
			
			
		}
		else
		{
			
			$array = array();
			$this->db->select("*");
			$this->db->from($this->tbl_group);
			$this->db->where('bool',1);	
			$where = "(createdby = '$param_search' || code = '$param_search' || title LIKE '%$param_search%' )";
			$this->db->where($where);	
			
			$query = $this->db->get();
			$array = $query->result();	
			return $array;
			exit();
			
		}
		
        return NULL;
		
	}
	
	public function joingroup($field)
	{
		$this->db->insert($this->tbl_group_member,$field);
		$id	= $this->db->insert_id();
		return $id;	
	}
	
	public function checkifcodeexist($code)
	{
		$this->db->from($this->tbl_group);		
		$this->db->where('code', $code);		
		$query = $this->db->get();		
		//return count($query->result());	
		return $query->result();
		
	}
	
	
	public function checkifgroupexist($groupid)
	{
		$this->db->from($this->tbl_group);		
		$this->db->where('id', $groupid);		
		$query = $this->db->get();		
		return count($query->result());	
		
	}
	
	
	
	
	
	
	public function checkifuserisjoinedingroup($user_fbid,$groupid)
	{
		$this->db->from($this->tbl_group_member);		
		$this->db->where('user_fbid', $user_fbid);
		$this->db->where('groupid', $groupid);
		$this->db->where('member_status', 1);	
		$query = $this->db->get();		
		return count($query->result());	
		
	}
	
	public function checkifuserjoined($user_fbid,$groupid)
	{
		$this->db->from($this->tbl_group_member);		
		$this->db->where('user_fbid', $user_fbid);
		$this->db->where('groupid', $groupid);
		$where = '(member_status="1" or member_status = "3")';
		$this->db->where($where);		
		$query = $this->db->get();		
		return count($query->result());	
		
	}
	
	public function leavegroup($field,$condition)
	{
		$this->db->update($this->tbl_group_member,$field,$condition);
		return $this->db->affected_rows();
	}
	
	
	public function blockuseringroup($field,$condition)
	{
		$this->db->update($this->tbl_group_member,$field,$condition);
		return $this->db->affected_rows();
	}
	
	public function unblockusergroup($field,$condition)
	{
		$this->db->update($this->tbl_group_member,$field,$condition);
		return $this->db->affected_rows();
	}
	
	
	public function grouplistactivemember($groupid)
	{
		
				
		$this->db->select("t1.*,t2.title");
		$this->db->from($this->tbl_group_member.' '.'as t1');
		$this->db->join($this->tbl_group.' '.'as t2', 't1.groupid = t2.id', 'left');
		$this->db->where('t1.member_status', 1);
		$this->db->where('t1.groupid', $groupid);
		$query = $this->db->get();
		//return $query->result();
		$result =  $query->result();
		
		$events = array();
		foreach($result as $row) {
			  
			 
			  $eventsArray['id'] 		=  $row->id;
			  $eventsArray['groupcode'] =  $row->groupcode;
			  $eventsArray['user_fbid'] =  $row->user_fbid;
			  $eventsArray['title'] 	  =  $row->title;
			  $eventsArray['member_status'] = $this->val[$row->member_status];
			  $eventsArray['joindate'] =  $row->joindate;
			  $eventsArray['leavedate'] =  $row->leavedate;
			  $eventsArray['blockdate'] =  $row->blockdate;
				
			  $events[] = $eventsArray;
			 
		}
	
		return $events;
		
	}
	
	public function blockedmemberofgroup($groupid)
	{
		
				
		$this->db->select("t1.*,t2.title");
		$this->db->from($this->tbl_group_member.' '.'as t1');
		$this->db->join($this->tbl_group.' '.'as t2', 't1.groupid = t2.id', 'left');
		$this->db->where('t1.member_status', 3);
		$this->db->where('t1.groupid', $groupid);
		$query = $this->db->get();
		//return $query->result();
		$result =  $query->result();
		
		$events = array();
		foreach($result as $row) {
			  
			 
			  $eventsArray['id'] 		=  $row->id;
			  $eventsArray['groupcode'] =  $row->groupcode;
			  $eventsArray['user_fbid'] =  $row->user_fbid;
			  $eventsArray['title'] =  $row->title;
			  $eventsArray['member_status'] = $this->val[$row->member_status];
			  $eventsArray['joindate'] =  $row->joindate;
			  $eventsArray['leavedate'] =  $row->leavedate;
			  $eventsArray['blockdate'] =  $row->blockdate;
				
			  $events[] = $eventsArray;
			 
		}
	
		return $events;
		
	}
	
	public function leavedmemberofgroup($groupid)
	{
		
				
		$this->db->select("t1.*,t2.title");
		$this->db->from($this->tbl_group_member.' '.'as t1');
		$this->db->join($this->tbl_group.' '.'as t2', 't1.groupid = t2.id', 'left');
		$this->db->where('t1.member_status', 2);
		$this->db->where('t1.groupid', $groupid);
		$query = $this->db->get();
		//return $query->result();
		$result =  $query->result();
		
		$events = array();
		foreach($result as $row) {
			  
			 
			  $eventsArray['id'] 		=  $row->id;
			  $eventsArray['groupcode'] =  $row->groupcode;
			  $eventsArray['user_fbid'] =  $row->user_fbid;
			  $eventsArray['title'] =  $row->title;
			  $eventsArray['member_status'] = $this->val[$row->member_status];
			  $eventsArray['joindate'] =  $row->joindate;
			  $eventsArray['leavedate'] =  $row->leavedate;
			  $eventsArray['blockdate'] =  $row->blockdate;
				
			  $events[] = $eventsArray;
			 
		}
	
		return $events;
		
	}
	
	
	

}