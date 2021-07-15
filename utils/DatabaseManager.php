<?php

require_once __DIR__ . '/conf.php';

class DatabaseManager {

  private $pdo;
  private static $manager;

  private function __construct() {
    $this->pdo = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
  }

  // singleton: 1 instance de DatabaseManager
  public static function getManager(): DatabaseManager {
    if(!isset(self::$manager)) {
      self::$manager = new DatabaseManager();
    }
    return self::$manager;
  }

  // 7.1+
  private function internalExec(string $sql, array $params = []): ?PDOStatement {
    $stmt = $this->pdo->prepare($sql);
    if($stmt !== false) {
      if($stmt->execute($params)) {
          return $stmt;
      }
      print_r($stmt->errorInfo());
    }
    return NULL;
  }

  public function exec(string $sql, array $params = []): int {
    $stmt = $this->internalExec($sql, $params);
    if($stmt) {
      return $stmt->rowCount();
    }
    return 0;
  }

  public function getAll(string $sql, array $params = []): array {
    $stmt = $this->internalExec($sql, $params);
    if($stmt) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return [];
  }

  public function findOne(string $sql, array $params = []) {
    $stmt = $this->internalExec($sql, $params);
    if($stmt) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return NULL;
  }

  public function lastInsertId(): ?int {
    return $this->pdo->lastInsertId();
  }
}

?>
