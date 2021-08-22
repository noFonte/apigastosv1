<?php
namespace Expenses\DomainSpending\Entity;

use Expenses\DomainSpending\Repository\IEntity;

class UserEntity implements IEntity {

    private $idusers;
    private $nome;
    private $email;
    private $password;
    private $situacao;
    private $deleted_at;
    private $created_at;
    private $randUuid;
    private $jwt;
    function getJwt() {
        return $this->jwt;
    }

    function setJwt($jwt) {
        $this->jwt = $jwt;
    }

    
    function getRandUuid() {
        return md5(uniqid(rand(), true));
    }
    function setRandUuid($randUuid) {
        $this->randUuid = $randUuid;
    }

            function getCreated_at() {
        return $this->created_at;
    }

    function setCreated_at($created_at) {
        $this->created_at = $created_at;
    }

    function getIdusers() {
        return $this->idusers;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getDeleted_at() {
        return $this->deleted_at;
    }

    function setIduser($idusers) {
        $this->idusers = $idusers;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setDeleted_at($deleted_at) {
        $this->deleted_at = $deleted_at;
    }

    public function toJson() {
        $json = array(
            "idusers" => $this->getIdusers(),
            "nome" => $this->getNome(), "email" => $this->getEmail(),
            "situacao" => $this->getSituacao(),
            "deleted_at" => $this->getDeleted_at(),
            "jwt"       => $this->jwt
        );

        return $json;
    }

}
