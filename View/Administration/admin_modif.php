<?php 

    require dirname(__DIR__,2).DIRECTORY_SEPARATOR.'vendor/autoload.php';

    use app\application\{Connection,Post_Class,Object_jb};
    use app\Table\{Post_Table,Categorie_Table};
    use app\html_form\Form_class;
    use Valitron\Validator;
    use app\Validateur\ValideurPost;
    use app\Verification\Verification_Class;

    Verification_Class::verification_connection();

    $id = $paramettre['id'];

    $bdd = Connection::connection();

    $CatTable = new Categorie_Table($bdd);

    $Tpost = new Post_Table($bdd);

    $post = $Tpost->get_by_id($id);
    $CatTable->hydrater_list_categorie([$post]);


    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $error=[];
    $success= false ;

    if(isset($_POST['modif']))
    {
        
        $v = new ValideurPost($_POST, $Tpost , $post->get_id(),$CatTable->get_liste_cat());

        // var_dump('le titre : '.$Tpost->is_exite('nom',$_POST['nom'],$post->get_id()));

        if($v->valideur())
        {
            Object_jb::hydrater($post , $_POST , ['nom','date','contenu','slug']);
            // $post->set_nom($_POST['nom'])
            //     ->set_date($_POST['date'])
            //     ->set_contenu($_POST['contenu'])
            //     ->set_slug($_POST['slug']);
             $Tpost->modifie($post, $_POST['categorie']);
             $CatTable->hydrater_list_categorie([$post]);
             $success= true;

        }else{

            $error = $v->get_errors();
        }
    }
    $Form = new Form_class($post , $error);

    // echo "<pre>";
    // var_dump($CatTable->get_liste_cat());
    // echo "</pre>";

    $link = $router->url('admin_modif',['slug'=>$post->get_slug(),'id'=>$post->get_id()]);


?>
<?php ob_start() ?>

<h1 class='text-center'>Modification du post no <?= $post->get_id() ?></h1>
    <?php if($success) :?>
        <div class="alert alert-success ">Modification Réussit</div>
    <?php endif; ?>
    <?php if(!empty($error)) :?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Erreur :</strong> Modification n'est pas valide !!!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <?php if(isset($_GET['creation'])) :?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Reussit :</strong> le formulaire a bien etait enregistrer !!!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <form action="<?= $link ?>" method="post">
            <?= $Form->get_input('nom','Le Titre') ?>
            <?= $Form->get_input('slug','Le Slug') ?>
            <?= $Form->select_Cat('categorie','Association des Catégorie',$CatTable->get_liste_cat()) ?>
            <?= $Form->get_input('date','La Date') ?>
            <?= $Form->get_textarea('contenu','Le Texte') ?>
            <button type="submit" class="btn btn-primary" name ="modif"> Modifié </button>
    </form>

<?php

$titre = 'Admin | Modification';
$contenu = ob_get_clean();
$active = 'post';
require dirname(__DIR__,1).DIRECTORY_SEPARATOR.'Layout/Template_admin.php';