<?php
namespace Settings\Http;

use Settings\Base\ResponseBase;

class Response extends ResponseBase{

    public function __construct($statusCode=200,$responseData="",$isError=false,$reponseParams="",$reponseErros=""){

        $sapi_type=php_sapi_name();
        $httpResponse=array(
            "code"=>$statusCode,
            "error"=>$isError,
            "data"=>$responseData,
            "params"=>$reponseParams,
            "erroBody"=>$reponseErros
        );

        if(substr($sapi_type,0,3)=='cgi'){
            header(sprintf("Status:%s",$statusCode));
        }else{
            header(sprintf("HTTP/1.1 %s",$statusCode));
        }

        header('Content-Type: application/json;charset=utf-8');
        echo json_encode($httpResponse);
        exit(0);


    }
    


}

?>