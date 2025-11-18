<?php 

namespace Argomedia\ToDoAppComposer;

interface DbI { 

    public function connect();
    public function query($query);
    
}