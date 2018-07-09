<!doctype html>
<html>
<head>
  <title>Pusher Test</title>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
  <p id="test"> Test </p>
  
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
  <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
  <script>

	// Enable pusher logging - don't include this in production
	Pusher.logToConsole = true;

	var pusher = new Pusher('242c1ebc2f45447381e3', {
	  wsHost: 'ws.pusherapp.com',
	  httpHost: 'sockjs.pusher.com',
	  encrypted: true
	});

	var channel = pusher.subscribe('my-channel');
	channel.bind('my-event', function(data) {
	  alert(JSON.stringify(data));
	  setText(data["message"]);
	});
  
    
	
	function setText(txt){
		$("#test").html(txt);
	}
  </script>
</body>
</html>
