<?php 
session_start();
require_once __DIR__ . "/../services/MissionService.php";
require_once __DIR__ . "/../services/UserService.php";

$m = MissionService::getInstance();
$u = UserService::getInstance();

if (isset($_POST['kill'])) {
	$discoverer = $m->getDiscovered($_SESSION['user']['id']);
	if (isset($discoverer['target'])) {
		$_SESSION['flash']['missionLost'] = "Tu as été percé à jour par " . $u->getName($discoverer['target']). " il/elle remporte la partie et 10 points.";
	}else{
		$_SESSION['flash']['missionLost'] = "Tu as été percé à jour par " . $u->getName($discoverer). " il/elle récupère donc 5 points et tu es éliminé.";
	}
	header('Location: ../');
}