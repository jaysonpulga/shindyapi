<!doctype html>
<html>
<head>
	<title>Web Portal Url Based Web Service</title>
	<link rel="stylesheet" href="style.css" />
	<!-- jquery 2.1.1 -->
	<script src="javascript/jquery-2.1.1.min.js"></script>		
	<!-- custom script -->
	<script src="javascript/custom_script.js"></script>
	
	 <!-- Bootstrap 3.3.6 -->
	  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/javascript/style.css">
	<script src="<?php echo base_url(); ?>assets/javascript/jquery-2.1.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/javascript/custom_script.js"></script>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	

	
</head>
<body>

	<div id="header">
		
	</div>
	
	<div id="subheader">
		 USER DOCUMENTATION
	</div>

	<div id="container">

		
		<strong>Methods:</strong><br>
		1) <a id="3" class="accordion_" href="#">User</a><br />
		2) <a id="4" class="accordion_" href="#">Request Friend</a><br />
		3) <a id="5" class="accordion_" href="#">Block Friend</a><br />
		4) <a id="6" class="accordion_" href="#">Favorite Friend </a><br /><br>	
		<!-- <a  href="http://shindygo.com/rest_webservices/eventdocumentation" >ws_event - event api documentation</a><br />-->
		
		Other Documentation:<br>
		<a   href="http://shindygo.com/rest_webservices/eventdocumentation">Event Documentation</a><br />
		<a   href="http://shindygo.com/rest_webservices/groupdocumentation">Group Documentation</a><br />
		<a   href="http://shindygo.com/rest_webservices/messagedocumentation">Message Documentation</a><br />
		<br />
		
			<div id="3" class="hidden_create_employee accordion"><b>User</b></div>
				<div class="3">
					<table>
					<th>Parameters</th><th>Sample Value</th>
					<tr><td>fullname *</td><td>Danny Smith</td></tr>
					<tr><td>email_address *</td><td>dannysmith@gmail.com</td></tr>
					<tr><td>fbid*</td><td>user facebook id</td></tr>
					<tr><td>Photo</td><td>url of photo</td></tr>
					<tr><td>about</td><td>i am born and raised Alabama boy.</td></tr>
					<tr><td>age</td><td>26</td></tr>
					<tr><td>age_pref</td><td>10</td></tr>
					<tr><td>religion</td><td>[0=none,1=Catholic,2=Protestant,3=Latter Day Saint(mormon),4=7th Day Adventist]</td></tr>
					<tr><td>gender</td><td>[1=male,2=female]</td></tr>
					<tr><td>gender_pref</td><td>[0=both,1=male,2=female]</td></tr>
					<tr><td>address</td><td>Alabama</td></tr>
					<tr><td>distance</td><td>[1=20miles,2=40miles,3=50miles,4=60miles,5=80miles,6=120miles,7=140miles,8=160miles,9=180miles]</td></tr>										<tr><td>allo_anonymous_invite</td><td>[0=none,1=yes/allow]</td></tr>					
					<tr><td>zipcode</td><td>90210</td></tr>
					<tr><td>availability</td><td>Available/Unavailable</td></tr>					
					<tr><td>api-key</td><td>api key value</td></tr>					
					
					</table>
					
					<div id="blue_box">
						This method will be used to create, update or get user details from webservice. it accepts all types
						of request e.g POST, GET 
					</div>
				
						<b>Calling the method</b><br /><br>
						1) GET&nbsp;: User List</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/userlist/api-key/xxxxxxxxx"><?php  echo base_url(); ?>restapicontroller/userlist/api-key/xxxxxxxxx</a>
						<br><br>
						2) GET&nbsp;: User By Id</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/userlist/fbid/{facebookid}/api-key/xxxxxxxxx"><?php  echo base_url(); ?>restapicontroller/userlist/fbid/{facebookid}/api-key/xxxxxxxxx</a>
						<br><br>
						3) POST&nbsp;: Add/Check User</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/check_user"><?php  echo base_url(); ?>restapicontroller/check_user</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*fbid - facebook id <br>
							
						</div>
						<br>
						4) POST&nbsp;: Update User</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/update_user"><?php  echo base_url(); ?>restapicontroller/update_user</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*fbid - facebook id <br>
							
						</div>
						<br><br>
						
						5) POST&nbsp;: Search All Users</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/SearchAlluserinshindy"><?php  echo base_url(); ?>restapicontroller/SearchAlluserinshindy</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*user_fbid - fbid of user <br>
							filterby - search by friend or favorite or all users.<br>
							&nbsp;&nbsp;&nbsp;->filterby = "friend" , return all friend in shindy<br>
							&nbsp;&nbsp;&nbsp;->filterby = "favorite", return all favorite on shindy <br>
							&nbsp;&nbsp;&nbsp;->filterby = "", return all users on shindy <br>
							fullname - name of user to make more specific for searching a user <br>
							
							
							<br>
							<p><b>Searching Filter Values</b></p>
							distance  =  input value  for searching <br>
							<div style='margin-left:20px'>
							[ <br>
							1=20miles, <br>
							2=40miles, <br>
							3=50miles, <br>
							4=60miles, <br>
							5=80miles, <br>
							6=120miles, <br>
							7=140miles, <br>
							8=160miles, <br>
							9=180miles  <br>
							] 
							</div>
							<br>
							religion =   input value for searching  <br>
							<div style='margin-left:20px'>
							[  <br>
							0=none, <br>
							1=Catholic, <br>
							2=Protestant, <br>
							3=Latter Day Saint(mormon), <br>
							4=7th Day Adventist] <br>
							</div>
							<br>
							gender_pref =  input value  for searching  <br>
							<div style='margin-left:20px'>
							[ <br>
							0=both, <br>
							1=male, <br>
							2=female <br>
							] 
							</div>
							<br>
							min_age ->  minimum age of user<br>
							max_age ->  maximun age of user<br>
							
						</div>
						<br>
						
						<!--
						6) POST&nbsp;: Search All Friends</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/userfriendlist"><?php  echo base_url(); ?>restapicontroller/userfriendlist</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*user_fbid - fbid of user <br>
	
							
						</div>
						<br>
						
						
						7) POST&nbsp;: Search All Favorite</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/userfavoritelist"><?php  echo base_url(); ?>restapicontroller/userfavoritelist</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*user_fbid - fbid of user <br>
							
							
						</div>
						<br>
						-->
						
						<br /><br />
							
						
					<table>
					<th colspan='2'>Database  Structure</th>
					<tr><td><b>Data fields</b></td><td><b>Datatype/Value</b></td></tr>
					<tr><td>fullname</td><td>varchar(155)</td></tr>
					<tr><td>photo</td><td>longtext</td></tr>
					<tr><td>email_address</td><td>varchar(155)</td></tr>
					<tr><td>about</td><td>varchar(250</td></tr>
					<tr><td>age</td><td>int(3)</td></tr>
					<tr><td>age_pref</td><td>int(3)</td></tr>
					<tr><td>religion</td><td>varchar(100)</td></tr>
					<tr><td>gender_pref</td><td>varchar(6)</td></tr>
					<tr><td>address</td><td>longtext</td></tr>
					<tr><td>distance</td><td>varchar(50)</td></tr>
					<tr><td>zipcode</td><td>int(20)</td></tr>
					<tr><td>availability</td><td>varchar(50)</td></tr>
					
					</table>	
					
				</div>
				
			<div id="4" class="hidden_request_friend accordion"><b>Request Friend</b></div>
				<div class="4">
					<table>
					<th>Parameters</th><th>Sample Value</th>
				
					<tr><td>user_fbid</td><td>1234567</td></tr>
					<tr><td>friend_fbid</td><td>56789123</td></tr>
					<tr><td>friendshipcode</td><td>generated code upon creating request</td></tr>
					<tr><td>api-key</td><td>api key value</td></tr>					
					</table>
					
					<div id="blue_box">
						This method will be used to create, update or get user details from webservice. it accepts all types
						of request e.g POST, GET 
					</div>
				
						<b>Calling the method</b><br /><br>
						
						1) POST&nbsp;: Add Friend Request</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/addfriendrequest"><?php  echo base_url(); ?>restapicontroller/addfriendrequest</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*user_fbid - who send friend request<br>
							*friend_fbid - receiver of friend request
						</div>
						
						<br>
						2) POST&nbsp;: Cancel Friend Request</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/cancelfriendrequest"><?php  echo base_url(); ?>restapicontroller/cancelfriendrequest</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*user_fbid - cancel the friend request<br>
							*friendshipcode - unique code , need for updating the request
						</div>
						
						<br />
						3) POST&nbsp;: Declined Friend Request</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/declinedfriendrequest"><?php  echo base_url(); ?>restapicontroller/declinedfriendrequest</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*friend_fbid - decline the friend request<br>
							*friendshipcode - unique code , need for updating the request
						</div>
						<br>
						
						4) POST&nbsp;: Approved Friend Request</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/approvedfriendrequest"><?php  echo base_url(); ?>restapicontroller/approvedfriendrequest</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*friend_fbid - approved the friend request<br>
							*friendshipcode - unique code , need for updating the request
						</div>
						
						<br /><br />
								
				</div>	
				
				
				
		<div id="5" class="hidden_block_friend accordion"><b>Block Friend</b></div>
				<div class="5">
					<table>
					<th>Parameters</th><th>Sample Value</th>
				
					<tr><td>user_fbid</td><td>1234567</td></tr>
					<tr><td>friend_fbid</td><td>56789123</td></tr>
					<tr><td>api-key</td><td>api key value</td></tr>					
					</table>
					
					<div id="blue_box">
						This method will be used to create, update or get user details from webservice. it accepts all types
						of request e.g POST, GET 
					</div>
				
						<b>Calling the method</b><br /><br>
						
						1) POST&nbsp;: Block Friend/User</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/blokeduser"><?php  echo base_url(); ?>restapicontroller/blokeduser</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*user_fbid - who made this action<br>
							*friend_fbid - user/friend who want to block
						</div>
						
						<br>
						2) POST&nbsp;: Unblock Friend/User</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/unblocked"><?php  echo base_url(); ?>restapicontroller/unblocked</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*user_fbid - who made this action<br>
							*friend_fbid - user/friend who want to unblock<br>
							
						</div>
	
						<br />
						3) POST&nbsp;: All blocked Friend/User</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/userblockedlist"><?php  echo base_url(); ?>restapicontroller/userblockedlist</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> use for fetching the record of blocked  users<br>
							*user_fbid - who made this action<br>
							fullname - name of user to make more specific for searching a user <br>
							
						</div>
						<br /><br />
								
				</div>			
																
			
		<div id="6" class="hidden__favorite_friend accordion"><b>Favorite Friend</b></div>
				<div class="6">
					<table>
					<th>Parameters</th><th>Sample Value</th>
				
					<tr><td>user_fbid</td><td>1234567</td></tr>
					<tr><td>friend_fbid</td><td>56789123</td></tr>
					<tr><td>favoritecode</td><td>generated code upon creating request</td></tr>
					<tr><td>api-key</td><td>api key value</td></tr>					
					</table>
					
					<div id="blue_box">
						This method will be used to create, update or get user details from webservice. it accepts all types
						of request e.g POST, GET 
					</div>
				
						<b>Calling the method</b><br /><br>
						
						1) POST&nbsp;: Add Favorite Friend/User</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/addfavoriteuser"><?php  echo base_url(); ?>restapicontroller/addfavoriteuser</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*user_fbid - who made this action<br>
							*friend_fbid - user/friend who want to add as favorite
						</div>
						
						<br>
						2) POST&nbsp;: Unfavorite Friend/User</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/unfavoriteuser"><?php  echo base_url(); ?>restapicontroller/unfavoriteuser</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*user_fbid - who made this action<br>
							*friend_fbid - user/friend who want to unfavorite<br>
						</div>
	
						<br />
						<!--
						3) GET&nbsp;:Fetch All Favorite Friend/User</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>restapicontroller/userfavoritelist"><?php  echo base_url(); ?>restapicontroller/userfavoritelist</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> use for fetching the record of all favorite friend/other users,  associated by user email<br>
							*user_email - who made this action<br>
						</div>
						-->
						<br /><br />
								
				</div>			


		
			
		<!-- end accordion -->
		<div style="text-align:center;color:#777;font-size:10px;"> <a id="aboutxxx" href="#">Web Service</a></div>
	</div><!-- end container -->
</body>

<script>
$(document).ready(function(){
		
	/* $("div.3").slideDown(1000);
	$("div.3").show("slow");	 */
		
		$("#aboutxxx").click(function(e){
			e.preventDefault();
			alert("----------------------------------\n - Beta Testing\njaysonpulga22@gmail.com\n----------------------------------\nChangelog\n");
		}); 

});
	

</script>
