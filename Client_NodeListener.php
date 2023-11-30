<?php

// --------- display all errors --------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ------------ error display ------------

defined("BR") or define("BR", "\n");

require('vendor/autoload.php');

use \PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;

$server   = '96.126.101.93';
// $server   = 'localhost';
$port = 18883;
// $clientId = rand(5, 15);
$clientId = "Client_NodeListenah_t5iko0pdeu8";
$username = "";
$password = "";
$clean_session = true;

$subscribe_topic = "milktester/#";
$publish_mach_topic = "milktester/bcast";

function load_vars()
{
  // // payload variables
  // $discovered_IMEI = "no_IMEI_id";
  // $subscribe_topic = "#";
  // $machine_regst_topic = "/registration/self";
  // $heartbeat_topic = "heartbeat/$discovered_IMEI";
  // $card_load_topic = "/card_load/$discovered_IMEI";
  // $card_check_topic = "/card_check";
  // $disp_auth_topic = "/disp_auth/$discovered_IMEI";
  // $disp_success_callback_topic = "/disp_callback/";
  // // publishing topics
  // $pub_regist_topic = "/$discovered_IMEI";
  // $pub_heartbeat_topic = "/heartbeatCback/$discovered_IMEI";
  // $pub_disp_auth_cback_topic = "/disp_authCback/$discovered_IMEI";
  // $pub_disp_callback_cback_topic = "/disp_callbackCback/$discovered_IMEI";
  // $pub_cardload_cback_topic = "/card_loadCback/$discovered_IMEI";
  // $pub_cardcheck_cback_topic = "/card_checkCallback/$discovered_IMEI";
}

$connectionSettings  = new ConnectionSettings();
$connectionSettings
  ->setUsername($username)
  ->setPassword(null)
  ->setKeepAliveInterval(60)
  ->setLastWillTopic('milktester/sys/lwt')
  ->setLastWillMessage('client ' . $clientId . ' has disconnect')
  ->setLastWillQualityOfService(1);

$mqtt = new MqttClient($server, $port, $clientId);

$mqtt->connect($connectionSettings, $clean_session);
printf("client connected\n");

$mqtt->subscribe($subscribe_topic, function ($topic, $message) use ($mqtt) {
  echo "\n --------------------------------------- \n";
  $response_topic = "milktester/lost_messages";
  $do_respond = false;

  // printf("Received message on topic [%s]: %s\n", $topic, $message);

  // JSON decode the message
  switch ($topic) {

    case "milktester/test":
      include __DIR__ . "/handler/handler_test.php";
      break;

    case "milktester/sensor/temp":
      include __DIR__ . "/handler/handler_sensor_temp.php";
      break;

    case "milktester/sensor/turbidity":
      include __DIR__ . "/handler/handler_sensor_turbidity.php";
      break;

    default:
      echo "no relevant action found. Dropping data. \n";
      echo "topic is [$topic]";
      echo $message . "\n";
  }
  // end JSON decode to functions

  if ($do_respond) {
    echo BR . "------ publishing to $response_topic ------";
    echo BR . $response_message;
    $mqtt->publish(
      $response_topic, // topic     
      $response_message, //payload //json_encode($payload)      
      1, // qos      
      false // retain
    );
    $do_respond = false;
    echo BR . "--------------- published ---------------";
  }

  echo "\n --------------------------------------- \n";
}, 0);


for ($i = 0; $i < 1; $i++) {
  $payload = array(
    'protocol' => 'tcp',
    'date' => date('Y-m-d H:i:s'),
    'client' => $clientId,
    'info' => "handler is online"
  );

  $mqtt->publish(
    // topic
    //'vendi-PHP/test',
    $publish_mach_topic,
    // payload
    json_encode($payload),
    // qos
    1,
    // retain
    false
  );

  printf("msg $i send\n");
  sleep(1);
}


$mqtt->loop(true);
