<?php 
require_once __DIR__ . "/../services/UserService.php";

$u = UserService::getInstance();

$db = DatabaseManager::getManager();

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

foreach ($u->getAll() as $key => $value) {
	$randomPwd = generateRandomString(5); 
	$msg = "<div style='font-size: 15; font-family: Verdana, Geneva, sans-serif; text-align:center'>";
	$msg .= "Voici vos accès au site EPLP Lloret : <hr>";
	$msg .= "Nom d'utilisateur : " . $value['username'] . "<br>";
	$msg .= "Mot de passe : " . $randomPwd . "<br>";
	$msg .= "<a href='https://eplp.fr/script/verifyConnect.php?username=" . $value['username'] . "&password=" . $randomPwd . "'>Lien direct vers la connexion</a><br><br><br>";
	$msg .= "</div>";
	$u->mailUser($value['id'],'Vos accès à EPLP Lloret',$msg);

	$db->exec('UPDATE user SET password = ? WHERE id = ?',[
		0 => password_hash($randomPwd, PASSWORD_DEFAULT),
		1 => $value['id']
	]);
}