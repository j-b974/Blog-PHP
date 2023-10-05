<?php
    require dirname(__DIR__,2).DIRECTORY_SEPARATOR.'vendor/autoload.php';
    use app\application\{Connection,User_Class};
    use app\html_form\Form_Class;
    use app\Validateur\ValideurLogin;
    use app\Table\User_Table;

    $user = new User_Class;
    $error = [];
    if(isset($_POST['connection']))
    {
        $bdd = Connection::connection();
        $TUser = new user_Table($bdd);
        $user->set_nom($_POST['nom']);

        // var_dump($TUser->get_by_name($_POST['nom']));



        $v = new ValideurLogin($_POST , $TUser );

        if($v->valideur())
        {
            session_start();
            $_SESSION['auth']='1';
            header('Location:'.$router->url('admin'));
            exit();

        }else
        {
            $error = $v->get_errors();
        }
    }
    $iform = new Form_Class($user,$error);

    $lien = $router->url('blog_login');
    
?>
<?php ob_start() ?>

<h1 class="text-center">Connection</h1>
    <form action="<?= $lien ?>" method="post">
        <?= $iform->get_input('nom', 'Nom Utilisateur') ?>
        <?= $iform->get_input('password','PassWord') ?>
        <button class='btn btn-primary' name = 'connection' type="submit">Connection</button>
    </form>
<?php

$titre = 'Blog | Login';
$contenu = ob_get_clean();

require dirname(__DIR__,1).DIRECTORY_SEPARATOR.'Layout/Template.php';