<?php

namespace app\application;
use app\application\Post_Class;
use \Exception;


class Object_jb
{
    public static function hydrater($post , array $data , array $field)
    {
        foreach ($field as $key) 
        {
            $methode = 'set_'.$key;
            if(\method_exists($post,$methode))
            {
                $post->$methode($data[$key]);
            }
            else {
                throw new Exception(" methode $key n'a pas pu etre appeller !!! ", 1);
                
            }
        }
    }
    
}