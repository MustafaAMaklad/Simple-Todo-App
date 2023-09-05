<?php
require_once 'db_config.php';

//returns 1 if user exists and -1 if there is a problem
function check_user_exists($username){
  global $conn;
  // prepare sql statement 
  $sql = "SELECT id FROM users WHERE username = ?";
  
  // check for execution prepration
  if ($stmt = $conn->prepare($sql)) { 
    $stmt->bind_param("s", $username); // bind the username to the statement

    if ($stmt->execute()) {
      $stmt->store_result();

      if ($stmt->num_rows() == 1) {
        $stmt->close();
        return 1;
      }
    } else {
      $stmt->close();
      return -1;
    }
    
  }
  
}

function insert_user($username, $password) {
  global $conn;
  // prepare sql statement
  $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

  // hash password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  // check for execution prepration
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ss", $username, $hashedPassword); // Bind password to statement parameter
    if ($stmt->execute()) {
      $stmt->close();
      return true;
    }else{
      $stmt->close();
      return false;
    }
  }
}

function close_connection() {
  global $conn;
  $conn->close();
}