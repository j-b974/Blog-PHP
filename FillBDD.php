<?php
USE app\application\Connection;

require __DIR__.'\vendor\autoload.php';

$bdd = Connection::connection();

$faker = Faker\Factory::create("fr_FR");

$bdd->exec('SET FOREIGN_KEY_CHECKS = 0');
$bdd->exec('TRUNCATE TABLE post');
$bdd->exec('TRUNCATE TABLE categorie');
$bdd->exec('TRUNCATE TABLE post_categorie');
$bdd->exec('SET FOREIGN_KEY_CHECKS = 1');

$id_post = [];
$id_categorie = [];

for ($i=0; $i < 50 ; $i++)
{
    $bdd->exec("INSERT INTO post SET nom = '{$faker->sentence(1)}' , slug = '{$faker->slug}' , contenu ='{$faker->paragraphs(10,true)}',  creation_date = '{$faker->date()} {$faker->time()}' ");
    $id_post[]=$bdd->lastInsertId();
}


for ($i=0; $i < 5; $i++) {

    $bdd->exec("INSERT INTO categorie SET nom = '{$faker->sentence(1)}' , slug='{$faker->slug}' ");
    $id_categorie[] = $bdd->lastInsertId();
}
foreach($id_post as $post)
{
    $att_categorie = [];
    $nb = rand(1 , count($id_categorie));
    //$att_categorie =  array_rand($id_categorie , $nb ) ;
    $att_categorie = $faker->randomElements($id_categorie, $nb);

    foreach ($att_categorie as $value)
    {
        $bdd->exec("INSERT INTO post_categorie SET id_post = '$post', id_categorie = '$value' ");
    }
}

$bdd->exec("INSERT INTO users SET nom = 'jb974', password = '1234' ");
echo 'effectué !!!!';