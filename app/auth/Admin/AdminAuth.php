<?php 

declare(strict_types=1);

namespace App\Auth\Admin;
use App\Models\Admin;
use App\Auth\Auth;
use App\Utils\Validator;

class AdminAuth extends Auth{

  public function __construct(){
    $this->userModel = new Admin();
    $this->validator = new Validator();
  }
}