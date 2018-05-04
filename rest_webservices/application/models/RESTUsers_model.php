<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RESTUsers_model extends CI_Model{
	
	  private $tbl_user = 'tbl_user';	  
	  private $tbl_friendship = 'tbl_friendship';	  
	  private $tbl_friendship_block = 'tbl_friendship_block';
	  private $tbl_friendship_favorite = 'tbl_friendship_favorite';	  
		
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
		  /*Load the cookie */
		 $this->load->helper('cookie');
	}
	
	
	
	public function checkifuserxistin_userdb($user_fbid)
	{
		$this->db->from('tbl_user');		
		$this->db->where('fbid', $user_fbid);		
		$query = $this->db->get();		
		return count($query->result());	
	
	}			public function checkifyoublockthisuser($attendee_id,$invite_by)	{		$this->db->from('tbl_friendship_block');				$this->db->where('user_fbid', $attendee_id);		$this->db->where('friend_fbid', $invite_by);				$this->db->where('blocking_status', 1);				$query = $this->db->get();				return count($query->result());			}
		
	public function check_user($field)
	{
		$this->db->insert($this->tbl_user,$field);
		$id	= $this->db->insert_id();
		return $id;	
	}		
	
	public function checkifuserexist($fbid)
	{				
		
		$this->db->from($this->tbl_user);		
		$this->db->where('fbid', $fbid);		
		$query = $this->db->get();		
		return count($query->result());	
	}
	
	
	public function update_user($field,$condition)
	{
		$this->db->update($this->tbl_user,$field,$condition);
		return $this->db->affected_rows();
	}
	
	function get_user_list($fbid)
	{
		if(empty($fbid))
		{
			$query = $this->db->get($this->tbl_user);
			if ($query)
			{
				return $query->result();
				exit();
			}
		}
		else
		{
			 $query = $this->db->get_where($this->tbl_user, array("fbid" => $fbid));
			 if ($query) 
			 {
				return $query->row();
				exit();
			 }
			
		}
		
        return NULL;
    }
	
	
	function checkifalreadyfriend($user_fbid,$friend_fbid)
	{
		
		$where = "(user_fbid = '$user_fbid'  AND friend_fbid = '$friend_fbid' AND (relationship_status = 1 OR relationship_status = 0) ) ";
		$where .= "OR (user_fbid = '$friend_fbid'  AND friend_fbid = '$user_fbid' AND (relationship_status = 1 OR relationship_status = 0) ) ";
		
		
		$this->db->from($this->tbl_friendship);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result();
		
		
	}
	
	
 
	function addfriendrequest($data)	
	{		
	
		$this->db->insert($this->tbl_friendship,$data);		
		$id	= $this->db->insert_id();		
		return $id;		
	}			
	
	function blokeduser($data)	{		
	
	/* 	$this->db->insert($this->tbl_friendship_block,$data);		
		$id	= $this->db->insert_id();		
		return $id;	 */

		$this->db->from($this->tbl_friendship_block);
		$this->db->where('user_fbid', $data['user_fbid']);
		$this->db->where('friend_fbid', $data['friend_fbid']);
		$query = $this->db->get();
		
		if(count($query->result()) == 0){
			$this->db->insert($this->tbl_friendship_block,$data);		
			$id	= $this->db->insert_id();		
			return $id;
		}else{
			
			$newdata = array();
			$newdata['update_date']  		= gmdate("Y-m-d h:i:s");
			$newdata['blocking_status']  	= 1;
			
			$this->db->where('user_fbid', $data['user_fbid']);
			$this->db->where('friend_fbid', $data['friend_fbid']);
			$this->db->update($this->tbl_friendship_block, $newdata);
			return $this->db->affected_rows();
		}		

		
	}		
	
	function unblocked($data)	{						
		$condition =  array('user_fbid' => $data['user_fbid'],'friend_fbid' => $data['friend_fbid']);				
		$this->db->update($this->tbl_friendship_block,$data,$condition);		
		return $this->db->affected_rows();			
   }
   
 			
   
   function addfavoriteuser($data)
   {		
		

		$this->db->from($this->tbl_friendship_favorite);
		$this->db->where('user_fbid', $data['user_fbid']);
		$this->db->where('friend_fbid', $data['friend_fbid']);
		$query = $this->db->get();
		
		if(count($query->result()) == 0){
			$this->db->insert($this->tbl_friendship_favorite,$data);		
			$id	= $this->db->insert_id();		
			return $id;
		}else{
			
			$newdata = array();
			$newdata['update_date']  		= gmdate("Y-m-d h:i:s");
			$newdata['favorite_status']  		= 1;
			
			$this->db->where('user_fbid', $data['user_fbid']);
			$this->db->where('friend_fbid', $data['friend_fbid']);
			$this->db->update($this->tbl_friendship_favorite, $newdata);
			return $this->db->affected_rows();
		}		



		
	}				
	
	function unfavoriteuser($data)	{						
	$condition =  array('user_fbid' => $data['user_fbid'],'friend_fbid' => $data['friend_fbid']);
	$this->db->update($this->tbl_friendship_favorite,$data,$condition);		
	return $this->db->affected_rows();			
   }			
   
   function userfavoritelist($user_fbid)
   {		 
   
	   $query = $this->db->get_where($this->tbl_friendship_favorite, array("user_fbid" => $user_fbid,'favorite_status'=>1));		 
		if ($query) {			
			return $query->result();			
			exit();		 
		}        
		return NULL;    
   }

	

	
	
	function cancelfriendrequest($data)	{						
	
		$condition =  array('friendshipcode' => $data['friendshipcode'],'user_fbid' => $data['user_fbid']);				
		$this->db->update($this->tbl_friendship,$data,$condition);		
		return $this->db->affected_rows();
	}		
	
	function approvedfriendrequest($data) {
		$condition =  array('friendshipcode' => $data['friendshipcode'],'friend_fbid' => $data['friend_fbid']	);				
		$this->db->update($this->tbl_friendship,$data,$condition);		
		return $this->db->affected_rows();
	}		
	
	
	function declinedfriendrequest($data)	{
		
		$condition =  array('friendshipcode' => $data['friendshipcode'],'friend_fbid' => $data['friend_fbid']	);
		$this->db->update($this->tbl_friendship,$data,$condition);		
		return $this->db->affected_rows();
	}
	
	function userfriendlist($user_fbid)
	{		 
   
	   $query = $this->db->get_where($this->tbl_friendship, array("user_fbid" => $user_fbid,'relationship_status'=>1));		 
		if ($query) {			
			return $query->result();			
			exit();		 
		}        
		return NULL;    
	}
	
	
   function userblockedlist($user_fbid,$fullname)
   {		 
			

		
			$this->db->select("t2.*,CASE WHEN (t1.blocking_status = 1) THEN 'blocked' ELSE 'unblocked' END as blocking_status,t1.blocked_date");
			$this->db->from($this->tbl_friendship_block.' '.'as t1');
			$this->db->join($this->tbl_user.' '.'as t2', 't1.friend_fbid = t2.fbid');
			$this->db->where('t1.user_fbid', $user_fbid);
			$this->db->where('t1.blocking_status', 1);
			$where1 = "t2.fullname like '%$fullname%'";
			$this->db->where($where1);
				
			$this->db->group_by(array("t1.user_fbid", "t1.friend_fbid"));
			$query = $this->db->get();
			
			if($query) 
			{		
					$result = $query->result();
					return $result;
					
					exit();
				 
			} 

			return NULL;
   }	


	public function SearchAlluserinshindy($user_fbid,$fullname,$filterby,$applied_filter)
	{
			$array_zipcode = array();
		
			//  filter applied distance preference 
			if(!empty($applied_filter['distance']))
			{
				//$zipcode_data = '90001';
				
				$condition1 = array('fbid' => $user_fbid);
				$query = $this->db->get_where('tbl_user',$condition1);		 
				$zipcode_data = $query->row();
				
		
				$condition = array('zipcode' => $zipcode_data->zipcode);
				$query = $this->db->get_where('zipcode',$condition);		 
				$zipcode = $query->row();
				
				// appllied this function if the zipcode is registered on zipcode table
				if(count($zipcode) > 0)
				{
					
					$dis = array(
						1=>20, 
						2=>40, 
						3=>50, 
						4=>60, 
						5=>80, 
						6=>120, 
						7=>140, 
						8=>160, 
						9=>180 
					);
					
						
						
					
					  if (array_key_exists($applied_filter['distance'],$dis))
					  {
						$distance = $dis[$applied_filter['distance']];
					  }
					  else 
					  {
							$distance = 50;
					  }
					
					
 
					
					$sql = "SELECT zipcode, ( 3959 * acos( cos( radians(".$zipcode->latitude.") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$zipcode->longitude.") ) + sin( radians(".$zipcode->latitude.") ) * sin( radians( latitude ) ) ) ) AS distance FROM zipcode GROUP BY zipcode,distance HAVING distance < $distance ORDER BY zipcode,distance";
					
					
					$query = $this->db->query($sql);
					$result =  $query->result();
					$datax  = array();
				
					foreach($result as $row) 
					{
						 $datax['zipcode'] = $row->zipcode;
						 $datax['distance'] = $row->distance;
						
						array_push($array_zipcode,$datax);
					}
					
					//$this->db->where_in('main.zipcode',$array_zipcode);	
				}
				else
				{
					return false;
					exit();
				}
				//print_r(array_column($array_zipcode, 'zipcode')); 
				
			}
			// end of distance
			
			
			//exit();
			
			
			$select	 = "main.*";
			$select .= ",CASE WHEN (favorite.id IS NOT NULL) THEN '1' ELSE '0' END as markasfavorite";
			//$select .= ",CASE WHEN (friend.id IS NOT NULL) THEN '1' ELSE '0' END as markasfriend";
			

			
			$where = "main.fbid NOT IN ( SELECT block.friend_fbid FROM tbl_friendship_block as block where block.user_fbid = '$user_fbid' AND block.friend_fbid = main.fbid AND block.blocking_status = 1 ) AND main.fbid != '$user_fbid' AND main.fullname like '%$fullname%' ";
			
			
			
			$where_favorite = "main.fbid = favorite.friend_fbid AND favorite.favorite_status = 1 and favorite.user_fbid = '$user_fbid'";
			
			//$where_friend 	= "(main.fbid = friend.friend_fbid AND friend.relationship_status = 1 and friend.user_fbid = '$user_fbid')";
			//$where_friend  .= "OR (main.fbid = friend.user_fbid AND friend.relationship_status = 1 and friend.friend_fbid = '$user_fbid')";
			
			$this->db->select($select);
			$this->db->from('tbl_user as main');
			$this->db->join('tbl_friendship_favorite as favorite',$where_favorite,'left');

			//$this->db->join('tbl_friendship as friend',$where_friend,'left');
			$this->db->where($where);
	
			/* if($filterby == "friend")
			{
				$this->db->where($where_friend);
			} */
			
			if($filterby == "favorite")
			{
				$this->db->where($where_favorite);
			}
			
			
		
			//  filter applied distance preference
			if(!empty($array_zipcode)  )
			{				
					$this->db->where_in('main.zipcode',array_column($array_zipcode, 'zipcode'));	

			}
			// end of distance
			
		
		

			//  filter applied gender preference
			if(!empty($applied_filter['religion']) || $applied_filter['religion'] != 0 )
			{				
					$this->db->where('main.religion', $applied_filter['religion']);

			}
			// end of gender
			
			
			//  filter applied gender preference
			if(!empty($applied_filter['gender_pref']))
			{
				if($applied_filter['gender_pref'] != 0)
				{
					$this->db->where('main.gender', $applied_filter['gender_pref']);
				}
				else
				{
					$this->db->where_in('main.gender', array('1','2','0'));
				}
			}
			// end of gender
			
			//  filter applied age between min age and max age
			if(!empty($applied_filter['min_age']))
			{
				$this->db->where('main.age >=', $applied_filter['min_age']);
				
			}
			
			if(!empty($applied_filter['max_age']))
			{
				$this->db->where('main.age <=', $applied_filter['max_age']);
				
			}
			// end of age 
			

			
			$query = $this->db->get();
			$result =  $query->result();
			
		
			$userdetail = array();
			foreach($result as $row) {
					 
					  
					  $userArray['id'] 		=  $row->id;
					  $userArray['fbid'] 	=  $row->fbid;
					  $userArray['fullname'] =  $row->fullname;
					  $userArray['photo'] 	  =  $row->photo;
					  $userArray['email_address'] = $row->email_address;
					  $userArray['about'] =  $row->about;
					  $userArray['age'] =  $row->age;
					  $userArray['age_pref'] =  $row->age_pref;
					  $userArray['religion'] =  $row->religion;
					  $userArray['gender'] =  $row->gender;
					  $userArray['gender_pref'] =  $row->gender_pref;
					  $userArray['address'] =  $row->address;
					  $userArray['distance'] =  $row->distance;
					  $userArray['zipcode'] =  $row->zipcode;
					  $userArray['availability'] =  $row->availability;
					  $userArray['joineddate'] =  $row->joineddate;
					  $userArray['updatedate'] =  $row->updatedate;
					  $userArray['markasfavorite'] =  $row->markasfavorite;
					  
					  	if(!empty($array_zipcode)  )
						{				
							$userArray['distance_range'] = $this->valuelist($array_zipcode,$row->zipcode);	

						}
						
						
					  
					 $userdetail[] = $userArray;
					 
					//$userdetail[] = array_multisort($userArray['distance_range'], SORT_ASC);
					 
			} 
			
			return $userdetail;
			
			exit();
		
	}
	
	function valuelist($array, $array_column) 
	{
		$results = [];

		foreach ($array as $row) {
			if($array_column == $row['zipcode'])
			{
				$results = $row['distance'];
			}
		}

		return $results;
	}
	
		
	
}
?>