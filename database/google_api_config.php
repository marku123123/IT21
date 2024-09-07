<?php
// google_api_config.php

require_once 'vendor/autoload.php';

//PERSONAL EMAIL AKONG GAMIT PAG CREATE SA PROJECT
// Google API client configuration
define('GOOGLE_CLIENT_ID', '686168710480-vpn6vuoviedhkthd1175ug9k99pi2gbo.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
// Google Login Project
define('GOOGLE_REDIRECT_URI', 'https://localhost/it21/redirect.php');

$client = new Google_Client();
$client->setClientId(GOOGLE_CLIENT_ID);
$client->setClientSecret(GOOGLE_CLIENT_SECRET);
$client->setRedirectUri(GOOGLE_REDIRECT_URI);
$client->addScope("email");
$client->addScope("profile");
