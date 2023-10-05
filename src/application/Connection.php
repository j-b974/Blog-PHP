<?php

namespace app\application;
use \PDO;

class Connection
{
    public static function connection(): PDO
    {
        return new PDO('mysql:host=localhost;dbname=blogbdd','root','',
                        [PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION ,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC] );
    }

}