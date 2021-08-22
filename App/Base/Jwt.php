<?php

namespace Settings\Base;

/*
  “iss” O domínio da aplicação geradora do token
  “sub” É o assunto do token, mas é muito utilizado para guarda o ID do usuário
  “aud” Define quem pode usar o token
  “exp” Data para expiração do token
  “nbf” Define uma data para qual o token não pode ser aceito antes dela
  “iat” Data de criação do token
  “jti” O id do token
 * */

class Jwt {

    private $key;
    private $alg;
    private $typ;
    private $timeExpired;
    private $payloadInfo = array();
    private $isValidate = false;
    private $methods = array("HS256" => "sha256");

    public function __construct($privateKey, $timeExpired = "", $alg = "", $type = "") {
        $this->alg = (strlen(trim($alg)) == 0) ? "HS256" : $alg;
        $this->typ = (strlen(trim($type)) == 0) ? "JWT" : $type;
        $this->timeExpired = (strlen(trim($timeExpired)) == 0) ? "+1 days" : $timeExpired;
        $this->key = $privateKey;
    }

    public function build($email, $name, $sub, $iss = "", $optional = "", $aud = "", $nbf = "", $iat = "", $jti = "") {
        $header = array(
            'alg' => $this->alg,
            'typ' => $this->typ
        );
        $header = json_encode($header);
        $header = base64_encode($header);
        $iss = (strlen(trim($iss)) == 0) ? $_SERVER['SERVER_NAME'] : "localhost";
        $exp = strtotime("now");
        $payload = array(
            'iss' => $iss,
            'sub' => $sub,
            'aud' => $aud,
            'exp' => $exp,
            'ndf' => $nbf,
            'iat' => $iat,
            'jti' => $jti,
            'name' => $name,
            'email' => $email,
            'optional' => $optional
        );
        $payload = json_encode($payload);
        $payload = base64_encode($payload);
        $signature = hash_hmac($this->methods[$this->alg], "$header.$payload", $this->key, true);
        $signature = base64_encode($signature);
        return "$header.$payload.$signature";
    }

    public function getPayLoadInfo() {
        if (!$this->isValidate)
            return null;
        return $this->payloadInfo;
    }

    public function validate($token) {
        $token = $token;
        $part = explode(".", $token);
        if (count($part) != 3) {
            return false;
        }
        $header = $part[0];
        $payload = $part[1];
        $signature = $part[2];
        $valid = hash_hmac($this->methods[$this->alg], "$header.$payload", $this->key, true);
        $valid = base64_encode($valid);
        $this->payloadInfo = json_decode(base64_decode($payload), true);
        $exp = $this->payloadInfo["exp"];
        $now = strtotime($this->timeExpired);
        $geradaEm = strtotime(date("d/m/Y  h:i:s", $exp));
        $dataAtual = strtotime(date("d/m/Y  h:i:s", $now));
        $this->isValidate = ($signature == $valid && (($dataAtual - $geradaEm) > 0));
        return $this->isValidate;
    }

}

?>