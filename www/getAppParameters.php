<?php

require 'aws.phar'; #AWSSDK
#require 'aws-autoloader.php';
$ch = curl_init();

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

$url = "http://169.254.169.254/latest/meta-data/placement/availability-zone";

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "GET" );
$result = curl_exec( $ch );
$az = curl_exec( $ch );

#echo "<p> RESULT :" . $result;

$region = substr($az, 0, -1);

$secrets_client = new Aws\SecretsManager\SecretsManagerClient([
  'version' => 'latest',
  'region'  => $region,
  'version' => '2017-10-17'
]);

$showServerInfo = "";
$timeZone = "";
$currency = "";
$db_url = "";
$db_name = "";
$db_user = "";
$db_password = "";

try {
  $db_url = $secrets_client->getSecretValue([
    'SecretId' => '/cafe/dbUrl'
  ]);
  $db_url = $db_url["SecretString"];
  $db_user = $secrets_client->getSecretValue([
    'SecretId' => '/cafe/dbUser'
  ]);
  $db_user = $db_user["SecretString"];
  $db_password = $secrets_client->getSecretValue([
    'SecretId' => '/cafe/dbPassword'
  ]);
  $db_password = $db_password["SecretString"];
  $db_name = $secrets_client->getSecretValue([
    'SecretId' => '/cafe/dbName'
  ]);
  $db_name = $db_name["SecretString"];
  $currency = $secrets_client->getSecretValue([
    'SecretId' => '/cafe/currency'
  ]);
  $currency = $currency["SecretString"];  
  $timezone = $secrets_client->getSecretValue([
    'SecretId' => '/cafe/timeZone'
  ]);
  $timezone = $timezone["SecretString"];  
  $showServerInfo = $secrets_client->getSecretValue([
    'SecretId' => '/cafe/showServerInfo'
  ]);
  $showServerInfo = $showServerInfo["SecretString"];  

}
catch (Exception $e) {
  $db_url = '';
  $db_name = '';
  $db_user = '';
  $db_password = '';
  $showServerInfo = '';
  $timeZone = '';
  $currency = '';
}
#error_log('Settings are: ' . $ep. " / " . $db_name . " / " . $db_user . " / " . $db_password);
?>
