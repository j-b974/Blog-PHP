<?php

namespace app\Table;

use app\Table\Categorie_Table;
use app\application\{Pagination,Post_Class};

use \PDO;


class Post_Table extends Table_Class
{
    protected $Table = 'post';

    protected $class = Post_Class::class;

    public function get_post_paginer(array $get) : array
    {
        $req= 'SELECT * FROM post ';

        $count ='SELECT COUNT(*) FROM post ';

        $p = new Pagination( $req ,  $count , $this->bdd ,$get);

        $lesPost = $p->generate(Post_Class::class);

        //=====================================
        //          hydrater liste de categorie pour chaque post

        (new Categorie_Table($this->bdd))->hydrater_list_categorie($lesPost);

        return [$p, $lesPost];
    }
    public function get_post_categorie(int $id_categorie, array $get) : array
    {
        $req = 'SELECT p.* FROM post_categorie AS pc
        LEFT JOIN post AS p ON p.id = pc.id_post
        WHERE pc.id_categorie = '.$id_categorie;

        $count = 'SELECT COUNT(*) FROM post_categorie WHERE id_categorie = '.$id_categorie;

        $p = new Pagination($req, $count , $this->bdd,$get);

        $lesPost = $p->generate(Post_Class::class);

        (new Categorie_Table($this->bdd))->hydrater_list_categorie($lesPost);

        return [$p,$lesPost];

    }
    public function delect(int $id)
    {
        $this->bdd->exec("DELETE FROM {$this->Table} WHERE id = $id");
    }
    /**
     * @param $post Post_Class
     */
    public function modifie($post , array $id_categorie)
    {
        $req = $this->bdd->prepare(" UPDATE {$this->Table} SET nom = :nom , contenu = :contenu , slug = :slug , creation_date = :date WHERE id = {$post->get_id()}");
        $req->execute(['nom'=>$post->get_nom(),
                                'contenu'=>$post->get_contenu(),
                                'slug'=>$post->get_slug(),
                                'date'=>$post->get_date()->format('Y-m-d h:i:s')
                        ]);
        $reqCat = $this->bdd->prepare("DELETE FROM post_categorie WHERE id_post = :p_id ");

        $reqCat->execute(['p_id'=>$post->get_id()]);
        
        $this->insert_categorie($post->get_id(),$id_categorie);

    }
    public function creat(Post_Class $post, array $liste_id_cat) :void
    {
        $req = $this->bdd->prepare("INSERT INTO {$this->Table} 
                                    SET nom = :nom , slug = :slug , contenu = :contenu , creation_date = :d ");
        $rep = $req->execute(['nom'=>$post->get_nom(),
                        'slug'=>$post->get_slug(),
                        'contenu'=>$post->get_contenu(),
                        'd'=>$post->get_date()->format('Y-m-d h:i:s')]);
        if(!$rep)
        {throw new Exception("erreur :la creation de post n'a pas pu se faire", 1);
        }
        $post->set_id($this->bdd->lastInsertId());
        $this->insert_categorie($post->get_id(),$liste_id_cat);
    }
    private function insert_categorie(int $id_post , array $liste_id_cat)
    {
        $reqCat = $this->bdd->prepare("INSERT INTO post_categorie 
                                        SET id_post = :p_id , id_categorie = :c_id");
        foreach ($liste_id_cat as $value)
        {
            $reqCat->execute(['p_id'=>$id_post,'c_id'=>$value]);
        }
    }
}