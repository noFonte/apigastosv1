<?php
require_once("../../vendor/autoload.php");
 
use Settings\Base\Jwt;
use Settings\Libs\Libs;
use Settings\Http\Response;
use Settings\Base\ResponseMensagem;
use Settings\Resources\StringValues;
use Settings\Validate\GenericsValidate;
use Expenses\DomainSpending\Repository\PostGres;
use Expenses\DomainSpending\Users\UsersDomainContext;


try {
    $usersController = new UsersDomainContext(new PostGres());
    $InputValidate = new GenericsValidate();
    $inputObrigatorio = array("email", "password");
    
    if (!Libs::isData($_POST, $inputObrigatorio)) {
        new Response(202, sprintf(StringValues::$_OBRIGATORIO_INPUT_REQUEST, implode(" OU ", $inputObrigatorio)), true);
    }
    if (!Libs::isData($_POST, $inputObrigatorio)) {
        new Response(202, sprintf(StringValues::$_OBRIGATORIO_INPUT_REQUEST, implode(" OU ", $inputObrigatorio)), true);
    }
    $InputValidate->obrigatorio($_POST["email"], sprintf(StringValues::$_OBRIGATORIO, "email"));
    $InputValidate->obrigatorio($_POST["password"], sprintf(StringValues::$_OBRIGATORIO, "password"));
    if ($InputValidate->has()) {
        new Response(202, $InputValidate->getErrors(), true);
    }
    $response = $usersController->oauth($_POST["email"], $_POST["password"]);

    if($response==null){
        $response = new ResponseMensagem(203, StringValues::$_EMAIL_PASSWORD_NOT_INVALIDATE,true);
        new Response($response->getCode(), array("user" => "", "info" => $response->getMensagens()), $response->getIsError());
    }

   

    if (!method_exists($response, 'getEmail')) {
        $response = new ResponseMensagem($response->getCode(), $response->getMensagens(), $response->getIsError());
        new Response($response->getCode(), array("user" => "", "info" => $response->getMensagens()), $response->getIsError());
    }
    $Jwt = new Jwt(StringValues::$_PRIVATE_KEY);
    $response->setJwt($Jwt->build($response->getEmail(), $response->getNome(), $response->getIdusers()));
    new Response(200, array("user" => $response->toJson(), "info" => ""));
} catch (Exception $e) {

    new Response($e->getCode(), $e->getMessage());
}
