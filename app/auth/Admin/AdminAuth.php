<?php

declare(strict_types=1);

namespace App\Auth\Admin;

use App\Models\Admin;
use App\Auth\Auth;
use App\Utils\Validator;

class AdminAuth extends Auth
{

  public function __construct()
  {
    $this->userModel = new Admin();
    $this->validator = new Validator();
  }

  public function signUp(string $name, string $email, string $password, string $confirmPassword, ?array $profileImageFile): array
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
        // No Errors
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
}
