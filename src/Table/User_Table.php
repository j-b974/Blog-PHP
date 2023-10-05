<?php

namespace app\Table;
use app\application\User_Class;
use \PDO;

class User_Table extends Table_Class
{
    protected $Table = 'users';
    
    protected $class = User_Class::class;

    public  function get_by_name(string $name) 
    {
        try 
        {
            $req= $this->bdd->prepare("SELECT * FROM {$this->Table} WHERE nom = :nom");
            $req->execute(['nom'=>$name]);
            $req->setFetchMode(PDO::FETCH_CLASS, $this->class);
            $rep = $req->fetch();
            return $rep;
            
        } catch (\Exception $e) {
            return false;
        }
    }
    public function Validation(string $name , string $password)
    {
       $user =  $this->get_by_name($name);
       if(!$user){return false;}
       if($password !== $user->get_password()){return false;}
       return true;
    }

}