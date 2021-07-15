<?php 
require_once __DIR__ . "/../services/MissionService.php";
require_once __DIR__ . "/../services/UserService.php";
$db = DatabaseManager::getManager();
$u = UserService::getInstance();

$json = file_get_contents('php://input'); // read body
$obj = json_decode($json, true);
$days = [
	1 => "Lundi",
	2 => "Mardi",
	3 => "Mercredi",
	4 => "Jeudi",
	5 => "Vendredi",
	6 => "Samedi",
	0 => "Dimanche"
];


$idUser = $u->getIdFromName($obj['first_name'],$obj['last_name']);
if (!$idUser) {
	$message = "Utilisateur non trouvé ou ne participant pas aux missions";
}else{
	$mission = MissionService::getInstance()->getActive($idUser);
	if (!$mission->getMission()) {
		$message = "Vous n'avez pas encore de mission en cours";
	}else{
		$message = $obj['first_name']. ", voici ta mission : \u000A\u000A";
		$message .= "Titre : " . $mission->getMission()->getTitle()."\u000A\u000A";
		$desc = str_replace("{joueur}", $u->getName($mission->getTarget()), $mission->getMission()->getDescription());
		$message .= "Description : " . $desc."\u000A\u000A";
		$jour = $days[date('w',strtotime($mission->getEndDate()))];
		$message .= "Tu as jusqu'au ". $jour . " " . date('d/m',strtotime($mission->getEndDate())) ." à 12h";
	}
}

?>
{
 "messages": [
   {"text": "<?= $message;?>"}
 ]
}
