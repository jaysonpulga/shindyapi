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


<style>
pre{
  font-family: Consolas, Menlo, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, Courier New, monospace, serif;
  margin-bottom: 10px;
  overflow: auto;
  padding: 5px;
  background-color: #eee;
  width: 100px!ie7;
  padding-bottom: 20px!ie7;
  max-height: 600px;
  
}
</style>
	







	



</head>



<body>







	<div id="header">



		



	</div>



	



	<div id="subheader">



		EVENT DOCUMENTATION



	</div>







	<div id="container">





		<strong>Methods:</strong><br>

		1) <a id="3" class="accordion_" href="#">Event</a><br />	

		2) <a id="4" class="accordion_" href="#">Block Event</a><br />	

		3) <a id="5" class="accordion_" href="#">Like Event</a><br />	

		4) <a id="6" class="accordion_" href="#">Rate and Feedback Event</a><br />

		5) <a id="7" class="accordion_" href="#">Invite Event</a><br />

		6) <a id="8" class="accordion_" href="#">Event Discussion</a><br />

		&nbsp;&nbsp;6.1 <a id="10" class="accordion_" href="#">like Discussion</a><br />

		7) <a id="9" class="accordion_" href="#">Reply Discussion</a><br /><br>

		



		Other Documentation:<br>

		<a  href="http://shindygo.com/rest_webservices/restdocumentation">User Documentation</a><br />

		<a   href="http://shindygo.com/rest_webservices/groupdocumentation">Group Documentation</a><br />

		<a   href="http://shindygo.com/rest_webservices/messagedocumentation">Message Documentation</a><br />

		



		



		<br />



		



			<div id="3" class="hidden_create_employee accordion"><b>Event</b></div>



				<div class="3">



					<table>



					<th>Parameters</th><th>Sample Value</th>

					<tr><td>user_fbid*</td><td>7777771234567</td></tr>

					<tr><td>eventname *</td><td>Grand Meeting 2018</td></tr>

					<tr><td>fulladdress *</td><td>Calamba Laguna Phillipines</td></tr>

					<tr><td>long*</td><td>Longitude (return on map api)</td></tr>

					<tr><td>lat*</td><td>Latitude (return on map api)</td></tr>

					<tr><td>zipcode*</td><td>Latitude (return on map api)</td></tr>

					<tr><td>image</td><td>url image path</td></tr>

					<tr><td>description</td><td>sample event description</td></tr>

					<tr><td>notes</td><td>sample event notes</td></tr>

					<tr><td>ticketprice</td><td>$10.00</td></tr>

					<tr><td>representative</td><td>id of co-host/representative</td></tr>

					<tr><td>expirydate</td><td>2018-02-01</td></tr>

					<tr><td>sched_startdate</td><td>2018-01-01</td></tr>

					<tr><td>start_time</td><td>10:00 AM</td></tr>

					<tr><td>sched_enddate</td><td>optional for this field, sample(2018-01-01)</td></tr>

					<tr><td>end_time</td><td>optional for this field, sample value(13:00 PM)</td></tr>

					<tr><td>spot_available</td><td>5</td></tr>

					<tr><td>max_male</td><td>4</td></tr>

					<tr><td>max_female</td><td>8</td></tr>

					<tr><td>website_url</td><td>www.sample.com</td></tr>

					<tr><td>api-key</td><td>api key value</td></tr>

					<tr><td>eventid</td><td>id of event (use for modify event details or get event by id)</td></tr>

					</table>



					



					<div id="blue_box">



						This method will be used to create, update or get user details from webservice. it accepts all types



						of request e.g POST, GET 



					</div>



				



						<b>Calling the method</b><br /><br>



						1) GET&nbsp;: Event List</span> &nbsp;



						<a  style='font-size:13px'href="<?php  echo base_url(); ?>eventapicontroller/eventlist/api-key/xxxxxxxxxx"><?php  echo base_url(); ?>eventapicontroller/eventlist/api-key/xxxxxxxxx</a>
						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>
							user_fbid - you should put user_fbid to know if the list of event has been liked by user<br>

						</div>


						<br><br>
						
						



						2a) GET&nbsp;: Event By Id</span> &nbsp;



						<a  style='font-size:13px'href="<?php  echo base_url(); ?>eventapicontroller/eventlist/eventid/1/api-key/xxxxxxxxx"><?php  echo base_url(); ?>eventapicontroller/eventlist/eventid/1/api-key/xxxxxxxxx</a>
						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							eventid - id of event use for search specific event<br>
							user_fbid - you should put user_fbid to know if the list of event has been liked by user<br>

						</div>



						<br><br>

						

						2b) GET&nbsp;: Event Created by user</span> &nbsp;



						<a  style='font-size:13px'href="<?php  echo base_url(); ?>eventapicontroller/eventlistcreatedbyuser/user_fbid/{facebookid}/api-key/xxxxxxxxx"><?php  echo base_url(); ?>eventapicontroller/eventlistcreatedbyuser/user_fbid/{facebookid}/api-key/xxxxxxxxx</a>



						<br><br>



						3a) POST&nbsp;: Add New Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>eventapicontroller/create_event"><?php  echo base_url(); ?>eventapicontroller/create_event</a>

						<br><br>
						
						
						3b) POST&nbsp;: Upload Event Image</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>eventapicontroller/uploadeventimage"><?php  echo base_url(); ?>eventapicontroller/uploadeventimage</a>
						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*eventid - id of event <br>
							*image -  pass image as encoded value<br>

						</div>

						<br><br>

						

						4) POST&nbsp;: Update Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>eventapicontroller/update_event"><?php  echo base_url(); ?>eventapicontroller/update_event</a>

						<br /><br />

						

						

						

						5) POST&nbsp;: Attending Event (list of event  user attending) </span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>eventapicontroller/attending_event"><?php  echo base_url(); ?>eventapicontroller/attending_event</a>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*user_fbid - facebook id <br>

						</div>

						<br />



						

						6) POST&nbsp;: Inviting Event (list of event user invited)  </span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>eventapicontroller/invited_event"><?php  echo base_url(); ?>eventapicontroller/invited_event</a>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*user_fbid - fbid of user  <br>

						</div>

						<br />

						

						7) POST&nbsp;: Who is invited for this event (list of user invited for this event)</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>eventapicontroller/whoisinvited_event"><?php  echo base_url(); ?>eventapicontroller/whoisinvited_event</a>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*user_fbid - facebook id <br>

							*eventid - event id <br>
							

						</div>

						

						<br /><br />

						

						

						<p>Image 1: - describe fields and value for adding event <p>

						<img src="http://shindygo.com/rest_webservices/application/assets/event/eventdetails.png"  width="100%" height="100%"  alt="">

						<br><br>

						<p>Image 2: - POSTMAN creating event  <p>

						<img src="http://shindygo.com/rest_webservices/application/assets/event/add_event.PNG"  width="100%" height="100%"  alt="">

						<br><br>

						<p>Image 3: - POSTMAN result after creating event  <p>

						<img src="http://shindygo.com/rest_webservices/application/assets/event/add_return_data.PNG"  width="50%" height="50%"  alt="">

						<br><br>



					



					

				</div>



				

				

				<div id="4" class="hidden_request_friend accordion"><b>Block Event</b></div>

				<div class="4">

					<table>

					<th>Parameters</th><th>Sample Value</th>

				

					<tr><td>user_fbid </td><td>123456789</td></tr>

					<tr><td>eventid</td><td>event id</td></tr>

					<tr><td>blockcode</td><td>generated code upon creating request</td></tr>

					<tr><td>api-key</td><td>api key value</td></tr>					

					</table>

					

					<div id="blue_box">

						This method will be used to create, update or get user details from webservice. it accepts all types

						of request e.g POST, GET 

					</div>

				

						<b>Calling the method</b><br /><br>

						

						1) POST&nbsp;: Block Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/block_event"><?php  echo base_url(); ?>Eventapicontroller/block_event</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*user_fbid - who block the event<br>

							*eventid - event you want to block

						</div>

						

						<br>

						2) POST&nbsp;: Unblock Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/unblock_event"><?php  echo base_url(); ?>Eventapicontroller/unblock_event</a>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*user_fbid - who made this action<br>

							*eventid - event you want to unblock <br>

							*blockcode - unique code , need for updating the request

						</div>

						

						<br />

						3) GET&nbsp;: Fetch All Blocked Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/eventblockedlist"><?php  echo base_url(); ?>Eventapicontroller/eventblockedlist</a>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> use for fetching the record of blocked event,  associated by user email<br>

							*user_fbid - who made this action<br>

							

						</div>

						<br>

						

						

						

						<br /><br />

								

				</div>	

				



			<div id="5" class="hidden_request_friend accordion"><b>Like Event</b></div>

				<div class="5">

					<table>

					<th>Parameters</th><th>Sample Value</th>

				

					<tr><td>user_fbid</td><td>1234567890</td></tr>

					<tr><td>eventid</td><td>event id</td></tr>

					<tr><td>likecode</td><td>generated code upon creating request</td></tr>

					<tr><td>api-key</td><td>api key value</td></tr>					

					</table>

					

					<div id="blue_box">

						This method will be used to create, update or get user details from webservice. it accepts all types

						of request e.g POST, GET 

					</div>

				

						<b>Calling the method</b><br /><br>

						

						1) POST&nbsp;: Like Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/like_event"><?php  echo base_url(); ?>Eventapicontroller/like_event</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*user_fbid - who block the event<br>

							*eventid - event you want to block

						</div>

						

						<br>

						2) POST&nbsp;: Unlike Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/unlike_event"><?php  echo base_url(); ?>Eventapicontroller/unlike_event</a>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*user_fbid - who made this action<br>

							*eventid - event you want to unblock <br>

							*likecode - unique code , need for updating the request

						</div>

						

						<br />

						3) GET&nbsp;: Fetch All Like Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/eventlikelist"><?php  echo base_url(); ?>Eventapicontroller/eventlikelist</a>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> use for fetching the record of like event,  associated by user email<br>

							*user_fbid - who made this action<br>

							

						</div>

						<br>

						

						

						

						<br /><br />

								

				</div>	

				

				<div id="6" class="hidden_request_friend accordion"><b>Rate and Feedback Event</b></div>

				<div class="6">

					<table>

					<th>Parameters</th><th>Sample Value</th>

				

					<tr><td>user_fbid</td><td>12346789</td></tr>

					<tr><td>eventid</td><td>event id</td></tr>

					<tr><td>rate</td><td>1.2, 2.5, 3, 4.5 , 5</td></tr>

					<tr><td>host_review</td><td>1.2, 2.5, 3, 4.5 , 5</td></tr>

					<tr><td>feedback</td><td>event feedback, excellent performance and event settings </td></tr>

					<tr><td>api-key</td><td>api key value</td></tr>					

					</table>

					

					<div id="blue_box">

						This method will be used to create, update or get user details from webservice. it accepts all types

						of request e.g POST, GET 

					</div>

				

						<b>Calling the method</b><br /><br>

						

						1) POST&nbsp;: Add Rate Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/rate_event"><?php  echo base_url(); ?>Eventapicontroller/rate_event</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*user_fbid - who made this action<br>

							*eventid - event you want to add rate <br>

							rate -  4.5<br>

							host_review -  3.5<br>

							feedback -  excellent performance and event settings not boring<br>

						</div>

						

						<br>

						

						2) GET&nbsp;: Get All Rate and Review List of User</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/eventreviewlist"><?php  echo base_url(); ?>Eventapicontroller/eventreviewlist</a>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> use for fetching the record  event rate,  associated by user email<br>

							*user_fbid - fetch all event review by user fbid <br>

							<p>Image 1: - Get All Rate and Review List of User <p>

							<img src="http://shindygo.com/rest_webservices/application/assets/event/ratereviewlist.png"  width="30%" height="30%"  alt="">

							<br>

							

						</div>

						<br>

						

						

					

						3) GET&nbsp;: Fetch All Rate and Review of Event By id</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/eventratelist"><?php  echo base_url(); ?>Eventapicontroller/eventratelist</a>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> use for fetching the record  event rate,  associated by user email<br>

							*eventid - fetch all rate and feedback by event id <br>

							<br>

							<p>Image 2: -Fetch All Rate and Review of Event By id <p>

							<img src="http://shindygo.com/rest_webservices/application/assets/event/eventratelist.png"  width="30%" height="30%"  alt="">

							<br>

						</div>

						

						

						

						<br /><br />

								

				</div>	

				

				

				

				<div id="7" class="hidden_request_friend accordion"><b>Invite Event</b></div>

				<div class="7">

					<table>

					<th>Parameters</th><th>Sample Value</th>

				

					<tr><td>eventid</td><td>id of event</td></tr>

					<tr><td>attendee_id</td><td>fbid of user who attendee</td></tr>

					<tr><td>invite_by</td><td>user fbid who made invite to other user</td></tr>

					<tr><td>anonymous_invite</td><td>[0= non anonymous, 1 = anonymous]</td></tr>

					<tr><td>offer_to_pay</td><td>[1 = offered to pay]</td></tr>

					

					<tr><td>api-key</td><td>api key value</td></tr>					

					</table>

					

					<div id="blue_box">

						This method will be used to create, update or get user details from webservice. it accepts all types

						of request e.g POST, GET 

					</div>

				

						<b>Calling the method</b><br /><br>

						

						1) POST&nbsp;: Send Invite</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/sendinvite"><?php  echo base_url(); ?>Eventapicontroller/sendinvite</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*attendee_id - fbid of user who attendee<br>

							*eventid - event id of event <br>

							*invite_by - user fbid who made invite to other user <br>

							

							anonymous_invite - [0= non anonymous, 1 = anonymous]<br>

							offer_to_pay - [1 = offered to pay] <br>

						</div>
							
							
							<!--
							
							*dataevent as array <br>
						

							
							


						</div>
						<blockquote>
						<pre>
						<code>
	
							Array
							(
								[0] => Array
									(
										[attendee_id] => 000000000000000000000000000
										[anonymous_invite] => 1
										[offer_to_pay] => 1
									)

								[1] => Array
									(
										[attendee_id] => 77777777771234
										[anonymous_invite] => 1
										[offer_to_pay] => 1
									)

							)
					
							</code>
						</pre>	
					</blockquote>

							<p>Image 1: - describe fields and value for sending invite event to users<p>

						<img src="http://shindygo.com/rest_webservices/application/assets/event/postman_sendinvitation.png"  width="auto" height="auto"  alt="">
						
						-->

						<br><br>

					

					

						2) POST&nbsp;: Cancel Event Invite</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/cancelinvitation"><?php  echo base_url(); ?>Eventapicontroller/cancelinvitation</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*attendee_id - fbid of user who cancel this request<br>

							*eventid - event id for event you want to cancel <br>
							
							*invite_by- user fbid of who send invitation <br>

						</div>

						<br>

						

						3) POST&nbsp;: Accept Event Invite</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/acceptinvitation"><?php  echo base_url(); ?>Eventapicontroller/acceptinvitation</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*attendee_id - fbid of user who accept event<br>

							*eventid - event id for  event user want to accept <br>
							
							*invitecode - invitecode  user  want to accept event <br>
							

						</div>

						<br>

						

						4) POST&nbsp;: Leave Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/leave_event"><?php  echo base_url(); ?>Eventapicontroller/leave_event</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*attendee_id - fbid of user who want leave the event<br>

							*eventid - event id for event you want to leave <br>

						</div>

						<br>

						

						

						5) GET&nbsp;:   List of Suggested Events</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/suggested_eventlist"><?php  echo base_url(); ?>Eventapicontroller/suggested_eventlist</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

						<b>Note:</b>show all event list<br>

							eventid - event id for searching specific event <br>

						</div>

						<br>
						
						
						6) GET&nbsp;:   List of Suggested Users</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/inviteusers"><?php  echo base_url(); ?>Eventapicontroller/inviteusers</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

						<b>Note:</b>show all users<br>

							eventid - event id  <br>

						</div>

						<br>

						
						<!--
						6) POST&nbsp;:   join Event Im in</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/joinevent_iamin"><?php  echo base_url(); ?>Eventapicontroller/joinevent_iamin</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

						<b>Note:</b>show all event list<br>

							*eventid - id event you want to join <br>

							*attendee_id - user fbid who want to join event <br>

							invite_by - user fbid who want invite user <br>

							

						</div>

						<br>
						
						-->

						7) POST&nbsp;: Sent Invite By Email</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/sendinviteby_email"><?php  echo base_url(); ?>Eventapicontroller/sendinviteby_email</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

						<b>Note:</b>show all event list<br>

							*eventid - id event  <br>

							*user_email - user email address must be valid <br>

							*invited_by - user fbid who send invitation  <br>
							
							note = note or message for invitation <br>
							
							<p>image for send invitation via email </p>

						<img src="http://shindygo.com/rest_webservices/application/assets/event/sendinvite.png"  width="50%" height="50%"  alt="">

							

						</div>

						<br>
						<br>
						

						 
						
						

						8) POST&nbsp;: Enter Invite Code Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/enterEventcode"><?php  echo base_url(); ?>Eventapicontroller/enterEventcode</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*attendee_id - fbid of user who join event<br>

							

							*invitecode - event invite code for event you want to join <br>

							

							<p>image for enter event code </p>

						<img src="http://shindygo.com/rest_webservices/application/assets/event/entercode.png"  width="30%" height="30%"  alt="">

						

						</div>

						

						

						<br /><br />	

				</div>	

				

				

				

				<div id="8" class="hidden_request_friend accordion"><b>Event Discussion</b></div>

				<div class="8">

					<table>

					<th>Parameters</th><th>Sample Value</th>

				

					<tr><td>eventid</td><td>id of event</td></tr>

					<tr><td>user_fbid</td><td>fbid of user</td></tr>

					<tr><td>comment</td><td>comment/discussion for event</td></tr>

					<tr><td>api-key</td><td>api key value</td></tr>					

					</table>

					

					<div id="blue_box">

						This method will be used to create, update or get user details from webservice. it accepts all types

						of request e.g POST, GET 

					</div>

				

						<b>Calling the method</b><br /><br>

						

						1) POST&nbsp;: Add Comment/Discussion for Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/addeventdiscussion"><?php  echo base_url(); ?>Eventapicontroller/addeventdiscussion</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*user_fbid - fbid of user who send comment<br>

							*eventid - event id of event <br>

							comment - message for event<br>

						</div>

						

						<br>

					

						2) POST&nbsp;: Update Comment/Discussion for Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/updateeventdiscussion"><?php  echo base_url(); ?>Eventapicontroller/updateeventdiscussion</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*discussion_id - id of discussion/comment<br>

							*user_fbid - fbid of user who send comment<br>

							*eventid - event id of event <br>

							comment - message for event<br>

						</div>

						<br>

						

						3) GET&nbsp;: List Of Event Discussion/Chat</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/geteventdiscussion"><?php  echo base_url(); ?>Eventapicontroller/geteventdiscussion</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*eventid - id of event use for search specific event<br>
							user_fbid - you should put user_fbid to know if the list of chat has been liked by user<br>

						</div>

						<br>

					

				</div>

				

				

				<div id="9" class="hidden_request_friend accordion"><b>Reply Discussion</b></div>

				<div class="9">

					<table>

					<th>Parameters</th><th>Sample Value</th>

				

					<tr><td>discussion_id</td><td>id for discussion/comment</td></tr>

					<tr><td>eventid</td><td>id of event</td></tr>

					<tr><td>user_fbid</td><td>fbid of user</td></tr>

					<tr><td>reply_comment</td><td>comment/discussion for event</td></tr>

					<tr><td>api-key</td><td>api key value</td></tr>					

					</table>

					

					<div id="blue_box">

						This method will be used to create, update or get user details from webservice. it accepts all types

						of request e.g POST, GET 

					</div>

				

						<b>Calling the method</b><br /><br>

						

						1) POST&nbsp;: Add Comment/Discussion for Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/replyeventdiscussion"><?php  echo base_url(); ?>Eventapicontroller/replyeventdiscussion</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							

							*discussion_id - id of discussion/comment<br>

							*user_fbid - fbid of user who send comment<br>

							*eventid - event id of event <br>

							reply_comment - reply comment <br>

						</div>

						

						<br>

					

						2) POST&nbsp;: Update Comment/Discussion for Event</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/update_replyeventdiscussion"><?php  echo base_url(); ?>Eventapicontroller/update_replyeventdiscussion</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*discussion_id - id of discussion/comment<br>

							*user_fbid - fbid of user who send comment<br>

							*eventid - event id of event <br>

							reply_comment - message for event<br>

						</div>

						<br>

						

						3) GET&nbsp;: List Of Reply Event Discussion/Chat</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/replydiscussionlist"><?php  echo base_url(); ?>Eventapicontroller/replydiscussionlist</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*discussion_id - id of comment<br>
							*evenid - id of event<br>

						</div>

						<br>

					

				</div>

						

						

				<div id="10" class="hidden_request_friend accordion"><b>Like Discussion</b></div>

				<div class="10">

					<table>

					<th>Parameters</th><th>Sample Value</th>

				

					<tr><td>commentid</td><td>id for comment or discussion</td></tr>

					<tr><td>user_fbid</td><td>fbid of user</td></tr>

					<tr><td>api-key</td><td>api key value</td></tr>					

					</table>

					

					<div id="blue_box">

						This method will be used to create, update or get user details from webservice. it accepts all types

						of request e.g POST, GET 

					</div>

				

						<b>Calling the method</b><br /><br>

						

						1) POST&nbsp;: like discussion/comment</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/like_discussion"><?php  echo base_url(); ?>Eventapicontroller/like_discussion</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							

							*commentid - id of discussion/comment<br>

							*user_fbid - fbid of user who send comment<br>

						</div>

						

						<br>

					

						2) POST&nbsp;: unlike Commnent Discussion</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/unlike_discussion"><?php  echo base_url(); ?>Eventapicontroller/unlike_discussion</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*commentid - id of discussion/comment<br>

							*user_fbid - fbid of user who send comment<br>

						</div>

						<br>

						

						

						

						3) GET&nbsp;: list of discussion who like the comment</span> &nbsp;

						<a  style='font-size:13px'href="<?php  echo base_url(); ?>Eventapicontroller/discussionlikelist"><?php  echo base_url(); ?>Eventapicontroller/discussionlikelist</a>

						<br/>

						<div style='padding-left:20px;font-size:11px'>

							<b>Note:</b> important fields for this action<br>

							*commentid - comment id for discussion<br>

						</div>

						<br>

					

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



