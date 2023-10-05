<?php

require dirname(__DIR__,1).DIRECTORY_SEPARATOR.'vendor/autoload.php';

use app\application\Routeur;

$View = dirname(__DIR__,1).DIRECTORY_SEPARATOR.'View';
$router = new Routeur($View);

if(isset($_GET['page'])&& $_GET['page']==1)
{
        $url = explode('?',$_SERVER['REQUEST_URI'])[0];
        $get = $_GET;
        unset($get['page']);

        if(!empty($get))
        {
                $url .='?'.http_build_query( $get);
        }
        header('Location:'.$url);
        exit();
}

$router->Get('/Blog-Post','Post/Post_all','Posts')
        ->Get('/','Post/Post_all')
        ->Get('/Blog-Post/Post/[*:slug]/[i:id]','Post/LePost','post')
        ->Get('/Blog-Categorie/[*:slug]/[i:id]','Categorie/categorie','categorie')
        //==========================
        //      router article administration
        ->Get('/Blog-Administration','Administration/administration','admin')
        ->GetPost('/Blog-Administration/Supprime-Post/[*:slug]/[i:id]','Administration/admin_supprime','admin_supprime')
        ->GetPost('/Blog-Administration/Modifier-Post/[*:slug]/[i:id]','Administration/admin_modif','admin_modif')
        ->GetPost('/Blog-Administration/Creation-Post','Administration/admin_creation','admin_creat')
        //===========================
        //        route categorie adminstration
        ->GetPost('/Blog-Administration/Categorie','Administration/admin_Categorie/admin_categorie','admin_cat')
        ->GetPost('/Blog-Admin/Categori-Modifie/[*:slug]/[i:id]','Administration/admin_Categorie/categorie_update','admin_cat_mod')
        ->GetPost('/Blog-Admin/Efface/[*:slug]/[i:id]','Administration/admin_Categorie/categorie_supp','admin_cat_supp')
        ->GetPost('/Blog-Admin/Creation-Categorie','Administration/admin_Categorie/categorie_creat','cat_creat')
        //===========================
        //         route login
        ->GetPost('/Blog-Login','Authentification/Login','blog_login')
        ->GetPost('/Blog-Logout','Authentification/Logout','blog_logout');

$router->Run();