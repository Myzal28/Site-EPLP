<?php 
require_once __DIR__ . "/Mission.php";
class UserMission{
	private $mission;
	private $state;
	private $killer; 
	private $endDate;
	private $target; 

	public function __construct(array $userMission){
		$this->mission = $userMission['mission'];
		$this->state = $userMission['state'];
		$this->killer = $userMission['killer'];
		$this->endDate = $userMission['end_date'];
		$this->target = $userMission['target'];
	}

	// GETTERS
	public function getMission(){ return $this->mission; }
	public function getState(){ return $this->state; }
	public function getKiller(){ return $this->killer; }
	public function getEndDate(){ return $this->endDate; }
	public function getTarget(){ return $this->target; }

	// SETTERS
	public function setMission($mission){
		$this->mission = $mission;
	}

	public function setState($state){
		$this->state = int_val($state);
	}

	public function setKiller($killer){
		$this->killer = $killer;
	}

	public function setEndDate($endDate){
		$this->endDate = $endDate;
	}

	public function setTarget($target){
		$this->target = $target;
	}
}