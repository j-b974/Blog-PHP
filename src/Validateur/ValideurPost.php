<?php

namespace app\Validateur;
use app\Table\Post_Table;

class ValideurPost extends Valideur_class
{

    public function __construct($data,  Post_Table $Tpost , int $id, array $categorie)
    {
        parent::__construct($data);
        $this->validator->rule('required',['nom','slug','date','contenu','categorie']);
        $this->validator->rule('lengthBetween','nom', 3 , 50);
        $this->validator->rule('slug','slug');
        $this->validator->rule('subset','categorie',array_keys($categorie) );
        $this->validator->rule(
            function($field, $value) use ($Tpost, $id) {
                return !$Tpost->is_exite($field , $value, $id ) ;
            } ,['slug','nom'],' éxite déjà en base de donnée !!!'
        );
    }

}