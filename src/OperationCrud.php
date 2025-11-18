<?php

namespace Argomedia\ToDoAppComposer;

class OperationCrud
{
    protected $table;
    protected $columns = ['*'];
    protected $condition = "";
    protected $values = ['*'];
    
   



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


       public function getSQLInsert()
    {
        // Correctly format the INSERT INTO query
        $sql = "INSERT INTO " . $this->table . " (" . implode(', ', $this->columns) . ") VALUES (" . implode(', ', $this->values) . ")";

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


}
