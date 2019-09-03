<?php 
class Mission{
	// Attributs de la mission en elle même 
	private $id;
	private $title;
	private $description;
	private $logo;

	public function __construct(array $mission){
		$this->setId($mission['id']);
		$this->setTitle($mission['title']);
		$this->setDescription($mission['description']);
		$this->setLogo($mission['logo']);
	}

	// GETTERS
	public function getId(){ return $this->id; }
	public function getTitle(){ return $this->title; }
	public function getDescription(){ return $this->description; }
	public function getLogo(){ return $this->logo; }

	// SETTERS
	public function setId($id){
		$this->id = $id;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function setDescription($description){
		$this->description = $description;
	}

	public function setLogo($logo){
		$this->logo = $logo;
	}
}