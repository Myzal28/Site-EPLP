<?php 
session_start();
require_once __DIR__ . "/../services/UserService.php";
require_once __DIR__ . "/../utils/DatabaseManager.php";
$m = DatabaseManager::getManager();

if (isset($_GET['username']) && isset($_GET['password'])) {
	$username = $_GET['username'];
	$password = $_GET['password'];
	$connect = true;
}elseif(isset($_POST['username']) && isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$connect = true;
}else{
	$_SESSION['flash']['error'] = "Veuillez renseigner des logins corrects";
}

if ($connect) {
	$user = $m->findOne('SELECT * FROM user WHERE username=?',[0=>$username]);
	if (empty($user)) {
		$_SESSION['flash']['error'] = "Utilisateur non trouvé";
	}else{
		if (password_verify($password, $user['password'])) {
			$_SESSION['user'] = $user;
		}else{
			$_SESSION['flash']['error'] = "Mot de passe incorrect";
		}
	}
}
header("Location: ../");
?>