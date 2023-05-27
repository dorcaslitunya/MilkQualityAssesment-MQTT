<?php
// TODO add MQTT topics

// --------- display all errors --------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ------------ error display ------------

defined("BR") or define("BR", "\n");

require('vendor/autoload.php');

use \PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;

// $server   = '139.162.254.51';  //maabara bunifu MQTT server
$server = 'bme.kiriev.com'; //172.105.247.218
// $server   = 'localhost';
$port = 18883;
// $clientId = rand(5, 15);
$clientId = "Client_Daraja_" . rand(1000, 9999);
$username = "";
$password = "";
$clean_session = true;

// $subscribe_topic = "KIRI/#";
// $publish_mach_topic = "KIRI/node/payment";

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
  ->setLastWillTopic('KIRI/sys/lwt')
  ->setLastWillMessage('client ' . $clientId . ' has disconnect unexpectedly')
  ->setLastWillQualityOfService(1);

$mqtt = new MqttClient($server, $port, $clientId);

$mqtt->connect($connectionSettings, $clean_session);
// printf("client connected\n"); //TODO client connected or not connected should show. 

// $mqtt->subscribe($subscribe_topic, function ($topic, $message) use ($mqtt) {
//   // echo "\n --------------------------------------- \n";
//   // $response_topic = "KIRI/lost_messages";
//   // $do_respond = false;
//   // $do_continue = true;
//   // $intent = NULL;

//   // // printf("Received message on topic [%s]: %s\n", $topic, $message);

//   // // JSON decode the message
//   // switch ($topic) {

//   //   case "KIRI/mqtt/1": //Official
//   //   case "KIRI/test":
//   //   case "KIRI/test/2":
//   //     include __DIR__ . "/handler/handler_test.php";
//   //     break;

//   //   case "KIRI/node/10":
//   //   case "KIRI/node/regist":
//   //     include __DIR__ . "/handler/handler_Register.php";
//   //     // echo "----- done, exiting -----";
//   //     break;

//   //   case "KIRI/node/11":
//   //   case "KIRI/node/hbit":
//   //     include __DIR__ . "/handler/handler_HBit.php";
//   //     // echo "----- done, exiting -----";
//   //     break;

//   //   case "KIRI/mxn/pay":
//   //   case "KIRI/mxn/pay/20":
//   //     if ($message_php_arr = json_decode($message, true)) {
//   //       var_dump($message_php_arr);
//   //       $response_message_raw = array();

//   //       // extract IMEI
//   //       if (array_key_exists("imei", $message_php_arr)) {
//   //         $IMEI = $message_php_arr['imei'];
//   //       } else if (array_key_exists("IMEI", $message_php_arr)) {
//   //         $IMEI = $message_php_arr['IMEI'];
//   //       } else if (array_key_exists("im", $message_php_arr)) {
//   //         $IMEI = $message_php_arr['im'];
//   //       }

//   //       // check out relevant activity
//   //       if (array_key_exists("intent", $message_php_arr)) {
//   //         $intent = $message_php_arr['intent'];
//   //       } else if (array_key_exists("int", $message_php_arr)) {
//   //         $intent = $message_php_arr['int'];
//   //       } else if (array_key_exists("in", $message_php_arr)) {
//   //         $intent = $message_php_arr["in"];
//   //       }

//   //       if ($intent == "pay" || $intent == 20 || $topic == "KIRI/mxn/pay/20") { //20 -> request M-Pesa push. 
//   //         echo BR . "-------------------- payment handler ---------------------" . BR;

//   //         $response_topic = "KIRI/$IMEI/21";
//   //         $do_respond = true;

//   //         $response_message_raw = array();

//   //         $response_message_raw['ss'] = "x";
//   //         $response_message_raw['cd'] = "x";
//   //         // $response_message_raw['in'] = "";

//   //         $response_message = json_encode($response_message_raw);
//   //         // include '../daraja/wednesday.php';
//   //         // include $_SERVER['DOCUMENT_ROOT'] . '/daraja/tueseday.php';
//   //         // include '/var/www/html/simatechcloud.africa/public_html/malipo/tueseday.php'; -> sandbox
//   //         // include '/var/www/html/simatechcloud.africa/public_html/malipo/tueseday_live.php'; -> live
//   //         include '/var/www/html/simatechcloud.africa/public_html/malipo/malipo_push.php'; // -> live, grouped machines
//   //       }
//   //     } else {
//   //       // report why and if it is not a valid JSON.
//   //       echo "\n";
//   //       echo json_last_error_msg();
//   //       echo "\n";
//   //       echo $topic;
//   //     }
//   //     break;


//   //   case "KIRI/mxn/dsp":
//   //   case "KIRI/mxn/dsp/32":
//   //     if ($message_php_arr = json_decode($message, true)) {
//   //       var_dump($message_php_arr);

//   //       // extract IMEI
//   //       if (array_key_exists("imei", $message_php_arr)) {
//   //         $IMEI = $message_php_arr['imei'];
//   //       } else if (array_key_exists("IMEI", $message_php_arr)) {
//   //         $IMEI = $message_php_arr['IMEI'];
//   //       } else if (array_key_exists("im", $message_php_arr)) {
//   //         $IMEI = $message_php_arr['im'];
//   //       }

