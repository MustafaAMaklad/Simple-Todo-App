<?php 

declare(strict_types=1);


namespace App\Models;

class User extends Model{

  
  public function select(string $email) : ?array{
    $query = 'SELECT * FROM users WHERE email = ?';
    $stmt = $this->db->prepare($query);
    if ($stmt) {
      $stmt->bind_param('s', $email);
      if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
          $assoc = $result->fetch_assoc(); 
          $stmt->close();
        } else {
          $stmt->close();
          return null;
        }
      }
    }
    
    return $assoc;
  }

  public function create(string $name, string $email, string $password, string $imagePath) :bool{
    $query = 'INSERT INTO users (name, email, password, profile_img) VALUES (?, ?, ?, ?)';
    $stmt = $this->db->prepare($query);
    // check for execution prepration
    if ($stmt) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $stmt->bind_param("ssss", $name, $email, $hashedPassword, $imagePath); // Bind password to statement parameter
      if ($stmt->execute()) {
        $stmt->close();
        return true;
      }else{
        $stmt->close();
        return false;
      }
    }
    return false;
  }

  public function getCount(string $email) : int{
    $query = 'SELECT COUNT(users.id) as count FROM users
    WHERE email = ?';
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('s', $email);

    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row['count'];
  }

  // public function 
}