<?php


namespace app\application;

class User_Class
{
    private $id;

    private $nom;

    private $password;

    public function get_id():int
    {
        return $this->id ;
    }
    public function set_id(int $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function get_nom()
    {
        return $this->nom;
    }
    public function set_nom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    } 
    public function get_password()
    {
        return $this->password;
    }
    public function set_password(string $password): self
    {
        $this->password = $password;
        return $this;
    }
}