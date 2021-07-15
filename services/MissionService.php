<?php
require_once __DIR__ . '/../entity/UserMission.php';
require_once __DIR__ . '/../utils/DatabaseManager.php';
require_once __DIR__ . '/../services/ScoreService.php';
require_once __DIR__ . '/../services/UserService.php';
class MissionService {

	private static $instance;
	private $manager;

	private function __construct() { 
		$this->manager = DatabaseManager::getManager();
	}

	public static function getInstance(): MissionService {
		if(!isset(self::$instance)) {
			self::$instance = new MissionService();
		}
		return self::$instance;
	}

	public function get($id) : Mission {
		return new Mission(
			$this->manager->findOne("SELECT * FROM mission WHERE id=?",[0=>$id])
		);
	}

	public function getActive($idUser){
		$state = $this->manager->findOne('SELECT state,next_mission FROM user_mission_state WHERE user=?',[
			0 => $idUser
		]);

		$array['state'] = null;
		$array['end_date'] = null;
		$array['mission'] = null;
		$array['killer'] = null;
		$array['target'] = null;
		if($state == false){
			return new UserMission($array);
		}
		switch ($state['state']) {
			// Toujours en lice
			case 0:
				$sql = "SELECT a.id,a.title,a.description,a.logo,b.target FROM mission a INNER JOIN user_mission b ON a.id = b.id_mission WHERE b.user=?";
				break;
			// Tué
			case 1:
				$sql = "SELECT * FROM kill_history WHERE id_user =?";
				break;
			// Découvert
			case 2: 
				$sql = "SELECT * FROM kill_history WHERE id_user =?";
				break;
			case 3:
				$sql = "SELECT * FROM user_mission_state WHERE user=?";
		}

		$mission = $this->manager->findOne($sql,[ 0 => $idUser]);
		if($mission == false){
			return new UserMission($array);
		}else{
			$array['state'] = $state['state'];
			$array['end_date'] = $state['next_mission'];
			$array['mission'] = isset($mission['title']) ? new Mission($mission):NULL;
			$array['killer'] = isset($mission['id_killer']) ? $mission['id_killer']:NULL;
			$array['target'] = isset($mission['title']) ? $mission['target']:NULL;
			return new UserMission($array);
		}
	}

	public function getUnused(){
		return $this->manager->getAll("SELECT id FROM mission WHERE used = 0");
	}

	public function attribute($idMission,$idUser,$idTarget){
		// On désactive les missions déjà choisies pour ne pas tomber dessus 2 fois
		$update = $this->manager->exec("UPDATE `mission` SET `used` = '1' WHERE `mission`.`id` = ?;",[0=>$idMission]);

		// On insert la mission de chaque user avec sa target
		$insert = $this->manager->exec("INSERT INTO `user_mission` (`id_mission`, `user`,`target`) VALUES (?, ?, ?);",[
			0 => $idMission,
			1 => $idUser,
			2 => $idTarget
		]);


		$actualDay = date('w');
		if (($actualDay >= 0 AND $actualDay <= 2) OR ($actualDay == 6))  {
		  $nextMissionDay = date('Y-m-d',strtotime('next Wednesday'));
		}else{
		  $nextMissionDay = date('Y-m-d',strtotime('next Saturday'));
		}

		// On insert dans la table state qui permet de garder un suivi 
		$insert = $this->manager->exec('INSERT INTO user_mission_state (user,next_mission,state) VALUES (?,?,?)',[
			0 => $idUser,
			1 => $nextMissionDay,
			2 => 0
		]);

		$mission = $this->get($idMission);
		$title = "Mission du jour : " . $mission->getTitle();
		$msg = '<table style="border:2px solid #ffa500;border-collapse: collapse;width: 100%;text-align:center;font-family: Tahoma, Geneva, sans-serif">
					<tr>
						<th style="padding: 8px;background-color: #ffa500;color: white;"><h1>' . $mission->getTitle() . '</h1></th>
					</tr>
					<tr>
						<td style="padding: 8px;">
							' . str_replace("{joueur}", UserService::getInstance()->getName($idTarget), $mission->getDescription()) . '
						</td>
					</tr>
				</table>';
		UserService::getInstance()->mailUser($idUser,$title,$msg);
	}

