<?php

namespace Argomedia\ToDoAppComposer;

class MySQL implements DbI
{

    private $connection;

    public function connect()
    {
        $servername = "localhost";
        $username = "root";
        $password = "13579Matteo";
        $dbname = "to-do-app-composer";

        try {
            // Creazione della connessione
            $conn = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            // Imposta la modalità di errore su eccezione
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);


            $this->connection = $conn;
        } catch (\PDOException $e) {
            echo "Errore di connessione: " . $e->getMessage();
            die(); // Interrompe lo script in caso di errore
        }
    }

    public function query($query)
    {
        if (!isset($this->connection)) {

            $this->connect();
        }
        return $this->connection->query($query);
    }
}
