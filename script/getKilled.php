<?php 
session_start();
require_once __DIR__ . "/../services/MissionService.php";
require_once __DIR__ . "/../services/UserService.php";

$m = MissionService::getInstance();
$u = UserService::getInstance();
if (isset($_POST['kill'])) {
	$killer = $m->getKilled($_SESSION['user']['id']);
	if (isset($killer['user'])) {
		$_SESSION['flash']['missionLost'] = "Tu as été tué(e) par " . $u->getName($killer['user']). " il/elle gagne la partie sur ce kill et remporte 10 points.";
	}else{
		$_SESSION['flash']['missionLost'] = "Tu as été tué(e) par " . $u->getName($killer). " il/elle récupère donc 5 points et ta mission.";
	}
	
	header('Location: ../');
}