	public function getKilled($userKilled){
		// On update le statut de la personne tuée à 1
		$this->manager->exec('UPDATE user_mission_state SET state=1 WHERE user = ?',[
			0 => $userKilled
		]);

		// On cherche qui est le tueur 
		$missionKiller = $this->manager->findOne('SELECT a.id,a.target,a.user,a.id_mission,b.title FROM user_mission a INNER JOIN mission b ON a.id_mission = b.id WHERE target=?',[0 => $userKilled]);

		// On récupère la mission de celui qui a été tué
		$missionDead = $this->manager->findOne("SELECT * FROM user_mission WHERE user=?",[
			0 => $userKilled
		]);
		// On rajoute l'entrée dans l'historique de kills
		$killHistory = $this->manager->exec("INSERT INTO kill_history (id_user,id_killer) VALUES (?,?)",[
			0 => $userKilled,
			1 => $missionKiller['user']
		]);

		// On vérifie si c'est la dernière mission, si oui alors celui qui a tué l'autre a gagné
		if ($missionDead['target'] == $missionKiller['user']) {
			// On passe le gagnant en statut 3 
			$this->manager->exec('UPDATE user_mission_state SET state=3 WHERE user=?',[
				0 => $missionKiller['user']
			]);

			$this->manager->exec('DELETE FROM user_mission');
			// On rajoute l'entrée dans l'historique des scores
			ScoreService::getInstance()->addScore($missionKiller['user'],'<i class="fa fa-trophy"></i> a gagné la partie en tuant <span class="pseudo">'.UserService::getInstance()->getName($userKilled).'</span> avec la mission <button class="btn btn-vacation" onclick="seeMission('.$missionKiller['id'].')">'.$missionKiller['title'].'</button> &nbsp; ',10);
			return $missionKiller;
		}else{
			// On passe la mission du tué au tueur
			$update2 = $this->manager->exec('UPDATE user_mission SET user=? WHERE id=?',[
				0 => $missionKiller['user'],
				1 => $missionDead['id']
			]);

			// On supprime la mission active du tueur
			$update = $this->manager->exec('DELETE FROM user_mission WHERE id=?',[
				0 => $missionKiller['id']
			]);

			// On rajoute l'entrée dans l'historique des scores
			ScoreService::getInstance()->addScore($missionKiller['user'],' a tué <span class="pseudo">'.UserService::getInstance()->getName($userKilled).'</span> avec la mission <button class="btn btn-vacation" onclick="seeMission('.$missionKiller['id_mission'].')">'.$missionKiller['title'].'</button>',5);
			return $missionKiller['user'];
		}

	}

	public function getDiscovered($userKilled){
		/*
		On va avoir besoin de trois informations : 
		Celui qui a été découvert
		Qui l'a découvert
		Qui avait une mission avec pour cible la personne découverte

		1) Eliminer celui qui a été découvert
		2) Changer la cible de celui qui avait pour cible celui qui a été découvert, et mettre en cible celui qui a découvert
		*/

		// On update le statut de la personne découverte a 2 (découvert)
		$this->manager->exec('UPDATE user_mission_state SET state=2 WHERE user =?',[
			0 => $userKilled
		]);

		// On cherche qui l'a découvert
		$discoverer = $this->manager->findOne('SELECT a.id,a.target,a.user,a.id_mission FROM user_mission a INNER JOIN mission b ON a.id_mission = b.id WHERE user=?',[0 => $userKilled]);

		// On rajoute l'entrée dans l'historique des kills
		$killHistory = $this->manager->exec("INSERT INTO kill_history (id_user,id_killer) VALUES (?,?)",[
			0 => $userKilled,
			1 => $discoverer['target']
		]);

		// On récupère celui qui ciblait celui qui a perdu pour update sa mission et faire des verif
		$target = $this->manager->findOne('SELECT * FROM user_mission WHERE target=?',[ 0 => $userKilled]);

		// Si la personne découverte avait pour cible celui qui l'a découvert, c'était donc la dernière mission, la partie est finie
		if ($discoverer['target'] == $target['user']) {
			// On supprime donc toute la table des missions 
			$this->manager->exec('DELETE FROM user_mission');

			// On passe le "découvreur" au statut 3 (Gagnant)
			$this->manager->exec('UPDATE user_mission_state SET state=3 WHERE user=?',[
				0 => $discoverer['target']
			]);
			// On rajoute l'entrée dans l'historique des scores
			ScoreService::getInstance()->addScore($discoverer['target'],' <span class="pseudo"><i class="fa fa-trophy"></i></span>  a gagné la partie en perçant <span class="pseudo">'.UserService::getInstance()->getName($userKilled).'</span> à jour, il avait la mission <button class="btn btn-vacation" onclick="seeMission('.$discoverer['id_mission'].')">'.$this->get($discoverer['id_mission'])->getTitle().'</button>',10);
			return $discoverer;
		}else{
			// On rajoute l'entrée dans l'historique des scores
			ScoreService::getInstance()->addScore($discoverer['target'],' a percé <span class="pseudo">'.UserService::getInstance()->getName($userKilled).'</span> à jour, il avait la mission <button class="btn btn-vacation" onclick="seeMission('.$discoverer['id_mission'].')">'.$this->get($discoverer['id_mission'])->getTitle().'</button>',5);
			// On supprime la mission de celui qui a été découvert pour l'éliminer
			$this->manager->exec('DELETE FROM user_mission WHERE user=?',[
				0 => $userKilled
			]);

			// On récupère celui qui avait celui découvert pour cible, et on change sa cible vers celui qui a trouvé
			$this->manager->exec('UPDATE user_mission SET target=? WHERE target=?',[
				0 => $discoverer['target'],
				1 => $userKilled
			]);

			
			return $discoverer['target'];
		}

		
	}
}
?>