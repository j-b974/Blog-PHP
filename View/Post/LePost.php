<?php

    require dirname(__DIR__,2).DIRECTORY_SEPARATOR.'vendor/autoload.php';
    use app\application\{Connection,Post_Class,Categorie_Class};
    use app\Table\{Post_Table, Categorie_Table};

    $bdd = Connection::connection();

    $id = (int) $paramettre['id'];
    $slug = htmlentities($paramettre['slug']);


    $post_Table = new Post_Table($bdd);

    $post = $post_Table->get_by_id($id);

    (new Categorie_Table($bdd))->hydrater_list_categorie([$post]);


  //========================================
  //   redirection vers correct slug

    if($post->get_slug() !== $slug)
    {
        header('Location:'.$router->url('post',['slug'=>$post->get_slug(),'id'=>$post->get_id()]));
        exit();
    }
?>
<?php ob_start(); ?>

<h1 class='text-center '>le poste no <?= $post->get_id() ?></h1>
<div class="card">
  <h5 class="card-header text-center bg-info"><?= $post->get_nom() ?></h5>
  <div class="card-body bg-dark text-white">
    <h5 class="card-title"><em>Créé le <?= $post->get_date()->format('d F Y') ?></em></h5>
    <p class="card-text"><?= nl2br($post->get_contenu()) ?></p>
    <div class="card-footer text-muted bg-info">
        <?php foreach($post->get_list_categorie() as $c) :?>
          <a href="<?= $router->url('categorie',['slug'=>$c->get_slug(),'id'=>$c->get_id()]) ?>" class="badge badge-pill badge-<?= color($c->get_nom()) ?>"><?= $c->get_nom() ?></a>
        <?php endforeach; ?>
    </div>
  </div>
</div>

<?php 

$contenu = ob_get_clean();
$titre = 'Post : '.$post->get_nom();

require dirname(__DIR__,1).DIRECTORY_SEPARATOR.'Layout/Template.php';