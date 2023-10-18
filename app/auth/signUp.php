<?php

declare(strict_types=1);

require_once realpath('../../vendor/autoload.php');

define('PROFILE_IMG_STORAGE_PATH', __DIR__ . '/../Storage/UserProfileImg');

use App\Auth\Auth;


$auth = new Auth();

$name = 
$_POST['name'];


$email = 
$_POST['email'];


$password = 
$_POST['password'];


$passwordConfirm = 
$_POST['passwordconfirm'];





$response = $auth->signUp($name, $email, $password, $passwordConfirm);

if ($response['status'] == true) {
  header("Content-Type: application/json");
  echo json_encode(
    [
      'status' => true, 
      'directToUrl' => 'http://localhost/todoapp/public/views/auth/signUpSuccess.html'
    ]
  );
} else {
  $errResponse = [
    'status' => $response['status'],
    'error' => ['available' => false, 'errorMsg' => 'Email adress already taken']
  ];
  header("Content-Type: application/json");
  echo json_encode($errResponse);
}
