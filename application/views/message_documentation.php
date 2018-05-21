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

		Message DOCUMENTATION

	</div>



	<div id="container">


		<strong>Methods:</strong><br>
		1) <a id="1" class="accordion_" href="#">Message</a><br />	
	
		
		<br>

		Other Documentation:<br>
		<a  href="http://shindygo.com/rest_webservices/restdocumentation">User Documentation</a><br />
		<a   href="http://shindygo.com/rest_webservices/eventdocumentation">Event Documentation</a><br />
		<a   href="http://shindygo.com/rest_webservices/groupdocumentation">Group Documentation</a><br />

		

		

		<br />

		

				
				
				<div id="1" class="hidden_request_friend accordion"><b>Message</b></div>
				<div class="1">
					<table>
					<th>Parameters</th><th>Sample Value</th>
				
					<tr><td>sender_id*</td><td>user fbid of sender</td></tr>
					<tr><td>recipient_id*</td><td>user fbid of receiver</td></tr>
					<tr><td>message</td><td>Message of sender to receiver </td></tr>
					<tr><td>api-key</td><td>api key value</td></tr>					
					</table>
					
					<div id="blue_box">
						This method will be used to create, update or get user details from webservice. it accepts all types
						of request e.g POST, GET 
					</div>
				
						<b>Calling the method</b><br /><br>
						
						1) POST&nbsp;: Send Message</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Messageapicontroller/SendMessage"><?php  echo base_url(); ?>Messageapicontroller/SendMessage</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*sender_id - user fbid of sender<br>
							*recipient_id - user fbid of receiver<br>
							message - Message of sender to receiver<br>
						</div>
						
						<br>
						
						2) POST&nbsp;: Seen Message</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Messageapicontroller/Seenmessage"><?php  echo base_url(); ?>Messageapicontroller/Seenmessage</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*msg_id - id of message<br>
							*recipient_id - user fbid of receiver who seen the message<br>
						</div>
						<br>
					
						3) POST&nbsp;: Delete Message</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Messageapicontroller/deletemessage"><?php  echo base_url(); ?>Messageapicontroller/deletemessage</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*msg_id - id of message<br>
							*user_fbid - user fbid who delete message<br>
							
						</div>
						<br>
						
						4) POST&nbsp;: Get PM Message/Conversation of Sender and Receiver</span> &nbsp;
						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Messageapicontroller/getPMmessage"><?php  echo base_url(); ?>Messageapicontroller/getPMmessage</a>
						<br/>
						<div style='padding-left:20px;font-size:11px'>
							<b>Note:</b> important fields for this action<br>
							*sender_id - user fbid of sender<br>
							*recipient_id - user fbid of receiver<br>
							
						</div>
						<br>																		5) POST&nbsp;: Get All Message</span> &nbsp;						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Messageapicontroller/getAllmessage"><?php  echo base_url(); ?>Messageapicontroller/getAllmessage</a>						<br/>						<div style='padding-left:20px;font-size:11px'>							<b>Note:</b> important fields for this action<br>							*user_fbid - fbid of user to get all message for him/her<br>							search - use for search by  friends fullname,message,date send or receive message<br>													</div>						<br>
						
						
						
						
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

