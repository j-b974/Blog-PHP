<?php
    require dirname(__DIR__,2).DIRECTORY_SEPARATOR.'vendor/autoload.php';

    use app\application\{Connection,Post_Class,Object_jb};
    use app\html_form\{Form_Class};
    use app\Validateur\ValideurPost;
    use app\Table\{Post_Table,Categorie_Table};
    use app\Verification\Verification_Class;

    Verification_Class::verification_connection();

    $post = new Post_Class();
    $bdd = Connection::connection();
    $TCat = new Categorie_Table($bdd);

    $error =[];

    if(isset($_POST['cree']))
    {
        $Tpost = new Post_Table($bdd);
        $v = new ValideurPost($_POST , $Tpost, $post->get_id(),$TCat->get_liste_cat());
        if($v->valideur())
        {   
            Object_jb::hydrater($post,$_POST,['nom','slug','contenu','date']);
            $Tpost->creat($post, $_POST['categorie']);
            header('Location:'.$router->url('admin_modif',['slug'=>$post->get_slug(),'id'=>$post->get_id()]).'?creation=success');
            exit();

        }else
        {
            $error = $v->get_errors();
        }
    }
    $form = new Form_Class($post, $error);
    $link = $router->url('admin_creat');

?>

<?php ob_start() ?>

<h1 class="text-center">Creation de Post</h1>
    <?php if(!empty($error)) :?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Erreur</strong> le formulaire n'est pas valide !!!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
<form action="<?= $link ?>" method="post">

    <?= $form->get_input('nom','Le Titre')?>
    <?= $form->get_input('slug','Le Slug')?>
    <?= $form->select_Cat('categorie','Liste Des Catégories',$TCat->get_liste_cat()) ?>
    <?= $form->get_input('date', 'La Date de Creation')?>
    <?= $form->get_textarea('contenu','Le Contenu')?>

    <button class='btn btn-primary' type ='submit' name ='cree'>Créé </button>
</form>

<?php 

$titre = "admin | Creation de post";
$contenu = ob_get_clean();
$active = 'post';
require dirname(__DIR__,1).DIRECTORY_SEPARATOR.'Layout/Template_admin.php';