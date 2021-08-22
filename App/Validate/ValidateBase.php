<?php

namespace Settings\Validate;

class ValidateBase{

    protected $errors=array();
    protected $isError=false;
    public function pushError($messagen){
        $this->errors[]=$messagen;
    }
    public function has(){
        $this->isError=(count($this->errors) !=0) ? true:false;
        return $this->isError;
    }
    public function getErrors(){
        return $this->errors;   
    }
    public  function isEmpty($objetc){
    
        if(gettype($objetc)==="string"){
            return (strlen(trim($objetc)) > 0)  ? true:false ;
        }else if(gettype($objetc)==="integer"){
            return true;
        }else if(gettype($objetc)==="NULL"){
            return false;
        }else if(gettype($objetc)==="array"){
            return (count($objetc) > 0) ? true:false;
        }else if(gettype($objetc)==="double"){
            return true;
        }
        
        
    }

}
