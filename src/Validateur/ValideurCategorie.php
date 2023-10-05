<?php

namespace app\Validateur;
use app\Table\Categorie_Table;

class ValideurCategorie extends Valideur_class
{
    public function __construct($dataPost , Categorie_Table $Tcat , $id)
    {
        parent::__construct($dataPost);
        $this->validator->rule('required',['nom','slug']);
        $this->validator->rule('slug','slug');
        $this->validator->rule('lengthBetween',['nom','slug'],3,50);
        $this->validator->rule(function($field,$value) use ($Tcat , $id)
                                {return !$Tcat->is_exite($field,$value,$id);},
                            ['nom','slug'],'déja utilsé');

    }
}