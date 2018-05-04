<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>sample form</title>
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
		<button type="submit"  onclick="block('block_event')" class="btn btn-primary btn-block btn-flat">blocked this event</button>
		
		<a   onclick="block('getblockevent')" href='#' target="_blank"  class="btn btn-primary btn-block btn-flat">list of block event</a>
		</div>
	  
   </form>
 
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<div class="login-box ">
  <div class="login-box-body  block-shadow">
  
  
  <form id='like'>
	
	<div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="api-key" name='api-key' id='api-key' value='shindykey456'>
      </div>
	

		  
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="user_fbid" name='user_fbid' id='user_fbid2' >
      </div>
	  
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="eventid" name='eventid' id='eventid2' >
      </div>
	  
	 
	   <div class="form-group has-feedback">
		<button type="submit"  onclick="like('like_event')" class="btn btn-primary btn-block btn-flat">like this event</button>
		
		<a   onclick="like('getlikeevent')" href='#' target="_blank"  class="btn btn-primary btn-block btn-flat">list of like event</a>
		</div>
	  
   </form>
 
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->




<div class="login-box ">
  <div class="login-box-body  block-shadow">
  
  
  <form id='discussion'>
	
	<div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="api-key" name='api-key' id='api-key' value='shindykey456'>
      </div>
	

		  
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="user_fbid" name='user_fbid' id='user_fbid3' >
      </div>
	  
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="eventid" name='eventid' id='eventid3' >
      </div>
	  
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="comment" name='comment' id='comment' >
      </div>
	  
	 
	   <div class="form-group has-feedback">
		<button type="submit"  onclick="discussion('comment_event')" class="btn btn-primary btn-block btn-flat">add discussion this event</button>
		
		<a   onclick="discussion('getcommentevent')" href='#' target="_blank"  class="btn btn-primary btn-block btn-flat">list of discussion event</a>
		</div>
	  
   </form>
 
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box --><div class="login-box ">  <div class="login-box-body  block-shadow">    invited event  <form id='invited_event'>		<div class="form-group has-feedback">        <input type="text" class="form-control" placeholder="api-key" name='api-key' id='api-key' value='shindykey456'>      </div>			  	 <div class="form-group has-feedback">        <input type="text" class="form-control" placeholder="user_fbid" name='user_fbid' id='user_fbid2' >      </div>	  		  	 	   <div class="form-group has-feedback">		<button type="submit"  onclick="like('invited_event')" class="btn btn-primary btn-block btn-flat">list invited event</button>				</div>	     </form>   </div>  <!-- /.login-box-body --></div><!-- /.login-box -->

  
</body>
</html>




<script type="text/javascript"> 



function block(param)
{
	
	
	event.preventDefault();
	var url , type;

	if (param == "block_event")
	{
		url = '<?php echo base_url(); ?>Eventapicontroller/block_event';
		type = "POST";
	
	}
	
	else if (param == "getblockevent")
	{
		
		url = 'http://shindygo.com/rest_webservices/Eventapicontroller/eventblockedlist/api-key/shindykey456/user_fbid/'+$("#user_fbid").val();
		//type = "GET";
		window.open(url, "_blank");
		return false;
		
	}
	
	
	
		var formData = $('#like').serialize();
			
			
            $.ajax({
                type: type,
				url: url,
				data: formData,
                success: function(data){	   
				   
				   
				   
				   if(data.status == "success")
				   {
					   alert(data.status);	
				   }
				   else
				   {
					   
					    alert(JSON.stringify(data.error));	
				   }
                },
                error: function(error){    
				   alert(JSON.stringify(error));
                    
                }
           });
	
}


function like(param)
{
	
	
	event.preventDefault();
	var url , type;

	if (param == "like_event")
	{
		url = '<?php echo base_url(); ?>Eventapicontroller/like_event';
		type = "POST";				var formData = $('#like').serialize();
		

	}		if (param == "invited_event")	{		url = '<?php echo base_url(); ?>Eventapicontroller/invited_event';		type = "POST";		var formData = $('#invited_event').serialize();	}		
	
	else if (param == "getlikeevent")
	{

		
		url = 'http://shindygo.com/rest_webservices/Eventapicontroller/eventlikelist/api-key/shindykey456/user_fbid/'+$("#user_fbid2").val();
		//type = "GET";
		window.open(url, "_blank");
		return false;
		
	}
	
	
	
						
			
			
            $.ajax({
                type: type,
				url: url,
				data: formData,
                success: function(data){	   
				   
				   console.log(data);
				   
				   if(data.status == "success")
				   {
					   alert(data.status);	
				   }
				   else
				   {
					   
					   alert(JSON.stringify(data.error));	
				   }
                },
                error: function(error){    
				   alert(JSON.stringify(error));
                    
                }
           });
	
}

function discussion(param)
{
	
	
	event.preventDefault();
	var url , type;

	if (param == "comment_event")
	{
		url = '<?php echo base_url(); ?>Eventapicontroller/addeventdiscussion';
		type = "POST";
		

	}
	
	else if (param == "getcommentevent")
	{

		
		url = 'http://shindygo.com/rest_webservices/Eventapicontroller/geteventdiscussion/api-key/shindykey456/eventid/'+$("#eventid3").val();
		//type = "GET";
		window.open(url, "_blank");
		return false;
		
	}
	
	
	
		var formData = $('#discussion').serialize();
			
			
            $.ajax({
                type: type,
				url: url,
				data: formData,
                success: function(data){	   
				   
				   
				   
				   if(data.status == "success")
				   {
					   alert(data.status);	
				   }
				   else
				   {
					   
					   alert(JSON.stringify(data.error));	
				   }
                },
                error: function(error){    
				   alert(JSON.stringify(error));
                    
                }
           });
	
}



 
</script>


