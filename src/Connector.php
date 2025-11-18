<?php

namespace Argomedia\ToDoAppComposer;

class Connector
{

    private static $connection;

    public static function useDb()
    {
            
    }

    public static function query($query)
    {
        return  (new MySQL())
        ->query($query) ;
    }
}