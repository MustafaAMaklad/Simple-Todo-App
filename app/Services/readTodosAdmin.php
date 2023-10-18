<?php 

declare(strict_types=1);

use App\Services\SessionService;

use App\Models\Admin;



require_once('../../vendor/autoload.php');


$currentUserId = SessionService::getCurrentUserId();

$adminModel = new Admin();

$usersTodos = $adminModel->SelectAllUsersTodos();

if (!empty($usersTodos)) {
  header("Content-Type: application/json");
  echo json_encode($usersTodos);
} else {
  header("Content-Type: application/json");
  echo json_encode(["status" => false, "message"=> "No Users Yet"]);
}

