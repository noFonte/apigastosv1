<?php

namespace Expenses\DomainSpending\Users;

use Exception;
use Settings\Base\ResponseMensagem;
use Settings\Resources\StringValues;
use Expenses\DomainSpending\Entity\UserEntity;
use Expenses\DomainSpending\Repository\IDataBase;
use Expenses\DomainSpending\Repository\IDataBaseActions;
use Settings\Libs\Libs;

class UsersDomainPostGres implements IDataBaseActions {

    private $repository = null;

    public function __construct(IDataBase $IDataBase) {
        $this->repository = $IDataBase;
    }

    private function generatorPassword($password) {
        return md5($password);
    }

    public function rowsCountAll() {
        $usersRows = 0;
        try {
            $sql = "select  count(*) as qtrows from users where deleted_at IS NULL   ";
            $stmt = $this->repository->getInstance()->prepare($sql);
            if ($stmt->execute()) {
                $fetchAllType = $stmt->fetch();
                $usersRows = $fetchAllType["qtrows"];
            } else {
                throw new Exception(StringValues::$_ERRO_SQL, 500);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
        return $usersRows;
    }

    public function rowsCount($object) {
        
    }

    public function insert($object) {
        try {
            $isUserCode = $this->findByEmail($object->getEmail());
            if (count($isUserCode) == 0) {
                $uuid = $object->getRandUuid();
                $password = sprintf("%s%s%s", $object->getEmail(), $object->getPassword(), $uuid);
                $sql = "INSERT INTO users(nome,email,password,situacao,created_at,randUuid) ";
                $sql .= " values(:nome,:email,:password,:situacao,now(),:randUuid)";
                $stmt = $this->repository->getInstance()->prepare($sql);
                $stmt->bindParam(":nome", $object->getNome());
                $stmt->bindParam(":email", $object->getEmail());
                $stmt->bindParam(":password", $this->generatorPassword($password));
                $stmt->bindParam(":situacao", $object->getSituacao());
                $stmt->bindParam(":randUuid", $uuid);
                if ($stmt->execute()) {
                    return $this->findBy($this->repository->getInstance()->lastInsertId());
                } else {
                    throw new Exception(StringValues::$_ERRO_SQL, 500);
                }
            }
            throw new Exception(sprintf(StringValues::$_DUPLICIDADE, "Uuid"), 406);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function findByEmail($object) {
        $users = [];
        try {
            $sql = "select  iduser, nome, email, situacao,deleted_at,created_at from users ";
            $sql .= " where email=:email and deleted_at IS NULL ";
            $stmt = $this->repository->getInstance()->prepare($sql);
            $stmt->bindParam(":email", $object);
            $stmt->execute();
            $fetchAllUsers = $stmt->fetchAll();
            foreach ($fetchAllUsers as $key => $user) {
                $userEntity = new UserEntity();
                $userEntity->setiduser($user["iduser"]);
                $userEntity->setNome($user["nome"]);
                $userEntity->setEmail($user["email"]);
                $userEntity->setSituacao($user["situacao"]);
                $userEntity->setDeleted_at($user["deleted_at"]);
                $userEntity->setCreated_at($user["created_at"]);
                $users[] = $userEntity;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
        return $users;
    }

    public function findBy($object) {
        $users = [];
        try {
            $sql = "select  iduser, nome, email, situacao,deleted_at,created_at from users ";
            $sql .= " where iduser=:uuid and deleted_at IS NULL ";
            $stmt = $this->repository->getInstance()->prepare($sql);
            $stmt->bindParam(":uuid", $object);
            $stmt->execute();
            $fetchAllUsers = $stmt->fetchAll();
            foreach ($fetchAllUsers as $key => $user) {
                $userEntity = new UserEntity();
                $userEntity->setiduser($user["iduser"]);
                $userEntity->setNome($user["nome"]);
                $userEntity->setEmail($user["email"]);
                $userEntity->setSituacao($user["situacao"]);
                $userEntity->setDeleted_at($user["deleted_at"]);
                $userEntity->setCreated_at($user["created_at"]);
                $users[] = $userEntity;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
        return $users;
    }

    public function findAll($object = null) {
        $users = [];
        try {
            if (is_null($object) || $object->getLimit() == 0) {
                $sql = "select  iduser, nome, email, situacao,deleted_at,created_at  from users where deleted_at IS NULL ";
                $stmt = $this->repository->getInstance()->prepare($sql);
            } else {
                $object->setRowsPager($this->rowsCountAll());
                $object->paginar();
                $sql = "select  iduser, nome, email, situacao,deleted_at,created_at  from users ";
                $sql .= "  limit " . $object->getInicio() . "," . $object->getLimit() . "";
                $stmt = $this->repository->getInstance()->prepare($sql);
              
            }
            $stmt->execute();
            $fetchAllUsers = $stmt->fetchAll();
            foreach ($fetchAllUsers as $key => $user) {
                $userEntity = new UserEntity();
                $userEntity->setiduser($user["iduser"]);
                $userEntity->setNome($user["nome"]);
                $userEntity->setEmail($user["email"]);
                $userEntity->setSituacao($user["situacao"]);
                $userEntity->setDeleted_at($user["deleted_at"]);
                $userEntity->setCreated_at($user["created_at"]);
                $users[] = $userEntity;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
        return $users;
    }

    public function update($object) {
        try {
            $sql = "UPDATE users set  type, descricao, cep,local,valor,obs,situacao ";
            $sql .= " where iduser=:id  ";
            $stmt = $this->repository->getInstance()->prepare($sql);
            $stmt->bindParam(":type", $object->getType());
            $stmt->bindParam(":descricao", $object->getDescricao());
            $stmt->bindParam(":cep", $object->getCep());
            $stmt->bindParam(":local", $object->getLocal());
            $stmt->bindParam(":valor", $object->getValor());
            $stmt->bindParam(":obs", $object->getObs());
            $stmt->bindParam(":situacao", $object->getSituacao());
            $stmt->bindParam(":id", $object->getiduser());
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    return new ResponseMensagem(200, StringValues::$_UPDATE_SQL);
                }
                return new ResponseMensagem(406, StringValues::$_UPDATE_NOT_SQL);
            } else {
                throw new Exception(StringValues::$_ERRO_SQL, 500);
            }
        } catch (Exception $e) {

            throw new Exception($e->getMessage(), 500);
        }
    }

    public function delete($object) {
        try {
            $sql = "update  users set deleted_at=now()  where iduser=:id ";
            $stmt = $this->repository->getInstance()->prepare($sql);
            $stmt->bindParam(":id", $object->getiduser());
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    return new ResponseMensagem(200, StringValues::$_DELETE_SQL);
                }
                return new ResponseMensagem(406, StringValues::$_DELETE_NOT_SQL);
            } else {
                throw new Exception(StringValues::$_ERRO_SQL, 500);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function oauth($email, $password) {
    
        $user =null;
        try {
            $sql = "select  iduser, nome, email, situacao,deleted_at,created_at,randUuid,password from users ";
            $sql .= " where email=:email and deleted_at IS NULL ";
            $stmt = $this->repository->getInstance()->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $fetchAllUser = $stmt->fetch();
        

            if ($fetchAllUser != null) {
                $passwordStore=$fetchAllUser["password"];
                $randUuidStore=$fetchAllUser["randuuid"];
                $userEntity = new UserEntity();
                $userEntity->setiduser($fetchAllUser["iduser"]);
                $userEntity->setNome($fetchAllUser["nome"]);
                $userEntity->setEmail($fetchAllUser["email"]);
                $userEntity->setSituacao($fetchAllUser["situacao"]);
                $userEntity->setDeleted_at($fetchAllUser["deleted_at"]);
                $userEntity->setCreated_at($fetchAllUser["created_at"]);
                $userEntity->setRandUuid(null);
                $passwordNew =$userEntity->getEmail()."".$password."".$randUuidStore;
                if($passwordStore!=$this->generatorPassword($passwordNew)){
                      return new ResponseMensagem(404, StringValues::$_EMAIL_PASSWORD_NOT_INVALIDATE);
                }
                $user=$userEntity;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
        return $user;
    }

}
