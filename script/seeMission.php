<?php 
require_once __DIR__ . "/../utils/DatabaseManager.php";
require_once __DIR__ . "/../services/UserService.php";

$db = DatabaseManager::getManager();
$u = UserService::getInstance();

$test = $db->getAll("SELECT * FROM user_mission WHERE active=1 ORDER BY id");

foreach ($test as $key => $value) {
	echo $u->getName($value['user'])." doit kill ".$u->getName($value['target']);
	echo "<br><br>";
}