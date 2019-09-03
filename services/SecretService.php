<?php 
require_once __DIR__ . '/../entity/Secret.php';
require_once __DIR__ . '/../utils/DatabaseManager.php';
require_once __DIR__ . '/../services/ScoreService.php';
require_once __DIR__ . '/../services/UserService.php';

class SecretService{
	private static $instance;
	private $manager;

	private function __construct() { 
		$this->manager = DatabaseManager::getManager();	
	}

	public static function getInstance(): SecretService {
		if(!isset(self::$instance)) {
			self::$instance = new SecretService();
		}
		return self::$instance;
	}

	public function getAll(){
		return $this->manager->getAll('SELECT * FROM secrets');
	}

	public function nbNotFound(){
		return $this->manager->findOne('SELECT COUNT(*) as nb FROM secrets WHERE found_by IS NOT NULL')['nb'];
	}
	public function verifySecret($idUserAccused, $idSecret, $idUser){
		$accusedPlayer = UserService::getInstance()->getName($idUserAccused);

		$secret = $this->manager->findOne('SELECT * FROM secrets WHERE id=?',[0=>$idSecret]);
		$this->manager->exec('INSERT INTO guess_secret (id_secret,id_user_accused,id_user) VALUES (?,?,?)',[
			0 => $idSecret,
			1 => $idUserAccused,
			2 => $idUser
		]);

		if ($secret['user'] == $idUserAccused) {
			$this->manager->exec('UPDATE secrets SET found_by=? WHERE id=?',
				[
					0 => $idUser,
					1 => $idSecret
				]
			);
			$title = "Le secret de ". $accusedPlayer . " a été trouvé !";
			$msg = "Le secret de " . $accusedPlayer . " était : " . $secret['secret'];
			UserService::getInstance()->mailEveryone($title,$msg);
			
			ScoreService::getInstance()->addScore($idUser,"a trouvé le secret de <span class='pseudo'>".$accusedPlayer."</span>",20);

			return true;
		}else{
			return false;
		}
	}

	public function canSubmit(){
		$data = $this->manager->findOne('SELECT datetime FROM guess_secret WHERE id_user = ? ORDER BY datetime DESC LIMIT 0,1',[0 => $_SESSION['user']['id']]);
		if (empty($data)) {
			return true;
		}else{
			$lastSubmit = substr($data['datetime'],0,10);
			if ($lastSubmit == date('Y-m-d')) {
				return false;
			}else{
				return true;
			}
		}
	}

	public function getAllFound(){
		return $this->manager->findOne('SELECT COUNT(found_by) as a FROM secrets')['a'];
	}

	public function isSet($idUser){
		$data = $this->manager->findOne('SELECT id FROM secrets WHERE user=?',[0 => $idUser]);
		return empty($data) ? false:true;		
	}

	public function getAvailable(){
		$return['secrets'] = $this->manager->getAll('SELECT * FROM secrets WHERE found_by IS NULL');
		$return['users'] = $this->manager->getAll('SELECT a.id,a.first_name FROM user a INNER JOIN secrets b ON a.id = b.user WHERE found_by IS NULL');
		return $return;
	}
}