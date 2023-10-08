<?php 

declare(strict_types=1);
// namespace App\Util\InputValidation;
interface EmailValidatorInterface {
  public function validateEmail(string $email): string;
}