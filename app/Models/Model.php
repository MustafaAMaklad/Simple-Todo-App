<?php 

declare(strict_types=1);

namespace App\Models;

use App\Database\DBConnector;
use mysqli;

class Model {
  protected mysqli $db;
  public function __construct() {
    $config = ['server' => 'localhost', 'username' => 'root', 'password' => 'root', 'name' => 'todo_app'];
    $this->db = (DBConnector::getDBConnectorInstance($config))->getConnection();
  }
}