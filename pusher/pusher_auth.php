<?php

require '../vendor/autoload.php';

$pusher = new Pusher\Pusher("242c1ebc2f45447381e3", "14a36ffce25dde568753", "553238", array('cluster' => 'mt1'));

echo $pusher->socket_auth($_POST['channel_name'], $_POST['socket_id']);

?>