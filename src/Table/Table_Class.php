<?php

namespace app\Table;
use \Exception;
use \PDO;

abstract class Table_Class
{
    protected $bdd;

    protected $Table= null;

    protected $class = null;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
        if($this->Table === null){throw new Exception("erro_jb: propriété Table n'est pas défini !!!", 1);
        }
        if($this->class === null){throw new Exception("erro_jb: propriété class n'es pas défini !!!!", 1);
        }
    }
    public function get_by_id(int $id)
    {
        $req = $this->bdd->prepare("SELECT * FROM {$this->Table} WHERE id = :id");
        $req->execute(['id'=>$id]);
        $req->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $post = $req->fetch();
        if(!$post){throw new Exception("error_jb: id post non valide !!!", 1);
        }

        return $post;

    }
    /**
     * verifie si un value exite dans la bdd
     * @param string champs
     * @param mixed valeur a rechercher
     */
    public function is_exite(string $field , $value , ?int $id = null ): ?bool
    {

        $query = "SELECT count(*) FROM {$this->Table} WHERE $field = :value " ;
        $param = ['value'=>$value];
        if($id !== null)
        {
            $query .= "AND id != :id ";
            $param['id'] =  $id;
        }
        // var_dump($param);
        $req = $this->bdd->prepare($query);
        $req->execute($param);
        return (int) $req->fetch(PDO::FETCH_NUM)[0] > 0 ;
    }

}