<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Register</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>



<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>assets/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/iCheck/icheck.min.js"></script>

<!-- Wait Me Plugin Js -->
<script src="<?php echo base_url(); ?>assets/waitme/waitMe.js"></script>
<!--WaitMe Css-->
<link href="<?php echo base_url(); ?>assets/waitme/waitMe.css" rel="stylesheet" />

<style>

body {
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 1.3rem;
    line-height: 1.5;
    color: #373a3c;
    background-color: #f1f3f6;
}


.login-page {
    background: #f1f3f6;
}

.block-shadow {
    box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.3);
}

.login-box{
    width: 360px;
    margin: 4% auto !important;
}
</style>





<body class="hold-transition login-page">
<div class="login-box ">
  <div class="login-box-body  block-shadow">
  
  
  <form id='blocked'>
	
	<div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="api-key" name='api-key' id='api-key' value='shindykey456'>
      </div>
	

		  
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="user_fbid" name='user_fbid' id='user_fbid' >
      </div>
	  
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="eventid" name='eventid' id='eventid' >
      </div>
	  
	 
	   <div class="form-group has-feedback">
		<button type="submit"  onclick="block('block_event ')" class="btn btn-primary btn-block btn-flat">blocked this event</button>
      </div>
	  
   </form>
	
	
	<!--
    <form id='form_register'>
	
	<div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="api-key" name='api-key' id='api-key'  >
      </div>
	
	
     <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="id" name='id' id='id' >
      </div>	  
		  
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="fullname" name='fullname' id='fullname' >
      </div>
	  
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="photo" name='photo' id='photo' >
      </div>
	  
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="email_address" name='email_address' id='email_address' >
      </div>
	  
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="about" name='about' id='about' >
      </div>
	  
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="age" name='age' id='age' >
      </div>
	  
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="age_pref" name='age_pref' id='age_pref' >
      </div>
	  
	  
	   <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="religion" name='religion' id='religion' >
      </div>
	  
	   <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="gender_pref" name='gender_pref' id='gender_pref' >
      </div>
	  
	   <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="address" name='address' id='address' >
      </div>
	  
	   <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="distance" name='distance' id='distance' >
      </div>
	  
	   <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="zipcode" name='zipcode' id='zipcode' >
      </div>
		
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="availability" name='availability' id='availability' >
      </div>

	  
	  
	   <div class="form-group has-feedback">
        <button type="submit"  onclick="addUser()" class="btn btn-primary btn-block btn-flat">Register</button>
		 <button type="submit"  onclick='updateUser()' class="btn btn-primary btn-block btn-flat">Update</button>
		  <button type="submit"  onclick='getUser()' class="btn btn-primary btn-block btn-flat">Get User</button>
      </div>
    </form>
  
  
  <br>
  <br>
  
   <form id='friendship'>
	
	<div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="api-key" name='api-key' id='api-key'  >
      </div>

	
     <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="friendshipcode" name='friendshipcode' id='friendshipcode' >
      </div>	  
		  
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="user_email" name='user_email' id='user_email' >
      </div>
	  
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="friend_email" name='friend_email' id='friend_email' >
      </div>
	  
	  
	  
	  
	   <div class="form-group has-feedback">
        <button type="submit"  onclick="friend('add')" class="btn btn-primary btn-block btn-flat">addfriend</button>
		<button type="submit"  onclick="friend('cancel')" class="btn btn-primary btn-block btn-flat">cancelrequest</button>
		<button type="submit"  onclick="friend('declined')" class="btn btn-primary btn-block btn-flat">declinedrequest</button>
		<button type="submit"  onclick="friend('approved')" class="btn btn-primary btn-block btn-flat">approvedrequest</button>
		<button type="submit"  onclick="friend('blocked')" class="btn btn-primary btn-block btn-flat">blocked user</button>
		<button type="submit"  onclick="friend('unblocked')" class="btn btn-primary btn-block btn-flat">Unblocked user</button>
		  <button type="submit"  onclick='()' class="btn btn-primary btn-block btn-flat">Get User</button>
      </div>
    </form>
	
	
	
	<br>
	<br>
	
	
	 <form id='blocked'>
	
	<div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="api-key" name='api-key' id='api-key'  >
      </div>
	
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="blockingcode" name='blockingcode' id='blockingcode' >
      </div>
		  
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="user_email" name='user_email' id='user_email' >
      </div>
	  
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="friend_email" name='friend_email' id='friend_email' >
      </div>
	  
	  
	  
	  
	   <div class="form-group has-feedback">
		<button type="submit"  onclick="block('blocked')" class="btn btn-primary btn-block btn-flat">blocked user</button>
		<button type="submit"  onclick="block('unblocked')" class="btn btn-primary btn-block btn-flat">Unblocked user</button>
		  <button type="submit" onclick="block('getblock')" class="btn btn-primary btn-block btn-flat">Get User</button>
      </div>
    </form>
	
	
	<br>
	<br>
	
	
	 <form id='favorite'>
	
	<div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="api-key" name='api-key' id='api-key'  >
      </div>
	
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="favoritecode" name='favoritecode' id='favoritecode' >
      </div>
		  
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="user_email" name='user_email' id='user_email' >
      </div>
	  
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="friend_email" name='friend_email' id='friend_email' >
      </div>
	  
	  
	  
	  
	   <div class="form-group has-feedback">
		<button type="submit"  onclick="favoritex('addfavor')" class="btn btn-primary btn-block btn-flat">add favorite user</button>
		<button type="submit"  onclick="favoritex('unfavor')" class="btn btn-primary btn-block btn-flat">unfavorite user</button>
		<button type="submit"  onclick="favoritex('getfavor')" class="btn btn-primary btn-block btn-flat">Get User</button>
      </div>
    </form>
  -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


