<?php

namespace app\verification;
use app\Verification\Forbyden_Exception;


class Verification_Class
{
    public static function verification_connection()
    {
        session_start();
        if(!isset($_SESSION['auth']))
        {
            throw new Forbyden_Exception("non authentifié !!!", 1);
        }
    }
}