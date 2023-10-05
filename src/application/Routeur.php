<?php

namespace app\application;
use \AltoRouter;
use app\verification\Verification_Class;
use app\Verification\Forbyden_Exception;
class Routeur 
{
    private $path;
    private $router;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->router = new AltoRouter();

    }
    public function GetPost(string $url , string $targer, ?string $name): self
    {
        $this->router->map('GET|POST',$url, $targer,$name);
        return $this;
    }
    public function Get(string $url , string $target , ?string $name = null): self
    {
        $this->router->map('GET', $url , $target, $name);
        return $this;
    }
    public function url(string $name , ?array $paramettre = []):string
    {
        return $this->router->generate($name, $paramettre);
    }
    public function Run()
    {

        try 
        {

            $resul = $this->router->match();
    
            if($resul)
            {
    
                $paramettre = $resul['params'];
                $router = $this;
                require $this->path.DIRECTORY_SEPARATOR.$resul['target'].'.php';
            }
            else{
                echo "url non valide !!!";
            }
        } 
         catch (Forbyden_Exception $e) 
        {
            header('Location:'.$this->url('Posts').'?tentative_auth=1');
            exit();
        }

    }
}

