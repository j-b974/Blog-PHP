<?php

namespace app\application;
use \PDO;


class Pagination
{

    private $bdd ;

    private $get;

    private $req;

    private $count;

    private $maxpage;



    public function __construct(string $req , string $count , PDO $bdd , ?array $get = null)
    {
        $this->bdd = $bdd;
        $this->get = $get;
        $this->req = $req;
        $this->count = $count;
        $this->maxpage = ceil($this->count()/12);

    }
    public function generate($objet): array
    {
        $countall = $this->count();
    
        $Maxpage = ceil($countall/12);
    
        $page = ($this->get_current_page() -1)*12;
    
        $req = $this->bdd->query(" {$this->req} ORDER BY id DESC LIMIT 12 OFFSET $page");
        $req->setFetchMode(PDO::FETCH_CLASS , $objet);

        return $req->fetchAll();
    }
    public function get_current_page(): int
    {
        return (int) ($this->get['page']?? 1) ;
    }

    public function count()
    {
        if(isset($this->nb_champ)&& !empty($this->nb_champ)){return $this->nb_champ;}
         $this->nb_champ = (int) $this->bdd->query("{$this->count}")->fetchColumn();
         return $this->nb_champ;
    }
    public function link_Precedent($lien): ?string 
    {
         if($this->get_current_page() >1 && $this->maxpage >= $this->get_current_page() )
        {
            $lien .= '?page='.($this->get_current_page() - 1);
             return <<<html
            <a class="btn btn-primary" href="$lien"><<< Précédent </a>
html;
         }
         return null;

    }
    public function link_Suivant($lien)
    {
        if( $this->maxpage > 1 && $this->maxpage > $this->get_current_page() )
        {
            $lien .= '?page='.($this->get_current_page() + 1);
            return <<<html
            <a class="btn btn-primary ml-auto" href="$lien"> Suivant >>> </a>
html;
         }
         return null;
    }
}