<?php

declare(strict_types=1);

namespace App\Auth;


use App\Models\User;
use App\Utils\Validator;

class Auth
{
  protected  $userModel;
  
  protected Validator $validator;

  private array $response = [
    'status' => null,
  ];

  public function __construct()
  {
    $this->userModel = new User();
    $this->validator = new Validator();

  }

  public function signUp(string $name, string $email, string $password, string $confirmPassword): array
  {
    $this->response['errors']['validationErrors'] = $this->validator->validateOnSignUp($name, $email, $password, $confirmPassword);
    if (!empty($this->response['errors']['validationErrors'])) {
      // Validation Error
      $this->response['status'] = false;
      return $this->response;
    } else {
      if ($this->userModel->getCount($email) == 1) {
        // Dublicate Email Error
        $this->response['status'] = false;
        $this->response['errors']['authErrors'] = ['available' => false, 'errorMsg' => 'Email address is already taken.'];
        return $this->response;
      } else {
        // No validation Error
        if ($this->userModel->create($name, $email, $password)) {
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
  public function logIn(string $email, string $password): array
  {
    $this->response['errors']['validationErrors'] = $this->validator->validateOnLogIn($email, $password);
    if (!empty($this->response['errors']['validationErrors'])) {
      return $this->response;
    } else {
      $user = $this->userModel->select($email);
      if ($user == null) {
        $this->response['status'] = false;
        $this->response['errors']['authErrors'] = 'This user doesn\'t exists.';
        return $this->response;
      } else {
        $hashedPassword = $user['password'];
        if (password_verify($password, $hashedPassword)) {
          $this->response['status'] = true;
          $this->response['session'] = [
            'userId' => $user['id'],
            'userName' => $user['name'],
            'userEmail' => $user['email']
          ];
          return $this->response;
        } else {
          $this->response['errors']['authErrors'] = 'Password is incorrect.';
          return $this->response;
        }
      }
    }
  }

  // public function logOut()
  // {
  //   session_start();

  //   // check if user is logged in
  //   if (isset($_SESSION['currentUser'])) {
  //     // clear session
  //     unset($_SESSION['currentUser']);
  //     session_destroy();
  //     // send response
  //     header("Content-Type: application/json");
  //     echo json_encode(
  //       [
  //         'loggedOut' => true,
  //         'directToUrl' => 'http://localhost/todoapp/public/index.php'
  //       ]
  //     );
  //   }
  // }

  // public function signUpAdmin(string $name, string $email, string $password, string $confirmPassword)
  // {
    
  //   $this->response['errors']['validationErrors'] = $this->validator->validateOnSignUp($name, $email, $password, $confirmPassword);
  //   if (!empty($this->response['errors']['validationErrors'])) {
  //     // Validation Error
  //     $this->response['status'] = false;
  //     return $this->response;
  //   } else {
  //     if ($this->adminModel->getCount($email) == 1) {
  //       // Dublicate Email Error
  //       $this->response['status'] = false;
  //       $this->response['errors']['authErrors'] = ['available' => false, 'errorMsg' => 'Email address is already taken.'];
  //       return $this->response;
  //     } else {
  //       // No validation Error
  //       if ($this->adminModel->create($name, $email, $password)) {
  //         $this->response['status'] = true;
  //         return $this->response;
  //       } else {
  //         $this->response['status'] = false;
  //         $this->response['errors']['serverErrors'] =  'Something went wrong! Please try to sign up later.';
  //         return $this->response;
  //       }
  //     }
  //   }
  // }

  // public function logInAdmin(string $email, string $password): array
  // {
  //   $this->response['errors']['validationErrors'] = $this->validator->validateOnLogIn($email, $password);
  //   if (!empty($this->response['errors']['validationErrors'])) {
  //     return $this->response;
  //   } else {
  //     $admin = $this->adminModel->select($email);
  //     if ($admin == null) {
  //       $this->response['status'] = false;
  //       $this->response['errors']['authErrors'] = 'This user doesn\'t exists.';
  //       return $this->response;
  //     } else {
  //       $hashedPassword = $admin['password'];
  //       if (password_verify($password, $hashedPassword)) {
  //         $this->response['status'] = true;
  //         $this->response['session'] = [
  //           'userId' => $admin['id'],
  //           'userName' => $admin['name'],
  //           'userEmail' => $admin['email']
  //         ];
  //         return $this->response;
  //       } else {
  //         $this->response['errors']['authErrors'] = 'Password is incorrect.';
  //         return $this->response;
  //       }
  //     }
  //   }
  // }
}
