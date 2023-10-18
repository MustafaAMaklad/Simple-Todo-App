<?php

require_once realpath('../../../vendor/autoload.php');

use App\Auth\Admin\AdminAuth;
// use App\Auth\Auth;
use App\Services\SessionService;

$auth = new AdminAuth();


$email = 
$_POST['email'];
'admin@mail.com';
$password = 
$_POST['password'];
'iam12345';


$response = $auth->logIn($email, $password);

if ($response['status'] == true) {
  SessionService::startSession($response['session']);

  header("Content-Type: application/json");
  echo json_encode(
    [
      'status' => true,
      'directToUrl' => 'http://localhost/todoapp/public/views/adminHome.php',
      'session' => $response['session']
    ]
  );
} else if ($response['status'] == false && !empty($response['errors']['validationErrors'])) {
  header("Content-Type: application/json");
  echo json_encode(
    [
      'status' => false,
      'error' => [
        'empty' => true,
        'errorMsg' => 'Fields cannot be empty'
      ]
    ]
  );
} else {
  header("Content-Type: application/json");
  echo json_encode(
    [
      'status' => false,
      'error' => [
        'correct' => false,
        'errorMsg' => 'Email or password is incorrect.'
      ]
    ]
  );
}
