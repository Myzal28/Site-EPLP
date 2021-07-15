<?php 
require_once __DIR__ . "/../services/MissionService.php";
require_once __DIR__ . "/../services/UserService.php";

$m = MissionService::getInstance();
$u = UserService::getInstance();

$db = DatabaseManager::getManager();
$db->exec("TRUNCATE user_mission");
$db->exec("TRUNCATE user_mission_state");
$db->exec("TRUNCATE kill_history");

$users = $u->getAllActive();
shuffle($users);

$unusedMissions = $m->getUnused();
shuffle($unusedMissions);

if (count($users) > count($unusedMissions)) {
	echo "Pas assez de missions pour chaque utilisateur";
}else{
	foreach ($users as $key => $value) {
		if (empty($users[$key+1])) {
			$m->attribute($unusedMissions[$key]['id'],$users[$key]['id'],$users[0]['id']);
			echo $users[$key]['id']. " -> ".$users[0]['id'];
		}else{
			$m->attribute($unusedMissions[$key]['id'],$users[$key]['id'],$users[$key+1]['id']);
			echo $users[$key]['id']." -> ".$users[$key+1]['id'];
		}
		echo "<br>";
	}
}