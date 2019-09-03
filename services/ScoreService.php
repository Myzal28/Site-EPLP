<?php 
require_once __DIR__ . '/../utils/DatabaseManager.php';

class ScoreService{
	private static $instance;
	private $manager;

	private function __construct() { 
		$this->manager = DatabaseManager::getManager();
	}

	public static function getInstance(): ScoreService {
		if(!isset(self::$instance)) {
			self::$instance = new ScoreService();
		}
		return self::$instance;
	}

	public function getTotalScore(){
		return $this->manager->findOne('SELECT SUM(score) as total FROM score_history')['total'];
	}

	public function getAllHistory(){
		return $this->manager->getAll('SELECT a.id,b.first_name,a.score,a.reason,a.datetime FROM score_history a INNER JOIN user b ON a.user = b.id ORDER BY a.id DESC');
	}

	public function getHistory($idUser){
		if ($idUser == 0) {
			return $this->getAllHistory();
		}else{
			return $this->manager->getAll('SELECT a.id,b.first_name,a.score,a.reason,a.datetime FROM score_history a INNER JOIN user b ON a.user = b.id WHERE a.user=? ORDER BY a.id DESC',[0=>$idUser]);
		}
	}

	public function addScore($idUser,$reason,$score){
		$this->manager->exec('INSERT INTO score_history (user,score,reason) VALUES (?,?,?)',[
			0 => $idUser,
			1 => $score,
			2 => $reason
		]);
	}
}