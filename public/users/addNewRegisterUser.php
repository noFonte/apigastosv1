<?php
require_once("../../vendor/autoload.php");
use Settings\Libs\Libs;
use Settings\Http\Response;
use Settings\Resources\StringValues;
use Settings\Validate\GenericsValidate;
use Expenses\DomainSpending\Entity\UserEntity;
use Expenses\DomainSpending\Repository\PostGres;
use Expenses\DomainSpending\Users\UsersDomainContext;
 

try {
    $usersController = new UsersDomainContext(new PostGres());
    $InputValidate = new GenericsValidate();
    $inputObrigatorio = array("nome", "email", "password");
    if (!Libs::isData($_POST, $inputObrigatorio)) {
        new Response(202, sprintf(StringValues::$_OBRIGATORIO_INPUT_REQUEST, implode(" OU ", $inputObrigatorio)), true);
    }
    if (!Libs::isData($_POST, $inputObrigatorio)) {
        new Response(202, sprintf(StringValues::$_OBRIGATORIO_INPUT_REQUEST, implode(" OU ", $inputObrigatorio)), true);
    }
    $InputValidate->obrigatorio($_POST["nome"], sprintf(StringValues::$_OBRIGATORIO, "nome"));
    $InputValidate->obrigatorio($_POST["email"], sprintf(StringValues::$_OBRIGATORIO, "email"));
    $InputValidate->obrigatorio($_POST["password"], sprintf(StringValues::$_OBRIGATORIO, "password"));
    if ($InputValidate->has()) {
        new Response(202, $InputValidate->getErrors(), true);
    }
    $isUserValid = $usersController->findByEmail($_POST["email"]);
    if (count($isUserValid) !== 0) {
        new Response(202, StringValues::$_EMAIL_UUID_NOT_INVALIDATE, true);
    }
    $useNew = new UserEntity();
    $useNew->setNome($_POST["nome"]);
    $useNew->setEmail($_POST["email"]);
    $useNew->setPassword($_POST["password"]);
    $useNew->setSituacao(StringValues::$_OBRIGATORIO_STATUS[0]);
    new Response(201, $usersController->insert($useNew)->toJson());
} catch (Exception $e) {

    new Response($e->getCode(), $e->getMessage());
}





?>