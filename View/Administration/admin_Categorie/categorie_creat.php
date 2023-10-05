<?php
    require dirname(__DIR__,3).DIRECTORY_SEPARATOR.'vendor/autoload.php';
    use app\application\{Connection,Categorie_Class,Paination,Object_jb};
    use app\html_form\Form_class;
    use app\Table\Categorie_Table;
    use app\Validateur\ValideurCategorie;
    use app\Verification\Verification_Class;


    Verification_Class::verification_connection();
    $cat = new Categorie_Class;
    $error = [];

    if(isset($_POST['cree']))
    {
        $bdd = Connection::connection();
        $Tcat = new Categorie_Table($bdd);
        $v = new ValideurCategorie($_POST , $Tcat , $cat->get_id());

        if($v->valideur())
        {
            Object_jb::hydrater($cat , $_POST,['nom','slug']);
            $Tcat->creat_cat($cat);
            header('Location:'.$router->url('admin_cat').'?action=cree');
            exit();
        }else
        {
            $error = $v->get_errors();
        }

    }

    $iform = new Form_class($cat , $error);


?>

<?php ob_start() ?>
<?php if(!empty($error)) : ?>
    <div class="alert alert-warning">Error : formulaie !</div>
<?php endif; ?>

<h1 class="text-center">Création de Catégorie</h1>
    <form action="" method="post">
    <?= $iform->get_input('nom', 'Le nom Categorie') ?>
    <?= $iform->get_input('slug','Le Slug') ?>
    <button class="btn btn-primary" type="submit" name ="cree" >Créé</button>
    </form>
<?php

$titre = 'admin | Catégorie';
$contenu = ob_get_clean();
$active = 'cat';

require dirname(__DIR__,2).DIRECTORY_SEPARATOR.'Layout/Template_admin.php';