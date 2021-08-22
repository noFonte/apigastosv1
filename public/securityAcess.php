<?php

require_once(__DIR__ . "./../vendor/autoload.php");


use Settings\Base\Jwt;
use Settings\Http\Response;
use Settings\Base\ResponseMensagem;
use Settings\Resources\StringValues;

$USER_ACTIVE_INFO = null;
if (isset($_SERVER["HTTP_AUTHORIZATIONTOKEN"])) {
    $token = $_SERVER["HTTP_AUTHORIZATIONTOKEN"];
    $jwt = new Jwt(StringValues::$_PRIVATE_KEY);
    if (!$jwt->validate($token)) {
        $response = new ResponseMensagem(203, StringValues::$_JWT_NOT_AUTORIZED);
        new Response($response->getCode(), array("info" => $response->getMensagens()), $response->getIsError());
    }
    $USER_ACTIVE_INFO=$jwt->getPayLoadInfo();
} else {
    $response = new ResponseMensagem(203, StringValues::$_JWT_NOT_AUTORIZED);
    new Response($response->getCode(), array("info" => $response->getMensagens()), $response->getIsError());
}