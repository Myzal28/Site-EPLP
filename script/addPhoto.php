<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
require_once __DIR__ . "/../services/UserService.php";
require_once __DIR__ . "/../utils/DatabaseManager.php";
$m = DatabaseManager::getManager();
$u = UserService::getInstance();

if(!isset($_SESSION['user']) && $_SESSION['user']['username'] != "admin"){
    $_SESSION['flash']['error'] = "Vous devez être connecté en admin pour ajouter une photo";
}else{
    if( isset($_POST['user']) && !$u->hasPhoto($_POST['user']) ){
        if(isset($_FILES['photo'])){
            $photoName = $_POST['user']."photo".$_FILES['photo']['name'];
            $fileMoved = move_uploaded_file($_FILES['photo']['tmp_name'],'../photos/'.$photoName);
            if($fileMoved){
                $u->addPhoto($_POST['user'],$photoName);
                $_SESSION['flash']['success'] = "Votre photo a bien été ajoutée";
            }else{
                $_SESSION['flash']['error'] = "Erreur lors du traitement de votre photo";
            }
        }
    }else{
        $_SESSION['flash']['error'] = "Vous avez déjà envoyé votre photo";
    }
}
header("Location: ../");
?>