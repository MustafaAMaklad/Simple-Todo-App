<?php

declare(strict_types=1);

require_once realpath('../../../vendor/autoload.php');


use App\Auth\Admin\AdminAuth;



$auth = new AdminAuth();

$name = 
$_POST['name'];
'admin';


$email = 
$_POST['email'];
'admin@mail.com';


$password = 
$_POST['password'];
'iam12345';


$passwordConfirm = 
$_POST['passwordconfirm'];
'iam12345';





$response = $auth->signUp($name, $email, $password, $passwordConfirm, null);

if ($response['status'] == true) {
  header("Content-Type: application/json");
  echo json_encode(
    [
      'status' => true, 
      'directToUrl' => 'http://localhost/todoapp/public/views/adminAuth/adminSignUpSuccess.html'
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
