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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $response = $auth->signIn($email, $password);

  if ($response['status'] == true) {
    session_start();
    $_SESSION['user_id'] = $response['session']['user_id'];
    $_SESSION['user_name'] = $response['session']['user_name'];
    header('Location: ../../../views/home.php');
    exit;
  } else {
    foreach ($response['errors'] as $error) {
      echo $error . '<br>';
    }
  }
  
}