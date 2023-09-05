<?php
  
require 'handle_input.php';
require 'check_user_db.php';

$username = $password = $confirmPassword = $usernameErr = $passwordErr = $confirmPasswordErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // check for username
  $username = clear_input_data($_POST["uname"]);
  if (empty($username)) {
    $usernameErr = "Please Enter a Username";
  } else {
    if(!validate_username($username)){
      $usernameErr = "Username Can Only Contain Letters, Numbers and Underscores";
    } else {
      // check username if exists in database
      if (check_user_exists($username) == -1) {
        echo "Something Went Wrong, Try Again Later";
      }elseif (check_user_exists($username) == 1) {
        $usernameErr = "Username Already Exists";
      }
    }
  }

  // check for password
  $password = clear_input_data($_POST["pwd"]);
  if(empty($password)) {
    $passwordErr = "Please Enter a Password";
  } else {
    if (!validate_password($password)) {
      $passwordErr = "Password Must Have At Least 8 Characters";
    } 
  }

  // check for confirm password
  $confirmPassword = clear_input_data($_POST["confPwd"]);
  if (empty($confirmPassword)) {
    $confirmPasswordErr = "Please Confirm Password";
  } else {
    if (!validate_confirm_password($password, $confirmPassword)) {
      $confirmPasswordErr = "Passwords Did Not Match";
    }
  }

  // validate errors before instering data
  if (empty($usernameErr) and empty($passwordErr) and empty($confirmPasswordErr)) {
    // perform insertion of user
    if (insert_user($username, $password)){
      // Redirect to login 
      header("location: login.php");
    } else {
      echo "Oops! Something Went Wrong, Try Again Later";
    }
  }

  // Close connection to database
  close_connection();
} else {
  echo "Your Submition Failed";
  close_connection();
}

?>


