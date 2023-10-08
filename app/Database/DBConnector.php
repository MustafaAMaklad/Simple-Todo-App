<?php 

declare(strict_types=1);

// namespace App\Database;
// use App\Databasea\DBQuery;
class DBConnector {
  private static ?DBConnector $instance = null;

  private mysqli $db;
  private string $dbServer;
  private string $dbUsername;
  private string $dbPassword;
  private string $dbName;

  private function __construct(array $configs) {
    $this->dbServer = $configs['server'];
    $this->dbUsername = $configs['username'];
    $this->dbPassword = $configs['password'];
    $this->dbName = $configs['name'];
    $this->db = $this->connect();
  }

  public static function getDBConnectorInstance(array $config) {
    if (self::$instance === null) {
      self::$instance = new DBConnector($config);
    }
    return self::$instance;
  }

  private function connect(){
    $conn = new mysqli($this->dbServer, $this->dbUsername, 
    $this->dbPassword, $this->dbName);

    // check connection
    if ($conn === false) {
      die("Error: Coundn't connect. " . $conn);
    }
    return $conn;
  }

  public function getConnection(): mysqli {
    return $this->db;
  }
}