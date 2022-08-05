<?php
  header("Content-Type: video/vnd.mpegurl");
  header("Content-Disposition: attachment; filename=playlist.m3u");

  require __DIR__ . "/../vendor/autoload.php";

  if (file_exists(__DIR__ . "/../.env")) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "\..");
    $dotenv->load();
  }

  $playlist = json_decode(openssl_decrypt(file_get_contents("../playlist.txt"), "aes-256-cbc", base64_decode($_ENV["APP_KEY"]), $options=0, base64_decode($_ENV["APP_IV"])), true);

  $m3u = "#EXTM3U url-tvg=\"" . implode(",", $playlist["epgs"]) . "\"\n";

  foreach ($playlist["channels"] as $channel_id => $channel) {
    if ($channel["type"] == "dash") {
      $m3u .= "\n#KODIPROP:inputstream.adaptive.license_type=" . $channel["license_type"] . "\n";
      $m3u .= "#KODIPROP:inputstream.adaptive.license_key=" . $channel["license_key"];
    }

    $m3u .= "\n#EXTINF:-1 ch-number=\"" . $channel["ch_num"] . "\" tvg-id=\"$channel_id\" tvg-name=\"" . $channel["name"] . "\" tvg-logo=\"" . $channel["logo"] . "\" group-title=\"" . $channel["category"] . "\"," . $channel["name"];
    $m3u .= "\n" . $channel["stream"] . "\n";
  }

  echo $m3u;
//end playlist.php