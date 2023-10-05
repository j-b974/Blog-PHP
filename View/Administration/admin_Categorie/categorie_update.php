<?php
    require dirname(__DIR__,3).DIRECTORY_SEPARATOR.'vendor/autoload.php';
    use app\application\{Connection,Object_jb,Categorie_Class};
    use app\Table\Categorie_Table;
    use app\Validateur\ValideurCategorie;
    use app\html_form\Form_class;
    use app\Verification\Verificaiton_Class;

    Verification_Class::verification_connection();

    $bdd = Connection::connection();

    $id_cat = $paramettre['id'];
    $Tab_cat = new Categorie_Table($bdd);
    $Cat = $Tab_cat->get_by_id($id_cat);

    $error = [];
    $sucess = false;
    if(isset($_POST['modif']))
    {
        $v = new ValideurCategorie($_POST,$Tab_cat,$id_cat);

        if($v->valideur())
        {
            Object_jb::hydrater($Cat,$_POST,['nom','slug']);
            $Tab_cat->update_categorie($Cat);
            $sucess = true;
        }else
        {
            $error = $v->get_errors();
        }
    }

    $iForm = new Form_class($Cat , $error);

    $link = $router->url('admin_cat_mod',['slut'=>$Cat->get_slug(),'id'=>$Cat->get_id()]);

    // var_dump($Cat);
?>

<?php ob_start() ?>

<h1 class="text-center">Modification Des Catégorie</h1>
    <?php if(!empty($error)) : ?>
        <div class="alert alert-warning">
            Erreur : Veuillez corrigé les erreurs !!!
        </div>
    <?php endif; ?>
    <?php if($sucess) :?>
        <div class="alert alert-success">
            Modification Réussit !!!
        </div>
    <?php endif; ?>
    <form action="" method="post">
        <?= $iForm->get_input('nom','Le nom du slug') ?>
        <?= $iForm->get_input('slug','Le slug')?>
        <button class="btn btn-primary" type="submit" name ='modif' >Modifié</button>
    </form>

<?php

$titre = 'admin | Catégorie';
$contenu = ob_get_clean();
$active = 'cat';

require dirname(__DIR__,2).DIRECTORY_SEPARATOR.'Layout/Template_admin.php';