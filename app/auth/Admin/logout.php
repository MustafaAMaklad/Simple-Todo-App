<?php

session_start();

// check if user is logged in
if (isset($_SESSION['currentUser'])) {
  // clear session
  unset($_SESSION['currentUser']);
  session_destroy();
  // send response
  header("Content-Type: application/json");
  echo json_encode(
    [
      'loggedOut' => true,
      'directToUrl' => 'http://localhost/todoapp/public/adminIndex.php'
    ]
  );
}