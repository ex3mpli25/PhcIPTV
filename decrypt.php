<?php
  require __DIR__ . "/vendor/autoload.php";

  if (file_exists(".env")) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
  }

  $original_plaintext = openssl_decrypt(file_get_contents("playlist.txt"), "aes-256-cbc", base64_decode($_ENV["APP_KEY"]), $options=0, base64_decode($_ENV["APP_IV"]));
  file_put_contents("playlist_raw.json", json_encode(json_decode($original_plaintext, true), JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
//end decrypt.php