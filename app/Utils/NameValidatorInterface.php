<?php 

declare(strict_types=1);

namespace App\Utils;
interface NameValidatorInterface {
  public function validateName(string $name): string;
}