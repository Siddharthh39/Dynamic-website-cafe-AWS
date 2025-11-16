<?php

if ($showServerInfo == 'true') {

	// get a valid TOKEN
$headers = array (
	'X-aws-ec2-metadata-token-ttl-seconds: 21600' );
$url = "http://169.254.169.254/latest/api/token";
#echo "URL ==> " .  $url;
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT" );
curl_setopt( $ch, CURLOPT_URL, $url );
$token = curl_exec( $ch );

#echo "<p> TOKEN :" . $token;
// then get metadata of the current instance 
$headers = array (
	'X-aws-ec2-metadata-token: '.$token );

	$url = "http://169.254.169.254/latest/meta-data/placement/public-ipv4";

	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "GET" );
	$ipAddress = curl_exec( $ch );

	$url = "http://169.254.169.254/latest/meta-data/placement/instance-id";

	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "GET" );
	$instanceID = curl_exec( $ch );

	
	// Retrieve the instance's Public IP address and Instance ID.
	
#	$ipAddress = file_get_contents('http://169.254.169.254/latest/meta-data/public-ipv4');
#	$instanceID = file_get_contents('http://169.254.169.254/latest/meta-data/instance-id');

	// Display instance metadata.
	
	echo '<hr>';
	echo '<div class="center">';
	echo '	<h3>Server Information</h3>';
	echo '	<p>IP Address: ' . $ipAddress . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Region/Availability Zone: ' . $az . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Instance ID: ' . $instanceID . '</p>';
	echo '</div>';
}

?>