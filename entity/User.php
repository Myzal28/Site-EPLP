<?php 
class User{
	private $id;
	private $email;
	private $firstName;
	private $lastName;

	public function __construct(){

	}

	public function getId(){ return $this->id; }
	public function getEmail(){ return $this->email; }
	public function getFirstName(){ return $this->firstName; }
	public function getLastName(){ return $this->lastName; }

	public function setId($id){
		$this->id = $id;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function setFirstName($firstName){
		$this->firstName = $firstName;
	}

	public function setLastName($lastName){
		$this->lastName = $lastName;
	}
}