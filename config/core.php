<?php
error_reporting(E_ALL);
date_default_timezone_set('Europe/Madrid');
$key = "JWTToken";
$issued_at = time();
$expiration_time = $issued_at + (60 * 60); // valid for 1 hour
$issuer = "http://local.api.localhost/";
