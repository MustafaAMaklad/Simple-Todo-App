<?php 

declare(strict_types=1);

// namespace App\Auth;

// // require_once '../Util/InputValidation/Validator.php';
// require_once '../Database/DBQuery.php';
// require_once '../Util/InputValidation/Validator.php';
// use App\Database\DBQuery;
// use App\Util\InputValidation\Validator;
class Auth {
  private DBQuery $userDatabase;
  private Validator $validator;

  private array $response = [
    'status' => null,
    'errors' => [
        'validationErrors' => null,
        'authErrors' => null,
        'serverErrors' => null
      ],
    'session' => null
  ]; 

  public function __construct(DBQuery $userDatabase) {
    $this->userDatabase = $userDatabase;
    $this->validator = new Validator();
  }
  
  public function signUp(string $name, string $email, string $password, string $confirmPassword) :array{
    $this->response['errors']['validationErrors'] = $this->validator->validateOnSignUp($name, $email, $password, $confirmPassword);
    if(!empty($this->response['errors']['validationErrors'])){
      // Validation Error
      $this->response['status'] = false;
      return $this->response;
    }else {
      if ($this->userDatabase->selectUser($email) != null){
        // Dublicate Email Error
        $this->response['status'] = false;
        $this->response['errors']['authErrors'] = ['available' => false, 'errorMsg' => 'Email address is already taken.'];
        return $this->response;
      } else {
        // No validation Error
        if($this->userDatabase->insertUser($name, $email, $password)) {
          $this->response['status'] = true;
          return $this->response;
        } else {
          $this->response['status'] = false;
          $this->response['errors']['serverErrors'] =  'Something went wrong! Please try to sign up later.';
          return $this->response;
        }
      } 
    }
  }
  public function signIn(string $email, string $password): array{
    $this->response['errors'] = $this->validator->validateOnLogIn($email, $password);
    if (!empty($this->response['errors'])) {
      return $this->response;
    } else {
      $user = $this->userDatabase->selectUser($email);
      if ($user == null) {
        array_push($this->response['errors'], 'This user doesn\'t exists.');
        return $this->response;
      } else {
        $hashedPassword = $user['password'];
        if(password_verify($password, $hashedPassword)) {
          $this->response['status'] = true;
          $this->response['session'] = ['user_id' => $user['id'], 'user_name' => $user['name']];
          return $this->response;
        } else {
          array_push($this->response['errors'], 'Password is incorrect.');
          return $this->response;
        }
      }
    }
    
  }
}