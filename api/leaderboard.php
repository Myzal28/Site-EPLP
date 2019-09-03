<?php 
require_once __DIR__ . "/../services/UserService.php";

$s = UserService::getInstance();
$leaderboard = $s->getLeaderboard();
for ($i=0; $i < count($leaderboard) ; $i++) { 
	unset($leaderboard[$i]['id']);
	unset($leaderboard[$i]['email']);
	unset($leaderboard[$i]['last_name']);
  if ($i > 0) {
    if ($leaderboard[$i]['score_total'] == $leaderboard[$i-1]['score_total']) {
      $leaderboard[$i]['place'] = $lastPlace;
    }else{
      $leaderboard[$i]['place'] = $lastPlace+1;
    }
  }else{
    $leaderboard[$i]['place'] = $i+1;
  }
  $lastPlace = $leaderboard[$i]['place'];
}
foreach ($leaderboard as $key => $value) {
	if ($value['score_total'] == NULL) {
		$value['score_total'] = 0;
	}
	$prefix = ($value['place'] > 3) ? "ème":"";
	switch ($value['place']) {
		case 1:
			$value['place'] = "🏆";
			break;
		case 2:
			$value['place'] = "🥈";
			break;
		case 3:
			$value['place'] = "🥉";
			break;
		default:
			break;
	}
	$messages[] = $value['place'].$prefix." - ".$value['score_total']." points - ".$value['first_name'];
}
header('Content-Type: application/json');
$message = "";
foreach ($messages as $key => $value) {
	$message .= $value."\u000A";
}
?>
{
 "messages": [
   {"text": "<?= $message;?>"}
 ]
}