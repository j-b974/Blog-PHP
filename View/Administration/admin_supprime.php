<?php

    require dirname(__DIR__,2).DIRECTORY_SEPARATOR.'vendor/autoload.php';

    use app\application\Connection;
    use app\Table\Post_Table;

    $bdd = Connection::connection();

    $id = $paramettre['id'];

    // $req = $bdd->query("DELETE FROM post WHERE id = $id");

    (new Post_Table($bdd))->delect($id);

    header('Location: '.$router->url('admin').'?action=supprimer');

    