<pre>
	PROBLEMS

	- General
		- messages
		- new users
		- extreme events
		- pages not refreshing after changes
		- keyboard not collapsing unless you hit back button
		- no error catch when internet gone
		- when logging in, you have to tap the button 2 times


	- Users Tab
		- search icon
		- when inviting, you still have to touch the event 2 times
		- messaging on users tab not working
		- facebook friends

	- Events
		- edit events
		- attendee counter
		- event rating
		- event review
		- event comment

	!!!IMPORTANT!!!
	 - CREATING GROUP
</pre>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script type="text/javascript">
	$.getJSON('http://api.wipmania.com/jsonp?callback=?', function (data) { 
		var lat = data.latitude;
		var long = data.longitude;
		var country = data.address.country;

		$.post('save_ip',{lat:lat, long:long, country:country}, function(dat){
		});
	});
</script>
