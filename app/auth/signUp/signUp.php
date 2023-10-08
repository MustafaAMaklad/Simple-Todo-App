<?php 

declare(strict_types=1);


require '../../Database/DBConnector.php';
require '../../Database/DBQuery.php';
require '../../Util/InputValidation/NameValidatorInterface.php';
require '../../Util/InputValidation/EmailValidatorInterface.php';
require '../../Util/InputValidation/PasswordValidatorInterface.php';
require '../../Util/InputValidation/Validator.php';
require '../auth.php';
// use App\Database\DBConnector;
// use App\Database\DBQuery;
// use App\Auth\Auth;


$config = ['server'=>'localhost', 'username'=>'root', 'password'=>'', 'name'=>'demo'];
$connectorInstance = DBConnector::getDBConnectorInstance($config);

$db = new DBQuery($connectorInstance);

$auth = new Auth($db);
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordconfirm'];
$response = $auth->signUp($name, $email, $password, $passwordConfirm);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  if ($response['status'] == true) {
    header('Location: ../../../views/auth/signUpSuccess.html');
    exit;
    // require '../../../views/auth/signUpSuccess.html';
  } else {
    $errResponse = $response['errors']['authErrors'];
    header("Content-Type: application/json");
    echo json_encode($errResponse);
  }
}


