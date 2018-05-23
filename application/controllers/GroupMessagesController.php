<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');

class GroupMessagesController extends REST_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('RESTchat_group_model', 'chat_group');
        $this->load->library('form_validation');
    }

    //group chat list of user
    function group_chat_list_get() {
    	$fbid = $this->get('fbid');
    	if($fbid == null || $fbid == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[fbid] parameter is required';

    		$this->response($response);
    	}

    	$list = $this->chat_group->getChatGroupsListOfUser($fbid);
    	$response['status'] = 'success';
    	$response['group_chat_list'] = $list;
    	$this->response($response);
    }

    //users list of group chat
    function groupchat_user_list_get() {
    	$groupid = $this->get('groupid');
    	if($groupid == null || $groupid == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[groupid] parameter is required';

    		$this->response($response);
    	}

    	$list = $this->chat_group->getUserListOfGroupChat($groupid);
    	$response['status'] = 'success';
    	$response['groupchat_user_list'] = $list;
    	$this->response($response);
    }

    function groupchat_title_update_post() {
    	$data = [];
    	$data['fbid'] = $this->post('fbid');
    	$data['chat_group_id'] = $this->post('groupid');
    	$data['title'] = $this->post('title');
    	if($data['fbid'] == null || $data['fbid'] == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[fbid] parameter is required';

    		$this->response($response);
    	}
    	if($data['chat_group_id'] == null || $data['chat_group_id'] == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[groupid] parameter is required';

    		$this->response($response);
    	}
    	if($data['title'] == null || $data['title'] == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[title] parameter is required';

    		$this->response($response);
    	}
    	$result = $this->chat_group->updateGroupChatTitle($data);
    	$response['status'] = 'success';
    	$response['group_chat_id'] = $data['chat_group_id'];
    	$response['new_title'] = $data['title'];
    	$this->response($response);
    }

    function groupchat_send_msg_post() {
    	$data = [];
    	$data['fbid'] = $this->post('fbid');
    	$data['group_id'] = $this->post('groupid');
    	$data['message'] = $this->post('message');
    	if($data['fbid'] == null || $data['fbid'] == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[fbid] parameter is required';

    		$this->response($response);
    	}
    	if($data['group_id'] == null || $data['group_id'] == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[groupid] parameter is required';

    		$this->response($response);
    	}
    	if($data['message'] == null || $data['message'] == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[message] parameter is required';

    		$this->response($response);
    	}

    	$result = $this->chat_group->sendMessageToGroupChat($data);
    	$response['status'] = 'success';
    	$response['groupid'] = $data['group_id'];
    	$response['gc_message_id'] = $result;

    	$this->response($response); 
    }

   	function groupchat_add_member_post() {
   		$data = [];
   		$doneBy = $this->post('fbid');
   		$data['fbid'] = $this->post('fbid_toadd');
   		$data['chat_group_id'] = $this->post('groupid');
   		$data['state'] = 1;

   		if($doneBy == null || $doneBy == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[fbid] parameter is required';

    		$this->response($response);
    	}
   		if($data['fbid'] == null || $data['fbid'] == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[fbid_toadd] parameter is required';

    		$this->response($response);
    	}
    	if($data['chat_group_id'] == null || $data['chat_group_id'] == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[groupid] parameter is required';

    		$this->response($response);
    	}

    	$result = $this->chat_group->addUserToGroupChat($data,$doneBy);
    	$response['status'] = 'success';
    	$response['details'] = $data;

    	$this->response($response);
   	}

   	function groupchat_kick_member_post() {
   		$data = [];
   		$doneBy = $this->post('fbid');
   		$data['fbid'] = $this->post('fbid_tokick');
   		$data['chat_group_id'] = $this->post('groupid');
   		$data['state'] = 0;

   		if($doneBy == null || $doneBy == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[fbid] parameter is required';

    		$this->response($response);
    	}

   		if($data['fbid'] == null || $data['fbid'] == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[fbid_tokick] parameter is required';

    		$this->response($response);
    	}
    	if($data['chat_group_id'] == null || $data['chat_group_id'] == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[groupid] parameter is required';

    		$this->response($response);
    	}
    

    	$result = $this->chat_group->kickUserFromGroupChat($data,$doneBy);
    	$response['status'] = 'success';
    	$response['details'] = $data;

    	$this->response($response);
   	}

   	function groupchat_member_leave_post() {
   		$data = [];
   		$data['fbid'] = $this->post('fbid');
   		$data['chat_group_id'] = $this->post('groupid');
   		$data['state'] = 0;
   		if($data['fbid'] == null || $data['fbid'] == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[fbid] parameter is required';

    		$this->response($response);
    	}
    	if($data['chat_group_id'] == null || $data['chat_group_id'] == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[groupid] parameter is required';

    		$this->response($response);
    	}

    	$result = $this->chat_group->userLeaveFromGroupChat($data);
    	$response['status'] = 'success';
    	$response['details'] = $data;

    	$this->response($response);
   	}

   	function groupchat_messages_get() {
   		$data = [];
    	$response = [];

    	$data['group_id'] = $this->get('groupid');
    	if($data['group_id'] == null || $data['group_id'] == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[groupid] parameter is required';

    		$this->response($response);
    	}

    	$result = $this->chat_group->getGroupChatMessages($data['group_id']);
    	$response['status'] = 'success';
    	$response['groupchat_messages'] = $result;
    	$this->response($response);
   	}

    function create_group_chat_post() {
    	$data = [];
    	$response = [];

    	$data['fbid'] = $this->post('fbid');
    	$data['title'] = $this->post('title');
    	$data['description'] = $this->post('description');
    	$data['tags'] = $this->post('tags');

    	if($this->post('fbid') == null || $this->post('fbid') == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[fbid] parameter is required';

    		$this->response($response);
    	}

    	if($this->post('title') == null || $this->post('title') == '') {
    		$response['status'] = 'fail';
    		$response['message'] = '[title] parameter is required';

    		$this->response($response);
    	}
    	$titleExist = $this->chat_group->validateChatGroupTitle($data['fbid'], $data['title']);
    	if($titleExist) {
    		$response['status'] = 'fail';
    		$response['message'] = 'group title already exist for this user';
    		$this->response($response);
    	} 
		$groupChatId = $this->chat_group->createChatGroup($data);
		$response['status'] = 'success';
		$response['group_chat_id'] = $groupChatId;
		$response['message'] = 'Success creating a group chat';

		$this->response($response);
    }
}