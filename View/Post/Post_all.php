<?php 
    require_once dirname(__DIR__,2).DIRECTORY_SEPARATOR.'vendor/autoload.php';
    use app\application\{Post_Class,Connection};

    use app\Table\Post_Table;

    $bdd = Connection::connection();

    $TablePost = new Post_Table($bdd);

    list($p , $lesPost )= $TablePost->get_post_paginer($_GET);
    // echo"<pre>";
    // var_dump($liste_cat);
    // echo"</pre>";

    $link = $router->url('Posts');


?>

<?php ob_start() ?>

<h1 class="text-center">liste des Postes</h1>
    <?php if(isset($_GET['tentative_auth'])): ?>
        <div class="alert alert-warning text-center">Vous devez etre Authentifié !!!</div>
    <?php endif; ?>
    <div class="row">
        <?php foreach($lesPost as $post) : ?>
            <div class="col-md-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title"><?= 'no '.htmlentities($post->get_id()).' '. htmlentities($post->get_nom())?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">créé le <?= htmlentities($post->get_date()->format('d F Y')) ?></h6>
                        <p class="card-text"><?= htmlentities($post->extrait_contenu()) ?></p>
                        <a href="<?= $router->url('post',['slug'=>htmlentities($post->get_slug()),'id'=>htmlentities($post->get_id())]) ?>" class="btn btn-primary">Voir plus</a>
                    </div>
                    <div class="card-footer text-muted bg-info">
                        <?php foreach($post->get_list_categorie() as $c) :?>
                            <a href="<?= $router->url('categorie',['slug'=>htmlentities($c->get_slug()),'id'=>htmlentities($c->get_id())]) ?>" class="badge badge-pill badge-<?= color(htmlentities($c->get_nom())) ?>"><?= htmlentities($c->get_nom()) ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="d-flex justify-content-between">
       
       <?= $p->link_Precedent($link) ?>
       <?= $p->link_Suivant($link) ?>

    </div>


<?php 

$contenu = ob_get_clean();

$titre = 'Blog | Post';

session_start();

$template = !isset($_SESSION['auth']) ? 'Template' : 'Template_admin';

require dirname(__DIR__,1).DIRECTORY_SEPARATOR.'Layout/'.$template.'.php';