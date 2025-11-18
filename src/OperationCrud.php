<?php

namespace Argomedia\ToDoAppComposer;

class OperationCrud
{
    protected $table;
    protected $columns = ['*'];
    protected $condition = "";
    protected $values = ['*'];

    protected $newValue = ['*'];





    public function from($table)
    {
        $this->table = $table;
        return $this;
    }

    public function select($columns = ['*'])
    {
        if (is_string($columns)) {
            $columns = [$columns];
        }
        $this->columns = $columns;
        return $this;
    }

    public function where($filter = null, $value = null)
    {
        if (empty($this->condition)) {
            $this->condition = $filter . " = " . $value;
        } else {
            $this->condition = $this->condition . " AND " . $filter . " = " . $value;
        }



        return $this;
    }


    public function insert($values = ['*'])
    {
        if (is_string($values)) {
            $values = [$values];
        }
        $this->values = $values;
        return $this;
    }

    public function edit($newValue = ['*'])
    {
        if (is_string($newValue)) {
            $newValue = [$newValue];
        }
        $this->newValue = $newValue;
        return $this;
    }

    public function getSQLInsert()
    {

        $sql = "INSERT INTO " . $this->table . " (" . implode(', ', $this->columns) . ") VALUES (" . implode(', ', $this->values) . ")";

        return $sql;
    }

    public function getSQLDelete()
    {

        $sql = "DELETE FROM " . $this->table . " WHERE " . $this->condition;

        return $sql;
    }

    public function getSQLEdit()
    {

        $sql = "UPDATE " . $this->table . " SET " . implode(', ', $this->columns) . " = " . implode(', ', $this->newValue) . " WHERE " . $this->condition;

        return $sql;
    }


    public function getSQL()
    {



        $sql = "SELECT " . implode(', ', $this->columns) . " FROM " . $this->table;

        if (!empty($this->condition)) {
            $sql .= " WHERE " . $this->condition;
        }


        return $sql;
    }

    public function execute()
    {
        $sql = $this->getSQL();
        $result = Connector::query($sql);

        return $result;
    }

    public function executeInsert()
    {
        $sql = $this->getSQLInsert();
        $result = Connector::query($sql);

        return $result;
    }

    public function executeEdit()
    {
        $sql = $this->getSQLEdit();
        $result = Connector::query($sql);

        return $result;
    }

    public function executeDelete()
    {
        $sql = $this->getSQLDelete();
        $result = Connector::query($sql);

        return $result;
    }


}
