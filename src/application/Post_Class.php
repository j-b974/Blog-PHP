<?php
    namespace app\application;
    use app\application\Categorie_Class;
    use \DateTime;
class Post_Class
{
    private $id ;
    private $nom;
    private $contenu;
    private $slug;

    /**
     * @var Categorie_Class[]
     */
    private $list_Categorie = [];

    private $creation_date;

    public function get_id()
    {
        return (int) $this->id ;
    }
    public function get_nom()
    {
        return $this->nom ;

    }
    public function extrait_contenu()
    {
        if(\mb_strlen($this->contenu) > 60)
        {
            $arret = stripos($this->get_contenu(),'.',60);
            return mb_substr($this->get_contenu(),0,$arret).'.';
        }
        return $this->get_contenu();
    }
    public function get_contenu()
    {
        return $this->contenu ;
    }    
    public function get_slug()
    {
        return $this->slug ;

    }    
    public function get_date(): DateTime
    {
        return new DateTime($this->creation_date) ;
    }
    /**
     * @param $cat Categorie_Class
     */
    public function add_Categorie(Categorie_Class $cat)
    {
        if(!empty($cat && !in_array($cat , $this->list_Categorie)))
        {
            $this->list_Categorie[] = $cat;
        }
        else
        {
                throw new Exception("error_jb:categorie vide ou exite deja !!!", 1);
                
        }
    }
    public function set_id($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @return Categorie_Class[]
     */
    public function get_list_categorie(): ?array
    {
        return $this->list_Categorie;
    }

    /**
     * @return array id cat
     */
    public function get_list_id_cat(): ?array
    {
        $list = [];
        foreach($this->get_list_categorie() as $c)
        {
            $list[] = $c->get_id(); 
        }
        return $list;
    }
    /**
     * vide la liste des Categorie
     */
    public function set_empty_categorie()
    {
        $this->list_Categorie =[];
    }

    public function set_nom(string $nom):self
    {
        $this->nom = $nom;
        return $this;
    }
    public function set_slug(string $slug) : self
    {
        $this->slug = $slug;
        return $this;
    }
    public function set_contenu(string $contenu) : self
    {
        $this->contenu = $contenu;
        return $this;
    }   
     public function set_date( $date) : self
    {
        $this->creation_date = $date;
        return $this;
    }
}