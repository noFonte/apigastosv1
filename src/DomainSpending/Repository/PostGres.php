<?php
namespace Expenses\DomainSpending\Repository;

use PDO;

class PostGres implements IDataBase{
        private $conn=null;    
        public function __construct(){
            $this->conn=new PDO("pgsql:host=localhost;port=5432;dbname=gastos;user=pguser;password=pguser");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function getInstance(){
            return $this->conn;
        }

}
