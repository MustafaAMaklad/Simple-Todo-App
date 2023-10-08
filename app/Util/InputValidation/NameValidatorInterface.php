<?php 

declare(strict_types=1);

// namespace App\Util\InputValidation;
interface NameValidatorInterface {
  public function validateName(string $name): string;
}