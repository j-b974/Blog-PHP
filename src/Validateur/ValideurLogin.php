<?php

namespace app\Validateur;
use app\Table\User_Table;

class ValideurLogin extends Valideur_class
{
    private $data = [];
    public function __construct($data_Post , User_Table $TUse )
    {
        parent::__construct($data_Post);
        $this->data  = $data_Post;
        $this->validator->rule('required',['nom','password']);
        if(!$this->validat($TUse))
        {
            $this->validator->rule(function($fiel,$value)
            {
                return false;
            }, ['nom','password'], 'incorrect !!!');
        }

    }
    private function validat($TUser) : bool
    {
        return $TUser->Validation($this->data['nom'],$this->data['password']);
    }
}