<?php
    require dirname(__DIR__,3).DIRECTORY_SEPARATOR.'vendor/autoload.php';

    use app\application\{Connection,Obect_jb,Categorie_Class};
    use app\Table\Categorie_Table;
    use app\Verification\Verification_Class;

    $bdd = Connection::connection();

    Verification_Class::verification_connection();

    $Tcat = new Categorie_Table($bdd);

    $allCat = $Tcat->get_Categories();

?>
    
<?php ob_start() ?>

<h1 class="text-center">Gestion des Catégorie</h1>
    <?php if(isset($_GET['action'])) : ?>
        <?php if($_GET['action'] === 'supprime') : ?>
            <div class="alert alert-success text-center">Suppression Réussit !</div>
        <?php endif ; ?>
        <?php if($_GET['action']=== 'non_supprime') : ?>
            <div class="alert alert-warning text-center">Erreur la Suppréssion n'a pas réussit !!!</div>
        <?php endif; ?>
        <?php if($_GET['action'] === 'cree') : ?>
            <div class="alert alert-success text-center">Création Réussit ! </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="d-flex justify-content-end">
        <a data-toggle="tooltip" data-placement="top" title="Creation de Categorie" href="<?= $router->url('cat_creat')?>" ><img src='../img/i_gear-64.png' alt='roue denté'></a>
    </div>
    <table class="table table-striped table-dark table-hover text-center table-bordered">
    <thead>
        <tr >
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Slug</th>
            <th colspan ="2" scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($allCat as $cat):?>
            <tr>
                <th scope="row"><?= $cat->get_id() ?></th>
                <td><?= $cat->get_nom() ?></td>
                <td><?= $cat->get_slug() ?></td>
                <td> <form action="<?= $router->url('admin_cat_mod',['slug'=>$cat->get_slug(),'id'=>$cat->get_id()]) ?>"method="POST"><button class="btn btn-warning" type="submit">Modifier</button></form></td>
                <td> <form action="<?= $router->url('admin_cat_supp',['slug'=>$cat->get_slug(),'id'=>$cat->get_id()]) ?>"method="POST"><button class="btn btn-danger" type="submit">Supprimer</button></form></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php

$titre = 'admin | Catégorie';
$contenu = ob_get_clean();
$active = 'cat';

require dirname(__DIR__,2).DIRECTORY_SEPARATOR.'Layout/Template_admin.php';


