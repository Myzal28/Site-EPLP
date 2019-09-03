<?php
require_once __DIR__ . "/../services/UserService.php";
$db = DatabaseManager::getManager();
$u = UserService::getInstance();

$json = file_get_contents('php://input'); // read body
$obj = json_decode($json, true);

$link = "https://maps.google.com/maps?q=".$obj['latitude'].",".$obj['longitude'];
?>
{
"messages": 
	[
		{
			"text": "<?= $link;?>"
		}
	]
}
