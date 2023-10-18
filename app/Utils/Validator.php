<?php 

declare(strict_types=1);

namespace App\Utils;

class Validator implements 
NameValidatorInterface,
EmailValidatorInterface,
PasswordValidatorInterface {
  private array $validationErrors = [];
  private string $nameRegex = '/^[A-Za-z]+$/';
  private string $emailRegex = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/';
  private string $passwordRegex = '/^(?=.*[a-z])(?=.*\d).{8,}$/';
  public function validateName(string $name): string {
    if (empty($name)) {
      return 'Name is required.';
    } elseif (!preg_match($this->nameRegex, $name)) {
      return 'Name must contain only characters.';
    } else {
      return '';
    }
  }
  public function validateEmail(string $email): string {
    if (empty($email)) {
      return 'Email is required.';
    } elseif(!preg_match($this->emailRegex, $email)) {
      return 'Email is invlaid.';
    } else {
      return '';
    }
  }
  public function validatePassword(string $password): string {
    if (empty($password)) {
      return 'Password is required.';
    } elseif(strlen($password) < 8) {
      return 'Password must contain at least 8 characers.';
    } elseif(!preg_match($this->passwordRegex, $password)) {
      return 'Password must contain at least one character and one number.';
    } else {
      return '';
    }
  }
  public function validateConfirmationPassword(string $password, string $passwordConfirm): string {
    if ($password != $passwordConfirm) {
      return 'Passwords do not match.';
    } else {
      return '';
    }
  }
  
  public function validateOnSignUp(string $name, string $email, string $password, string $passwordConfirm) :array{
    $nameVal = $this->validateName($name);
    $emailVal = $this->validateEmail($email);
    $passwordVal = $this->validatePassword($password);
    $passwordConfirmVal = $this->validateConfirmationPassword($password, $passwordConfirm);
    if (!empty($nameVal)) {
      array_push($this->validationErrors, $nameVal);
    }
    if (!empty($emailVal)) {
      array_push($this->validationErrors, $emailVal);
    }
    if (!empty($passwordVal)) {
      array_push($this->validationErrors, $passwordVal);
    }
    if (!empty($passwordConfirmVal)) {
      array_push($this->validationErrors, $passwordConfirmVal);
    }
    return $this->validationErrors;
  }

  public function validateOnLogIn(string $email, string $password): array {
    if (empty($email)) {
      array_push($this->validationErrors, 'Please enter your email.');
    }
    if (empty($password)) {
      array_push($this->validationErrors, 'Please enter your password.');
    }
    return $this->validationErrors;
  }
}