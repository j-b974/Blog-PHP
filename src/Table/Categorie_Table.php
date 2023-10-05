<?php

namespace app\Table;
use app\application\{Post_Class,Categorie_Class};
use \PDO;

class Categorie_Table extends Table_Class
{
    protected $Table = 'categorie';

    protected $class = Categorie_Class::class;

    public function hydrater_list_categorie( $lesPost)
    {
        $listePoste = [];
        foreach($lesPost as $pt)
        {
            $pt->set_empty_categorie();
            $listePoste[$pt->get_id()]= $pt;
        }
        $str_listePoste = implode(',',array_keys($listePoste));

        $catreq = $this->bdd->query("SELECT c.* , pc.id_post FROM post_categorie AS pc
                            LEFT JOIN categorie AS c ON c.id = pc.id_categorie
                            WHERE pc.id_post IN ( $str_listePoste ) ");
        $catreq->setFetchMode(PDO::FETCH_CLASS , $this->class);
        $liste_cat = $catreq->fetchAll();
    
        foreach($liste_cat as $cc)
        {
            $listePoste[$cc->get_id_post()]->add_categorie($cc);
        }
    }
    public function get_Categories():array
    {
        $req = $this->bdd->query("SELECT * FROM {$this->Table}");
        $req->setFetchMode(PDO::FETCH_CLASS,$this->class);
        return $req->fetchall();
    }
    public function update_categorie(Categorie_Class $cat):void
    {
        $req = $this->bdd->prepare("UPDATE {$this->Table} SET nom = :nom , slug= :slug WHERE id = :id");
        $rep= $req->execute(['nom'=>$cat->get_nom(),
                    'slug'=>$cat->get_slug(),
                    'id'=>$cat->get_id()]);
        if(!$rep){throw new \Exception("la MAJ n'a pas pu se faitre !!!", 1);
        }
        
    }
    public function creat_cat(Categorie_Class $cat): void
    {
        $res = $this->bdd->prepare("INSERT INTO {$this->Table} SET nom= :nom, slug= :slug ");
        $rep = $res->execute(['nom'=>$cat->get_nom(),'slug'=>$cat->get_slug()]);
        if(!$rep){throw new \Exception("Erreurjb: la creation n'a pas pu se faire", 1);
        }
        $cat->set_id($this->bdd->lastInsertId());

    }
    public function delete_By_Id(int $id)
    {
        $req = $this->bdd->exec(" DELETE FROM {$this->Table} WHERE id = $id");
        return $req;
    }
    /**
     * @return liste index
     */
    public function get_liste_cat(): array
    {
        $req = $this->bdd->query("SELECT * FROM {$this->Table} ORDER BY nom ASC");
        $req->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $rep = $req->fetchAll();
        $retourne =[];
        foreach ($rep as $key => $value) {
            $retourne[$value->get_id()]= $value->get_nom();
        }
        return $retourne;
    }

}