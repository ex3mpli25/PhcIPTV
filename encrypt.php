<?php
  require __DIR__ . "/vendor/autoload.php";

  if (file_exists(".env")) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
  }

  $ciphertext = openssl_encrypt(file_get_contents("playlist_raw.json"), "aes-256-cbc", base64_decode($_ENV["APP_KEY"]), $options=0, base64_decode($_ENV["APP_IV"]));
  file_put_contents("playlist.txt", $ciphertext);
//end encrypt.php