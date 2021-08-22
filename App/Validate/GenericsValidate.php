<?php
namespace Settings\Validate;
use Settings\Validate\ValidateBase;
class GenericsValidate extends ValidateBase {
    function __construct() {
        return $this;
    }
    public function obrigatorio($value, $message = "") {
        if (!$this->isEmpty($value)) {
            $this->pushError($message);
        }
    }
    
     public function obrigatorioIsNumeric($value, $message = "") {
        if (!$this->isEmpty($value) || !is_numeric($value)) {
            $this->pushError($message);
        }
    }
    
    public function obrigatorioParam($value, $message = "", $array = []) {
        if (!$this->isEmpty($value)) {
            $this->pushError($message);
        } else if (!is_array($array) || count($array) == 0) {
            $this->pushError($message);
        } else if (!in_array($value, $array)) {
            $this->pushError($message);
        }
    }
}
