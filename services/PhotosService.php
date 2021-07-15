<?php
require_once __DIR__ . '/../utils/DatabaseManager.php';;
class PhotosService {

	private static $instance;
	private $manager;

	private function __construct() { 
		$this->manager = DatabaseManager::getManager();
	}

	public static function getInstance(): PhotosService {
		if(!isset(self::$instance)) {
			self::$instance = new PhotosService();
		}
		return self::$instance;
	}

	public function get($id) : Photo {
		return new Photo(
			$this->manager->findOne("SELECT * FROM photo WHERE id=?",[0=>$id])
		);
	}
}
?>