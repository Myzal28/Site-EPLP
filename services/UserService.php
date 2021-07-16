<?php 
require_once __DIR__ . '/../entity/User.php';
require_once __DIR__ . '/../utils/DatabaseManager.php';

class UserService{
	private static $instance;
	private $manager;

	private function __construct() { 
		$this->manager = DatabaseManager::getManager();
	}

	public static function getInstance(): UserService {
		if(!isset(self::$instance)) {
			self::$instance = new UserService();
		}
		return self::$instance;
	}
	public function getAll() : array {
		return $this->manager->getAll("SELECT a.id,a.email,a.first_name,a.last_name,b.score_total,a.username,a.photo FROM user a LEFT JOIN (SELECT SUM(score) as score_total,user FROM score_history GROUP BY user ORDER BY score_total) b ON a.id = b.user ORDER BY a.first_name");
	}

	public function getAllActive() : array {
		return $this->manager->getAll("SELECT a.id,a.email,a.first_name,a.last_name,b.score_total,a.photo FROM user a LEFT JOIN (SELECT SUM(score) as score_total,user FROM score_history GROUP BY user ORDER BY score_total) b ON a.id = b.user WHERE a.active = 1 ORDER BY a.first_name");
	}

	public function getLeaderboard(){
		return $this->manager->getAll("SELECT a.id,a.email,a.first_name,a.last_name,b.score_total FROM user a LEFT JOIN (SELECT SUM(score) as score_total,user FROM score_history GROUP BY user ORDER BY score_total) b ON a.id = b.user ORDER BY b.score_total DESC");
	}

	public function getName($id){
		return $this->manager->findOne('SELECT first_name FROM user WHERE id=?',[0=>$id])['first_name'];
	}

	public function getUser($id){
		return $this->manager->findOne('SELECT * FROM user WHERE id = ?', [0=>$id]);
	}

	public function getIdFromName($firstName, $lastName){
	    return $this->manager->findOne('SELECT id FROM user WHERE first_name = ? AND last_name = ?',[
	        0 => $firstName,
            1 => $lastName
        ])['id'];
    }

    public function mailEveryone($title,$msg){
    	foreach ($this->getAll() as $key => $value) {
    		mail($value['mail'],$title,$msg,HEADERS);
    	}
    }

    public function mailUser($id,$title,$msg){
    	$u = $this->getUser($id);
    	mail($u['email'],$title,$msg,HEADERS);
    }

	public function addVote($voter, $category, $voteFor){
		$this->manager->exec('INSERT INTO votes (id_voter,category,voteFor) VALUES (?,?,?)',[
			0 => $voter,
			1 => $category,
			2 => $voteFor
		]);
	}

	public function hasVoted($idUser){
		$vote = $this->manager->findOne('SELECT id FROM votes WHERE id_voter = ?',[
			$idUser
		]);

		if($vote == false){
			return false;
		}else{
			return true;
		}
	}

}