<?php

namespace Settings\Libs;


class Libs{

    public static function dd($object){
        echo "<pre>";
        echo "<hr>";
        print_r($object);
        echo "<hr>";
        exit();
    }

    public static function isData($requestInputs,$obrigatorioInputs){
        foreach($obrigatorioInputs as $key =>$input){
            if(!isset($requestInputs[$input])){
                return false;
            }
        }
        return true;
    }

    public static function Uuid(){
        return md5(uniqid(rand(),true));
    }

    public static function isEmpty($object){
        if(gettype($object)==="string"){
            return (strlen(trim($object)) > 0) ? true:false;
        }else if(gettype($object)==="integer"){
            return true;
        }else if(gettype($object)==="NULL"){
            return false;
        }else if(gettype($object)==="array"){
            return (count($object) > 0) ? true:false;
        }else if(gettype($object)==="double"){
            return true;
        }

        return false;
    }



}





?>