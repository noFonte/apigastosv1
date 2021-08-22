<?php

namespace Settings\Base;

 

class PaginationsConfigs{
    private $activePager=1;
    private $rowsPager=0;
    private $limit=5;
    private $pages=0;
    private $object=null;
    private $inicio=0;
    public function __construct($activePager,$limit=5){
        $this->activePager=($activePager==0) ? 1 : $activePager;
        $this->limit=$limit;
    }



    public function paginar(){
        $this->inicio =($this->limit > 0) ? $this->activePager - 1:0;
        $this->inicio=($this->limit > 0) ? $this->inicio * $this->limit:0;
        $this->pages=($this->limit > 0) ? ceil($this->rowsPager/$this->limit):0;
        $this->activePager=($this->limit > 0) ? $this->activePager : 0;
        $this->rowsPager=($this->limit > 0) ? $this->rowsPager : 0;


        
        return array(
            "activePager"=>$this->activePager,
            "rowsPager"=>$this->rowsPager,
            "limit"=>$this->limit,
            "pages"=>$this->pages,
            "objects"=>$this->object
        );
    }



    /**
     * Set the value of rowsPager
     *
     * @return  self
     */ 
    public function setRowsPager($rowsPager)
    {
        $this->rowsPager = $rowsPager;

        return $this;
    }

    /**
     * Get the value of inicio
     */ 
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Get the value of limit
     */ 
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set the value of object
     *
     * @return  self
     */ 
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Set the value of activePager
     *
     * @return  self
     */ 
    public function setActivePager($activePager)
    {
        $this->activePager = $activePager;

        return $this;
    }

    /**
     * Set the value of limit
     *
     * @return  self
     */ 
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }
}



?>