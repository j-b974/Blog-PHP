<?php

require dirname(__DIR__,3).DIRECTORY_SEPARATOR.'vendor/autoload.php';

use app\application\{Connection,Categorie};
use app\Table\Categorie_Table;


$id = $paramettre['id'];

$bdd = Connection::connection();

$Tcat = new Categorie_Table($bdd);

$rep = $Tcat->Delete_By_Id($id);

$lien = 'Location:'.$router->url('admin_cat').'?action=';

if($rep)
{
    $lien .= 'supprime';
}else{
    $lien .= 'non_supprime';
}

header($lien);
exit();




