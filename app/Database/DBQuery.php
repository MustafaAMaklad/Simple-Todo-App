<?php 

declare(strict_types=1);


// namespace App\Database;
// require_once 'DBConnector.php';
class DBQuery {

  
  private string $sqlSelectUser = "SELECT * FROM user WHERE email = ?";
  private string $sqlInsertUser = "INSERT INTO user (name, email, password) VALUES (?, ?, ?)";
  private mysqli $connection;
  // private User $user;

  
  public function __construct(DBConnector $connection) {
    $this->connection = $connection->getConnection();
  }
  
  public function selectUser(string $email) : ?array{
    $selectUser = $this->connection->prepare($this->sqlSelectUser);
    if ($selectUser) {
      $selectUser->bind_param('s', $email);
      if ($selectUser->execute()) {
        // $selectUser->store_result();
        $result = $selectUser->get_result();
        if ($result->num_rows > 0) {
          $assoc = $result->fetch_assoc(); 
          $selectUser->close();
        } else {
          $selectUser->close();
          return null;
        }
      }
    }
    
    return $assoc;
  }

  public function insertUser(string $name, string $email, string $password) :bool{
    $insertUser = $this->connection->prepare($this->sqlInsertUser);
    // check for execution prepration
    if ($insertUser) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $insertUser->bind_param("sss", $name, $email, $hashedPassword); // Bind password to statement parameter
      if ($insertUser->execute()) {
        $insertUser->close();
        return true;
      }else{
        $insertUser->close();
        return false;
      }
    }
    return false;
  }
}