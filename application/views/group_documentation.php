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

		GROUP DOCUMENTATION

	</div>



	<div id="container">


		<strong>Methods:</strong><br>
		1) <a id="1" class="accordion_" href="#">CREATE GROUP</a><br />	
		2) <a id="2" class="accordion_" href="#">ADD MEMBER</a><br />	
		3) <a id="3" class="accordion_" href="#">GROUP MEMBER</a><br />	
		4) <a id="4" class="accordion_" href="#">GROUP MEMBER</a><br />	
		
		<br>

		Other Documentation:<br>
		<a  href="http://shindygo.com/rest_webservices/restdocumentation">User Documentation</a><br />
		<a   href="http://shindygo.com/rest_webservices/eventdocumentation">Event Documentation</a><br />
		<a   href="http://shindygo.com/rest_webservices/messagedocumentation">Message Documentation</a><br />

		

		

		<br />

		

				
				
				<div id="1" class="hidden_request_friend accordion"><b>CREATE GROUP</b></div>
				<div class="1">
					<table>
					<th>Parameters</th><th>Sample Value</th>
				
					<tr><td>title*</td><td>Group 1 sample name</td></tr>
					<tr><td>createdby*</td><td>sample1@yahoo.com<</td></tr>
					<tr><td>description</td><td>about the group</td></tr>
					<tr><td>tag</td><td></td></tr>
					<tr><td>bool</td><td>value 1 = searchable 0 = not searchable</td></tr>
					<tr><td>code</td><td>generated code upon creating request</td></tr>
					<tr><td>groupid</td><td>id of group</td></tr>
					<tr><td>param_search</td><td>use for searching the group value can be group title or group code or admin of the group (who created the group use bt email address)</td></tr>
					<tr><td>api-key</td><td>api key value</td></tr>					
					</table>
					
					<div id="blue_box">
						This method will be used to create, update or get user details from webservice. it accepts all types
						of request e.g POST, GET 
					</div>
				
						<b>Calling the method</b><br /><br>
						
						1) POST&nbsp;: Create Group</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Groupapicontroller/create_group"><?php  echo base_url(); ?>Groupapicontroller/create_group</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*title - Name of group<br>
							*createdby - who create the group
						</div>
						
						<br>
						2) POST&nbsp;: Update Group</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Groupapicontroller/update_group"><?php  echo base_url(); ?>Groupapicontroller/update_group</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*title - Name of group<br>
							*createdby - who create the group<br>
							*code - group code , return value after creating the group<br>
							*id - group id, autoincrement
						</div>
						
						<br />
						3) GET&nbsp;: Search Group</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Groupapicontroller/grouplist"><?php  echo base_url(); ?>Groupapicontroller/grouplist</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> use for fetching the all group,  associated by user email<br>
							*param_search - serach the group by title, groupcode or createdby <br>
							
						</div>
						<br>
						
						
						
						<br /><br />
								
				</div>	
				

			<div id="2" class="hidden_request_friend accordion"><b>ADD MEMBER</b></div>
				<div class="2">
					<table>
					<th>Parameters</th><th>Sample Value</th>
				
					<tr><td>groupid</td><td>id of group</td></tr>
					<tr><td>user_fbid</td><td>user fbid</td></tr>
					<tr><td>groupcode</td><td>generated code upon creating request</td></tr>
					<tr><td>api-key</td><td>api key value</td></tr>					
					</table>
					
					<div id="blue_box">
						This method will be used to create, update or get user details from webservice. it accepts all types
						of request e.g POST, GET 
					</div>
				
						<b>Calling the method</b><br /><br>
						
						1) POST&nbsp;: Direct Join Group</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Groupapicontroller/joingroup"><?php  echo base_url(); ?>Groupapicontroller/joingroup</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*groupid - group id of the group<br>
							*user_fbid - fb id  who wants to join
						</div>
						
						<br>
						2) POST&nbsp;: Join Group with Group Code Entry By  User </span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Groupapicontroller/joingroupentrycode"><?php  echo base_url(); ?>Groupapicontroller/joingroupentrycode</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*groupcode - group code entry by the user<br>
							*user_fbid - fb id of member who wants to join
						</div>
						
						<br />
						
						<br>
						
						3) POST&nbsp;: Leave The Group</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Groupapicontroller/leavegroup"><?php  echo base_url(); ?>Groupapicontroller/leavegroup</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*groupid - group id of the group<br>
							*user_fbid - fb id of member who to leave the group
						</div>
						
						<br>
						
						4) POST&nbsp;: Block The User</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Groupapicontroller/blockuseringroup"><?php  echo base_url(); ?>Groupapicontroller/blockuseringroup</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*groupid - group id of the group<br>
							*user_fbid - fb id of member who to block
						</div>
						
						<br>
						
						5) POST&nbsp;: UnBlock The User</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Groupapicontroller/unblockusergroup"><?php  echo base_url(); ?>Groupapicontroller/unblockusergroup</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*groupid - group id of the group<br>
							*user_fbid - fb id of member who to unblock
						</div>
						
						<br /><br />
								
				</div>	
				
				<div id="3" class="hidden_request_friend accordion"><b>GROUP MEMBER</b></div>
				<div class="3">
					<table>
					<th>Parameters</th><th>Sample Value</th>
				
					<tr><td>groupid</td><td>id of group</td></tr>
					<tr><td>api-key</td><td>api key value</td></tr>					
					</table>
					
					<div id="blue_box">
						This method will be used to create, update or get user details from webservice. it accepts all types
						of request e.g POST, GET 
					</div>
				
						<b>Calling the method</b><br /><br>
						
						1) GET&nbsp;: List of Active Group Member</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Groupapicontroller/grouplistactivemember"><?php  echo base_url(); ?>Groupapicontroller/grouplistactivemember</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*groupid - group id of the group<br>
						</div>
						
						<br>
					
						2) GET&nbsp;: List of Block Group Member</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Groupapicontroller/blockedmemberofgroup"><?php  echo base_url(); ?>Groupapicontroller/blockedmemberofgroup</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*groupid - group id of the group<br>
						</div>
						<br>
						
						<br>
					
						3) GET&nbsp;: List of Leave Group Member</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Groupapicontroller/leavedmemberofgroup"><?php  echo base_url(); ?>Groupapicontroller/leavedmemberofgroup</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*groupid - group id of the group<br>
						</div>
						<br>
						
						
						<br /><br />
								
				</div>	
				
				
				
				<div id="4" class="hidden_request_friend accordion"><b>GROUP CHAT</b></div>
				<div class="4">
					<table>
					<th>Parameters</th><th>Sample Value</th>
				
					<tr><td>groupid</td><td>id of group</td></tr>
					<tr><td>sender_fbid</td><td>fbid of user</td></tr>
					<tr><td>message</td><td>chat message</td></tr>
					<tr><td>api-key</td><td>api key value</td></tr>					
					</table>
					
					<div id="blue_box">
						This method will be used to create, update or get user details from webservice. it accepts all types
						of request e.g POST, GET 
					</div>
				
						<b>Calling the method</b><br /><br>
						
						1) POST&nbsp;: Send Message On Group Chat/Message</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Groupapicontroller/Sendgroup_message"><?php  echo base_url(); ?>Groupapicontroller/Sendgroup_message</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*groupid - group id of the group<br>
							*sender_fbid - fbid of user who send chat/message<br>
						</div>
						
						<br>
					
					
						
						<br>
					
						2) GET&nbsp;: List of Group Chat/Message</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Groupapicontroller/listmessageofgroup"><?php  echo base_url(); ?>Groupapicontroller/listmessageofgroup</a>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*groupid - group id of the group<br>
						</div>
						<br>
						
						
						<br /><br />
								
				</div>	

			

		<!-- end accordion -->

		<div style="text-align:center;color:#777;font-size:10px;"> <a id="aboutxxx" href="#">Web Service</a></div>

	</div><!-- end container -->

</body>




<script>

$(document).ready(function(){

		

	/* $("div.3").slideDown(1000);

	$("div.3").show("slow");	
 */
		

		$("#aboutxxx").click(function(e){

			e.preventDefault();

			alert("----------------------------------\n - Beta Testing\njaysonpulga22@gmail.com\n----------------------------------\nChangelog\n");

		}); 



});

	



</script>

