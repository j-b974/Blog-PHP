<?php

namespace app\application;

class Categorie_Class
{
    private $id;
    private $nom;
    private $slug;
    private $id_post;

    public function get_id()
    {
        return (int) $this->id;
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
    public function get_slug()
    {
        return $this->slug;
    }
    public function set_slug(string $slug):self
    {
        $this->slug = $slug;
        return $this;
    }

    public function get_id_post():int
    {
        return (int) $this->id_post;
    }
}