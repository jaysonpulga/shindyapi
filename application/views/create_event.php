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



    <form id='form_register'>

	

	<div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="api-key" name='api-key' id='api-key'  >

      </div>

	

	

     <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="eventid" name='eventid' id='eventid' >

      </div>	  

		  

	 <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="eventname" name='eventname' id='eventname' >

      </div>

	  

	  <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="fulladdress" name='fulladdress' id='fulladdress' >

      </div>

	  

	  <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="long" name='long' id='long' >

      </div>

	  

	  <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="lat" name='lat' id='lat' >

      </div>

	  

	  <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="image" name='image' id='image' >

      </div>

	  

	  <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="description" name='description' id='description' >

      </div>

	  

	  

	   <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="notes" name='notes' id='notes' >

      </div>

	  

	   <div class="form-group has-feedback">

        <input type="number" class="form-control" placeholder="ticketprice" name='ticketprice' id='ticketprice' >

      </div>

	  

	   <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="vendorid" name='vendorid' id='vendorid' >

      </div>

	  

	   <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="representative" name='representative' id='representative' >

      </div>

	  

	   <div class="form-group has-feedback">

        <input type="date" class="form-control" placeholder="expirydate" name='expirydate' id='expirydate' >

      </div>

		

		
		
		
		
	  <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="sched_startdate" name='sched_startdate' id='sched_startdate' >
      </div>
	  
	   <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="start_time" name='start_time' id='start_time' >
      </div>
	  
	   <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="sched_enddate" name='sched_enddate' id='sched_enddate' >
      </div>
	  
	  
	   <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="end_time" name='end_time' id='end_time' >
      </div>

	  <div class="form-group has-feedback">
        <input type="number" class="form-control" placeholder="custom_price" name='custom_price' id='custom_price' >
      </div>
	  
	   <div class="form-group has-feedback">
        <input type="number" class="form-control" placeholder="spot_available" name='spot_available' id='spot_available' >
      </div>

	  

	  

	   <div class="form-group has-feedback">

        <button type="submit"  onclick="addUser()" class="btn btn-primary btn-block btn-flat">Register</button>

		 <button type="submit"  onclick='updateUser()' class="btn btn-primary btn-block btn-flat">Update</button>

		  <button type="submit"  onclick='getUser()' class="btn btn-primary btn-block btn-flat">Get User</button>

      </div>

    </form>
	
	
	
	
	 <form id='blocked'>
	
	<div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="api-key" name='api-key' id='api-key'  >
      </div>
	
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="blockcode" name='blockcode' id='blockcode' >
      </div>
	  
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="eventid" name='eventid' id='eventid' >
      </div>
		  
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="user_email" name='user_email' id='user_email' >
      </div>
	  
	   <div class="form-group has-feedback">
		<button type="submit"  onclick="block('add')" class="btn btn-primary btn-block btn-flat">block</button>
		<button type="submit"  onclick="block('unblock')" class="btn btn-primary btn-block btn-flat">unblock</button>
		<button type="submit"  onclick="block('get')" class="btn btn-primary btn-block btn-flat">Getblock</button>
      </div>
    </form>

  
  
   <form id='like'>
	
	<div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="api-key" name='api-key' id='api-key'  >
      </div>
	
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="likecode" name='likecode' id='likecode' >
      </div>
	  
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="eventid" name='eventid' id='eventid' >
      </div>
		  
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="user_email" name='user_email' id='user_email' >
      </div>
	  
	   <div class="form-group has-feedback">
		<button type="submit"  onclick="like('like')" class="btn btn-primary btn-block btn-flat">like</button>
		<button type="submit"  onclick="like('unlike')" class="btn btn-primary btn-block btn-flat">unlike</button>
		<button type="submit"  onclick="like('get')" class="btn btn-primary btn-block btn-flat">Getlike</button>
      </div>
    </form>
	
	
	  <form id='rate'>
	
	<div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="api-key" name='api-key' id='api-key'  >
      </div>
	
	 <div class="form-group has-feedback">
        <input type="number" class="form-control" placeholder="rate" name='rate' id='rate' >
      </div>
	  
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="eventid" name='eventid' id='eventid' >
      </div>
		  
	 <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="user_email" name='user_email' id='user_email' >
      </div>
	  
	   <div class="form-group has-feedback">
		<button type="submit"  onclick="ratex('rate')" class="btn btn-primary btn-block btn-flat">rate</button>
		<button type="submit"  onclick="ratex('getrate')" class="btn btn-primary btn-block btn-flat">Getrate</button>
      </div>
    </form>


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

				url: '<?php echo base_url(); ?>Eventapicontroller/create_event',

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

				url: '<?php echo base_url(); ?>Eventapicontroller/update_event',

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

				url: '<?php echo base_url(); ?>Eventapicontroller/eventlist/api-key/shindykey456',

				data: {'eventid':$('#eventid').val()},

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





function block(param)
{
	
	
	event.preventDefault();
	var url , type;

	
	if (param == "add")
	{
		url = '<?php echo base_url(); ?>Eventapicontroller/block_event';
		type = "POST";
	}
	
	else if (param == "unblock")
	{
		url = '<?php echo base_url(); ?>Eventapicontroller/unblock_event';
		type = "POST";
	}
	
	else if (param == "get")
	{
		url = '<?php echo base_url(); ?>Eventapicontroller/eventblockedlist';
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



function like(param)
{
	
	
	event.preventDefault();
	var url , type;

	
	if (param == "like")
	{
		url = '<?php echo base_url(); ?>Eventapicontroller/like_event';
		type = "POST";
	}
	
	else if (param == "unlike")
	{
		url = '<?php echo base_url(); ?>Eventapicontroller/unlike_event';
		type = "POST";
	}
	
	else if (param == "get")
	{
		url = '<?php echo base_url(); ?>Eventapicontroller/eventlikelist';
		type = "GET";
	}
	
	
	
	
	
		var formData = $('#like').serialize();
			
			
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


function ratex(param)
{
	
	
	event.preventDefault();
	var url , type;

	
	if (param == "rate")
	{
		url = '<?php echo base_url(); ?>Eventapicontroller/rate_event';
		type = "POST";
	}
	

	
	else if (param == "getrate")
	{
		url = '<?php echo base_url(); ?>Eventapicontroller/eventratelist';
		type = "GET";
	}
	
	
	
	
	
		var formData = $('#rate').serialize();
			
			
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





