<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  
</head>

<?php

require '../vendor/autoload.php';

$pusher = new Pusher\Pusher("242c1ebc2f45447381e3", "14a36ffce25dde568753", "553238", array('cluster' => 'mt1'));

$pusher->trigger('my-channel', 'my-event', array('message' => 'hello world'));

?>
<body>

</body>
