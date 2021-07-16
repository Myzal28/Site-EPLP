<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
require_once __DIR__ . "/../services/UserService.php";
require_once __DIR__ . "/../utils/DatabaseManager.php";
$m = DatabaseManager::getManager();
$u = UserService::getInstance();

if(!isset($_SESSION['user'])){
    $_SESSION['flash']['error'] = "Vous devez être connecté pour voter";
}else{
    if( 
        isset($_POST['funniest']) && 
        isset($_POST['styliest']) && 
        isset($_POST['original']) &&
        $_POST['funniest'] != "none" &&
        $_POST['styliest'] != "none" && 
        $_POST['original'] != "none"
    ){
        if(!$u->hasVoted($_SESSION['user']['id'])){
            $u->addVote($_SESSION['user']['id'],0,$_POST['funniest']);
            $u->addVote($_SESSION['user']['id'],1,$_POST['styliest']);
            $u->addVote($_SESSION['user']['id'],2,$_POST['original']);
            $_SESSION['flash']['success'] = "Vos votes ont bien été pris en compte";
        }else{
            $_SESSION['flash']['error'] = "Vos votes ont déjà été pris en compte";
        }
    }else{
        $_SESSION['flash']['error'] = "Veuillez remplir tous les champs, un ou plusieurs de vos votes ne sont pas valides";
    }
}
header("Location: ../");
?>