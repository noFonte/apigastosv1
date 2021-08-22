<?php

namespace Expenses\DomainSpending\Repository;

interface IDataBaseActions{
    public function rowsCountAll();
    public function rowsCount($object);
    public function insert($object);
    public function findBy($object);
    public function findAll($object=null);
    public function update($object);
    public function delete($object);
}



?>