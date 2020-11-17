<?php

include_once '/Applications/XAMPP/xamppfiles/htdocs/API/config/core.php';
include_once '/Applications/XAMPP/xamppfiles/htdocs/API/lib/php-jwt-master/src/BeforeValidException.php';
include_once '/Applications/XAMPP/xamppfiles/htdocs/API/lib/php-jwt-master/src/ExpiredException.php';
include_once '/Applications/XAMPP/xamppfiles/htdocs/API/lib/php-jwt-master/src/SignatureInvalidException.php';
include_once '/Applications/XAMPP/xamppfiles/htdocs/API/lib/php-jwt-master/src/JWT.php';

function validatonJWT($jwt)
{
    if ($jwt) {
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            return true;
        } catch (Exception $e) {
            return false;
        }
    } else {
        return false;
    }
}
