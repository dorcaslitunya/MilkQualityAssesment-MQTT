<?php
$response_topic = "milklistener/test";
$do_respond = true;

if ($message_php_arr = json_decode($message, true)) {
  var_dump($message_php_arr);

  $response_message_raw = array();
  $response_message_raw['succ'] = 1;
  $response_message_raw['code'] = 1;
  $response_message_raw['info'] = "Listener is active";
  $response_message = json_encode($response_message_raw);
} else {
  // report why and if it is not a valid JSON.
  $response_message_raw = array();
  $response_message_raw['succ'] = 0;
  $response_message_raw['code'] = 0;
  $response_message_raw['info'] = json_last_error_msg();
  $response_message = json_encode($response_message_raw);
}
