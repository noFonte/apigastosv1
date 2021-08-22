<?php

namespace Expenses\DomainSpending\Users;

use Exception;
use Expenses\DomainSpending\Repository\IDataBase;
use Expenses\DomainSpending\Repository\IDataBaseActions;
 
class UsersDomainContext implements IDataBaseActions {

    private $UsersDomainPostGres;

    public function __construct(IDataBase $conection) {
        $this->UsersDomainPostGres = new UsersDomainPostGres($conection);
    }

    public function rowsCountAll() {
        
    }

    public function rowsCount($object) {
        
    }

    public function insert($object) {
        $users = null;
        try {
            $users = $this->UsersDomainPostGres->insert($object);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return (count($users) > 0) ? $users[0] : $users;
    }

    public function findByEmail($object) {
        $users = array();
        try {
            $users = $this->UsersDomainPostGres->findByEmail($object);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return $users;
    }

    public function findBy($object) {
        $users = array();
        try {
            $users = $this->UsersDomainPostGres->findBy($object);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return $users;
    }

    public function findAll($object = null) {
        $users = array();
        try {
            $users = $this->UsersDomainPostGres->findAll($object);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return $users;
    }

    public function update($object) {
        $retorno = null;
        try {
            $retorno = $this->UsersDomainPostGres->update($object);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return $retorno;
    }

    public function delete($object) {
        $retorno = null;
        try {
            $retorno = $this->UsersDomainPostGres->delete($object);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return $retorno;
    }

    public function oauth($email, $password) {
        $user = null;
        try {
            $user = $this->UsersDomainPostGres->oauth($email, $password);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return $user;
    }

}

?>