<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RESTchat_group_model extends CI_Model {
	public function __construct() {

		parent::__construct();
		$this->load->database();
		  /*Load the cookie */
	}

	public function createChatGroup($data) {
		$this->db->insert('tbl_chat_groups',$data);
		$result = $this->db->insert_id();
		$data2 = [];
		$data2['fbid'] = $data['fbid'];
		$data2['chat_group_id'] = $result;
		$data2['state'] = 1;
		$this->db->insert('tbl_chat_group_users', $data2);
		$data3 = [];
		$data3['fbid'] = $data['fbid'];
		$data3['done_by_fbid'] = $data['fbid'];
		$data3['group_id'] = $result;
		$data3['cgus_id'] = 1;
		$this->db->insert('tbl_chat_group_actions', $data3);
		return $result;
	}

	public function sendMessageToGroupChat($data) {
		$this->db->insert('tbl_chat_group_messages',$data);
		$result = $this->db->insert_id();
		return $result;
	}

	public function addUserToGroupChat($data,$doneBy) {
		$result = $this->db->insert('tbl_chat_group_users',$data);
		$data2 = [];
		$data2['group_id'] = $data['chat_group_id'];
		$data2['fbid'] = $data['fbid'];
		$data2['done_by_fbid'] = $doneBy;
		$data2['cgus_id'] = 2;
		$this->db->insert('tbl_chat_group_actions', $data2);
		return $result;
	}

	public function validateChatGroupTitle($fbid,$title) {
		$this->db->select('title');
		$this->db->from('tbl_chat_groups');
		$this->db->where('title', $title);
		$this->db->where('fbid', $fbid);
		$query = $this->db->get();
		$result = $query->result();
		if(count($result) > 0) {
			return true;
		} 
		return false;
	}

	public function getChatGroupsListOfUser($fbid) {
		$this->db->select('*');
		$this->db->from('tbl_chat_group_users');
		$this->db->where('fbid', $fbid);
		$this->db->where('state', 'acitve');
		$query = $this->db->get();
		$result = $query->result();

		return $result;
	}

	public function getUserListOfGroupChat($groupid) {
		$this->db->select('*');
		$this->db->from('tbl_chat_group_users');
		$this->db->where('chat_group_id', $groupid);
		$this->db->where('state', 1);
		$query = $this->db->get();
		$result = $query->result();

		return $result;
	}

	public function updateGroupChatTitle($data) {
		$this->db->where('chat_group_id', $data['chat_group_id']);
		$this->db->where('fbid', $data['fbid']);
		$update = [];
		$update['title'] = $data['title'];
		$result = $this->db->update('tbl_chat_groups',$update);
		return $result;
	}

	public function getGroupChatMessages($groupid) {
		$this->db->select('*');
		$this->db->from('tbl_chat_group_messages');
		$this->db->where('group_id', $groupid);
		$query = $this->db->get();
		$result = $query->result();

		return $result;
	}

	public function kickUserFromGroupChat($data, $doneBy) {
		$data2 = [];
		$data2['group_id'] = $data['chat_group_id'];
		$data2['fbid'] = $data['fbid'];
		$data2['done_by_fbid'] = $doneBy;
		$data2['cgus_id'] = 3;
		$this->db->insert('tbl_chat_group_actions', $data2);
		$data3 = [];
		$data3['state'] = 0;
		$this->db->where('chat_group_id', $data['chat_group_id']);
		$this->db->where('fbid', $data['fbid']);
		$this->db->update('tbl_chat_group_users', $data3);
	}

	public function userLeaveFromGroupChat($data) {
		$data2 = [];
		$data2['group_id'] = $data['chat_group_id'];
		$data2['fbid'] = $data['fbid'];
		$data2['done_by_fbid'] = $data['fbid'];
		$data2['cgus_id'] = 4;
		$this->db->insert('tbl_chat_group_actions', $data2);
		$data3 = [];
		$data3['state'] = 0;
		$this->db->where('chat_group_id', $data['chat_group_id']);
		$this->db->where('fbid', $data['fbid']);
		$this->db->update('tbl_chat_group_users', $data3);
	}
}