</body>
</html>




<script type="text/javascript"> 

function addUser()
{
	event.preventDefault();
	
		var formData = $('#form_register').serialize();
			
			
            $.ajax({
                type: "POST",
				url: '<?php echo base_url(); ?>restapicontroller/create_user',
				data: formData,
                success: function(data){	   
				   alert(data.status);	
                },
                error: function(error){    
				   alert(error);
                    console.log(error);
                }
           });
	
}


function updateUser()
{
	event.preventDefault();
		var formData = $('#form_register').serialize();
			
			
            $.ajax({
                type: "POST",
				url: '<?php echo base_url(); ?>restapicontroller/update_user',
				data: formData,
                success: function(data){	   
				   alert(data.status);	
                },
                error: function(error){    
				   alert(error);
                    console.log(error);
                }
           });
	
}


function getUser()
{
	event.preventDefault();
		var formData = $('#form_register').serialize();
			
			
            $.ajax({
                type: "GET",
				url: '<?php echo base_url(); ?>restapicontroller/userlist/api-key/shindykey456',
				data: {'id':$('#id').val()},
				dataType:"JSON",
                success: function(data){	   
				   //alert(data.status);	
				   console.log(data);
                },
                error: function(error){    
				   alert(error);
                    console.log(error);
                }
           });
	
}







function friend(param)
{
	event.preventDefault();
	var url ;
	if(param == "add")
	{
		url = '<?php echo base_url(); ?>restapicontroller/addfriendrequest';
	}
	else if (param == "cancel")
	{
		url = '<?php echo base_url(); ?>restapicontroller/cancelfriendrequest';
	}
	else if (param == "declined")
	{
		url = '<?php echo base_url(); ?>restapicontroller/declinedfriendrequest';
	}
	
	else if (param == "approved")
	{
		url = '<?php echo base_url(); ?>restapicontroller/approvedfriendrequest';
	}
	
	else if (param == "blocked")
	{
		url = '<?php echo base_url(); ?>restapicontroller/blokeduser';
	}
	
	else if (param == "unblocked")
	{
		url = '<?php echo base_url(); ?>restapicontroller/unblocked';
	}
	
	
	
		var formData = $('#friendship').serialize();
			
			
            $.ajax({
                type: "POST",
				url: url,
				data: formData,
                success: function(data){	   
				   alert(data.status);	
                },
                error: function(error){    
				   alert(error);
                    console.log(error);
                }
           });
	
}


function block(param)
{
	
	
	event.preventDefault();
	var url , type;

	
	if (param == "blocked")
	{
		url = '<?php echo base_url(); ?>restapicontroller/blokeduser';
		type = "POST";
	}
	
	else if (param == "unblocked")
	{
		url = '<?php echo base_url(); ?>restapicontroller/unblocked';
		type = "POST";
	}
	
	else if (param == "getblock")
	{
		url = '<?php echo base_url(); ?>restapicontroller/userblockedlist';
		type = "GET";
	}
	
	
	else if (param == "block_event")
	{
		url = '<?php echo base_url(); ?>Eventapicontroller/block_event';
		type = "GET";
	}
	
	
	
	
		var formData = $('#blocked').serialize();
			
			
            $.ajax({
                type: type,
				url: url,
				data: formData,
                success: function(data){	   
				   alert(data.status);	
                },
                error: function(error){    
				   alert(error);
                    console.log(error);
                }
           });
	
}


function favoritex(param)
{
	
	event.preventDefault();
	var url,type ;

	
	if (param == "addfavor")
	{
		url = '<?php echo base_url(); ?>restapicontroller/addfavoriteuser';
		type = "POST";
	}
	
	else if (param == "unfavor")
	{
		url = '<?php echo base_url(); ?>restapicontroller/unfavoriteuser';
		type = "POST";
	}
	
	else if (param == "getfavor")
	{
		url = '<?php echo base_url(); ?>restapicontroller/userfavoritelist';
		type = "GET";
	}
	
	
	
		var formData = $('#favorite').serialize();
			
			
            $.ajax({
                type: type,
				url: url,
				data: formData,
                success: function(data){	   
				   alert(data.status);	
                },
                error: function(error){    
				   alert(error);
                    console.log(error);
                }
           });
}


</script>


