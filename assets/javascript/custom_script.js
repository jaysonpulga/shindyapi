$(document).ready(function(){

	$("div.1").hide();
	$("div.2").hide();
	$("div.3").hide();
	$("div.4").hide();
	$("div.5").hide();
	$("div.6").hide();
	$("div.7").hide();
	$("div.8").hide();
	$("div.9").hide();
	$("div.10").hide();
	$("div.11").hide();
	$("div.12").hide();
	$("div.13").hide();
	$("div.14").hide();
	$("div.15").hide();
	
	
	
	
	
	$("div.accordion").click(function(e)
	{
		e.preventDefault();
		
		var id = $(this).attr('id');
		
		$("div.accordion").removeClass('selected_div');
		
		for(var i=1;i<=15;i++)
		{
			$("div."+i).hide(1000);
		}
		
		if($("div."+id).is(":visible")==false)
		{
			$("div."+id).slideDown(1000);
			$("div."+id).show("slow");	
		}	
		
		$(this).toggleClass('selected_div');
		
	});
	
	$("a.accordion_").click(function(e)
	{
		e.preventDefault();

		var id = $(this).attr('id');
		
		$("div.accordion").removeClass('selected_div');
		
		for(var i=1;i<=14;i++)
		{
			$("div."+i).hide(1000);
		}
		
		if($("div."+id).is(":visible")==false)
		{
			$("div."+id).slideDown(1000);
			$("div."+id).show("slow");	
		}
		
		if(id=="1")
		{
			$(".hidden_create_corporate").toggleClass('selected_div');
		}
		else if(id=="2")
		{
			$(".hidden_update_corporate").toggleClass('selected_div');
	
		}
		else if(id=="3")
		{
			$(".hidden_create_employee").toggleClass('selected_div');

		}
		else if(id=="4")
		{
			$(".hidden_request_friend").toggleClass('selected_div');
		
		}
		
		
		else if(id=="5")
		{
			$(".hidden_block_friend").toggleClass('selected_div');

		}
		else if(id=="6")
		{
			$(".hidden__favorite_friend").toggleClass('selected_div');

		}
		else if(id=="7")
		{
			$(".hidden_get_user_details").toggleClass('selected_div');	

		}
		else if(id=="8")
		{
			$(".hidden_get_related_articles").toggleClass('selected_div');	

		}
		else if(id=="9")
		{
			$(".hidden_submit_comment").toggleClass('selected_div');	

		}
		else if(id=="10")
		{
			$(".hidden_verify_otp").toggleClass('selected_div');	

		}
		else if(id=="11")
		{
			$(".hidden_get_token").toggleClass('selected_div');	

		}
		else if(id=="12")
		{
			$(".hidden_set_apps_location_feed").toggleClass('selected_div');	

		}
		else if(id=="13")
		{
			$(".hidden_set_appointment").toggleClass('selected_div');	

		}

		else if(id=="14")
		{
			$(".hidden_update_appointment").toggleClass('selected_div');	

		}

		else if(id=="15")
		{
			$(".hidden_private").toggleClass('selected_div');	

		}

		
	});
	


	
});