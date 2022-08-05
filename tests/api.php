<?php
  require __DIR__ . "/../vendor/autoload.php";

  if (file_exists(__DIR__ . "/../.env")) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "\..");
    $dotenv->load();
  }

  //select a server to test: production|staging|local
  switch ($_GET["server"] ?? "local") {
    case "production":
      $server = "https://api-acdc.herokuapp.com/";
      break;
    case "staging":
      $server = "https://api-acdc-beta.herokuapp.com/";
      break;
    default:
      $server = "http://" . $_SERVER['REMOTE_ADDR'] . "/acdc/";
  }

  //generate a valid token
  date_default_timezone_set("Asia/Manila");
  $token = hash("sha512", "FB6v!KAOQH6c909lYUc8ytmUReO^ehX1" . date("FjYGO"));

  //get channels
  $action = "get_channels";
  $request_url = "$server?token=$token&action=$action";

  function decode_payload($request_url) {
    $response = json_decode(file_get_contents($request_url), true);
    return openssl_decrypt($response["payload"], "aes-256-cbc", base64_decode($_ENV["APP_KEY"]), $options=0, base64_decode($_ENV["APP_IV"]));
  }
?>
<strong>Get channels:</strong> <a href="<?=$request_url?>"><?=$request_url?></a>
<hr />
Raw Response:
<blockquote><?=file_get_contents($request_url)?></blockquote>
Decoded Payload:
<blockquote><?=decode_payload($request_url)?></blockquote>
<?php
  //get channel
  $action = "get_channel";
  $channel_id = "PinoyXtremeChannel.ph";
  $request_url = "$server?token=$token&action=$action&channel_id=$channel_id";
?>
<strong>Get channel: <?=$channel_id?></strong> <a href="<?=$request_url?>"><?=$request_url?></a>
<hr />
Raw Response:
<blockquote><?=file_get_contents($request_url)?></blockquote>
Decoded Payload:
<blockquote><?=decode_payload($request_url)?></blockquote>
<?php
  //get categories
  $action = "get_categories";
  $request_url = "$server?token=$token&action=$action";
?>
<strong>Get categories:</strong> <a href="<?=$request_url?>"><?=$request_url?></a>
<hr />
Raw Response:
<blockquote><?=file_get_contents($request_url)?></blockquote>
Decoded Payload:
<blockquote><?=decode_payload($request_url)?></blockquote>
<?php
  //get channels by category
  $action = "get_channels_by_category";
  $category = "Kids";
  $request_url = "$server?token=$token&action=$action&category=$category";
?>
<strong>Get channels by category: <?=$category?></strong> <a href="<?=$request_url?>"><?=$request_url?></a>
<hr />
Raw Response:
<blockquote><?=file_get_contents($request_url)?></blockquote>
Decoded Payload:
<blockquote><?=decode_payload($request_url)?></blockquote>
<?php
  //get all channels in all categories
  $action = "get_channels_by_category";
  $request_url = "$server?token=$token&action=$action";
?>
<strong>Get all channels in all categories:</strong> <a href="<?=$request_url?>"><?=$request_url?></a>
<hr />
Raw Response:
<blockquote><?=file_get_contents($request_url)?></blockquote>
Decoded Payload:
<blockquote><?=decode_payload($request_url)?></blockquote>