<?php 
    require dirname(__DIR__,2).DIRECTORY_SEPARATOR.'vendor/autoload.php';
    use app\application\{Connection,Pagination};
    use app\verification\Verification_Class;
    use app\Table\Post_Table;

    Verification_Class::verification_connection();

    $bdd= Connection::connection();

    $Tpost= new Post_Table($bdd);

    list($pgt, $lesPost)= $Tpost->get_post_paginer($_GET);

    $link = $router->url('admin');

?>
<?php ob_start() ?>

<h1 class="text-center">administration</h1>
    <?php if(isset($_GET['action'])&& $_GET['action']==='supprimer') : ?>
        <div class="alert alert-success">le Post a bien était supprimé !!!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </div>
    <?php endif; ?>
<div class="d-flex justify-content-end">
        <a data-toggle="tooltip" data-placement="top" title="Creation de post" href="<?= $router->url('admin_creat')?>" ><img src='img/i_gear-64.png' alt='roue denté'></a>
</div>
<div class="row">
    <table class="table table-striped table-hover table-dark table-bordered text-center">
        <thead  >
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>date Création</th>
                <th colspan ="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lesPost as $post) : ?>
                <tr>
                    <th><?= $post->get_id() ?></th>
                    <td><?= $post->get_nom() ?></td>
                    <td><?= $post->get_date()->format('d F Y') ?></td>
                    <td>
                        <form method='POST' action='<?= $router->url('admin_modif',['slug'=>$post->get_slug(),'id'=>$post->get_id()]) ?>'>
                            <button class="btn btn-warning" type="submit">Modifié </button>
                        </form>
                    </td>
                    <td>
                        <form method='POST' action='<?= $router->url('admin_supprime',['slug'=>$post->get_slug(),'id'=>$post->get_id()]) ?>'>
                            <button class="btn btn-danger" type="submit">Supprimé </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-between">
    <?= $pgt->link_Precedent($link) ?>
    <?= $pgt->link_Suivant($link) ?>
</div>

<?php 

$contenu = ob_get_clean();
$titre = "Blog | administration";
$active = 'post';

require dirname(__DIR__,1).DIRECTORY_SEPARATOR.'Layout/Template_admin.php';