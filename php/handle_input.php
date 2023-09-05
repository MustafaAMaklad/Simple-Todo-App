<?php

// Clear the input of any unexpected characters
function clear_input_data($data) {
  $data = trim($data);
  $data = stripcslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Validate the requirements for a valid username
function validate_username($username) {
  if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    return false;
  } else {
    return true;
  }
}

// Validate the requirements for a valid password
function validate_password($password) {
  if (strlen($password) < 8) {
    return false;
  } else {
    return true;
  }
}

// Validate that confirm password matches password
function validate_confirm_password($password, $confirmPassword) {
  return $password == $confirmPassword;
}



