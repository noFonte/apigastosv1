<?php

namespace Settings\Base;
class ResponseMensagem{

    private $code=200;
    private $isError =false;
    private $mensagens=array();

    public function __construct($respCode,$respMensagen,$isError=false){
        $this->code=$respCode;
        $this->mensagens[]=$respMensagen;
        $this->isError=$isError;
    }

    public function append($respMensagen){
        $this->mensagens[]=$respMensagen;
    }

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the value of isError
     */ 
    public function getIsError()
    {
        return $this->isError;
    }

    public function getMensagens()
    {
        return $this->mensagens;
    }

}

?>