//   //       // check out relevant activity
//   //       if (array_key_exists("intent", $message_php_arr)) {
//   //         $intent = $message_php_arr['intent'];
//   //       } else if (array_key_exists("int", $message_php_arr)) {
//   //         $intent = $message_php_arr['int'];
//   //       } else if (array_key_exists("in", $message_php_arr)) {
//   //         $intent = $message_php_arr["in"];
//   //       } else $intent == "dsp"; //TODO clarify if this is being sent from the units.

//   //       if ($intent == "dsp" || $intent == 32) { //32 -> dispensation confirmation
//   //         echo BR . "-------------------- dispensation handler ---------------------" . BR;
//   //         include "listener/listen_to_confirm_disp.php";

//   //         // $response_message = json_encode($response_message_raw);
//   //         // $response_message = $response_disp;
//   //         // include "listener/mqttsys_mxn_dsp.php";
//   //       }
//   //     } else {
//   //       // report why and if it is not a valid JSON.
//   //       echo "\n";
//   //       echo json_last_error_msg();
//   //       echo "\n";
//   //       // echo $topic;
//   //     }
//   //     break;

//   //   case "KIRI/mxn/alarm/50":
//   //     if ($message_php_arr = json_decode($message, true)) {
//   //       include "listener/listen_to_alarms.php";
//   //     } else {
//   //       // report why and if it is not a valid JSON.
//   //       echo "\n";
//   //       echo json_last_error_msg();
//   //       echo "\n";
//   //       echo $topic;
//   //     }
//   //     break;


//   //     // Card management 
//   //   case "KIRI/mxn/crd":
//   //   case "KIRI/mxn/card":
//   //   case "KIRI/mxn/cd":
//   //   case "KIRI/usr/cd":
//   //   case "KIRI/usr/crd":
//   //   case "KIRI/usr/card":
//   //     if ($message_php_arr = json_decode($message, true)) {
//   //       var_dump($message_php_arr);

//   //       // if ($intent == "dsp" || $intent == 32) { //32 -> dispensation confirmation
//   //       echo BR . "-------------------- card handler ---------------------" . BR;
//   //       include "listener/listen_to_card_edit.php";

//   //       // $response_message = json_encode($response_message_raw);
//   //       // $response_message = $response_disp;
//   //       // include "listener/mqttsys_mxn_dsp.php";
//   //       // }
//   //     } else {
//   //       // report why and if it is not a valid JSON.
//   //       echo "\n";
//   //       echo json_last_error_msg();
//   //       echo "\n";
//   //       // echo $topic;
//   //     }
//   //     break;

//   //     // Close card management. 


//   //   default:
//   //     echo "no relevant action found. Dropping data. \n";
//   //     echo "topic is [$topic]";
//   //     echo $message . "\n";
//   // }
//   // // end JSON decode to functions

//   // if ($do_respond) {
//   //   echo BR . "------ publishing to $response_topic ------";
//   //   echo BR . $response_message;
//   //   $mqtt->publish(
//   //     // topic
//   //     $response_topic,
//   //     // payload
//   //     // json_encode($payload),
//   //     $response_message,
//   //     // qos
//   //     1,
//   //     // retain
//   //     false
//   //   );
//   //   $do_respond = false;
//   //   echo BR . "--------------- published ---------------";
//   // }

//   // echo "\n --------------------------------------- \n";
// }, 0);


// for ($i = 0; $i < 1; $i++) {
// $payload = array(
//   'protocol' => 'tcp',
//   'date' => date('Y-m-d H:i:s'),
//   'client' => $clientId,
//   'info' => "handler is online"
// );

$payload = array(
  // 'protocol' => 'tcp',
  'date' => date('Y-m-d H:i:s'),
  // 'client' => $clientId,
  'info' => "payment payload"
);

// prt
// clk
// KIRI/Node?sernu/22
$UnitSerialPort = $DataCB_Array["BillRefNumber"];
$UnitSerial = substr($UnitSerialPort, 0, -1); //Remove the last letter
$UnitPort = substr($UnitSerialPort, -1);
$publish_mach_topic = "KIRI/node/chrg/KEVC$UnitSerial/22";
$MQTT_payload = array();
// $MQTT_payload["pbl"] = $c2b_cback_response["GroupIdentity"]["ShortCode"];
// $MQTT_payload["acc"] = $DataCB_Array["BillRefNumber"];
$MQTT_payload["prt"] = $UnitPort;
$MQTT_payload["tkn"] = $DataCB_Array["TransAmount"];
// $MQTT_payload["nme"] = $DataCB_Array["FirstName"];

$mqtt->publish(
  // topic
  //'vendi-PHP/test',
  $publish_mach_topic,
  // payload
  json_encode($MQTT_payload),
  // json_encode($payload),
  // qos
  1,
  // retain  false
);

// echo "sent"; //TODO add sent to payload
// printf("msg $i send\n");
// sleep(1);
// }


// $mqtt->loop(true);
