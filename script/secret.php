<?php 
session_start();
require_once __DIR__ . "/../services/SecretService.php";
require_once __DIR__ . "/../services/UserService.php";
require_once __DIR__ . "/../utils/DatabaseManager.php";
$m = DatabaseManager::getManager();

if (isset($_POST['secretSet']) && isset($_SESSION['user']['id'])) {
	$m->exec('INSERT INTO secrets (secret,user) VALUES (?,?)',
		[
			0 => $_POST['secretSet'],
			1 => $_SESSION['user']['id']
		]
	);
}

if (isset($_POST['secret']) && isset($_POST['user']) && isset($_SESSION['user']['id'])) {
	$accusedPlayer = UserService::getInstance()->getName($_POST['user']);
	$s = SecretService::getInstance();
	$verify = $s->verifySecret($_POST['user'],$_POST['secret'],$_SESSION['user']['id']);
	if ($verify) {
		$_SESSION['flash']['success'] = "Super, tu as trouvé le secret de ".$accusedPlayer;
	}else{
		$_SESSION['flash']['error'] = "Malheureusement ".$accusedPlayer." n'a pas ce secret, retente ta chance demain";
	}
}

header('Location: ../');