<?php
    require dirname(__DIR__,2).DIRECTORY_SEPARATOR.'vendor/autoload.php';
    use app\application\{Connection,Pagination,Categorie_Class,Post_Class};
    use app\Table\{Post_Table,Categorie_Table};

    $id_cat = (int) $paramettre['id'];
    
    $bdd = Connection::connection();

    $catTable = new Categorie_Table($bdd);

    $cat = $catTable->get_by_id($id_cat);

    $postTable = new Post_Table($bdd);

    list($p , $lesPost) = $postTable->get_post_categorie($cat->get_id(),$_GET);


    $link = $router->url('categorie',['slug'=>$cat->get_slug(),'id'=>$cat->get_id()]);

    //=================================================

    // echo"<pre>";
    // var_dump($lesPost);
    // echo"</pre>";
?>

<?php ob_start();?>
<h1 class='text-center'>les Categories <?= $cat->get_nom() ?></h1>
<div class="row">
        <?php foreach($lesPost as $post) : ?>
            <div class="col-md-3">
                <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?= 'no '.$post->get_id().' '. $post->get_nom()?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">créé le <?= $post->get_date()->format('d F Y') ?></h6>
                    <p class="card-text"><?= $post->extrait_contenu() ?></p>
                    <a href="<?= $router->url('post',['slug'=>$post->get_slug(),'id'=>$post->get_id()]) ?>" class="btn btn-primary">Voir plus</a>
                </div>
                <div class="card-footer text-muted bg-info">
                        <?php foreach($post->get_list_categorie() as $c) :?>
                            <a href="<?= $router->url('categorie',['slug'=>$c->get_slug(),'id'=>$c->get_id()]) ?>" class="badge badge-pill badge-<?= color($c->get_nom()) ?>"><?= $c->get_nom() ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="d-flex justify-content-between">
       
       <?= $p->link_Precedent($link) ?>
       <?= $p->link_Suivant($link) ?>
<?php 

$contenu = ob_get_clean();
$titre = 'Categorie: '.$cat->get_nom();

require dirname(__DIR__,1).DIRECTORY_SEPARATOR.'Layout/Template.php';