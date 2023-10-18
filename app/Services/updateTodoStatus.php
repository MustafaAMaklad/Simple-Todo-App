<?php

declare(strict_types=1);

use App\Services\SessionService;
use App\Services\TodoService;

require_once('../../vendor/autoload.php');

// if (isset($_SESSION['currentUser'])) {
//     $session = $_SESSION['currentUser'];
//     $json = file_get_contents('php://input');

//     if ($json === false) {
//       http_response_code(400); // Bad Request
//       echo json_encode(["error" => "Failed to read request data"]);
//       exit;
//     }
//     $data = json_decode($json, true); // Decode the reveived JSON

//     // Check if JSON decoding was successful
//     if ($data === null) {
//       http_response_code(400); // Bad Request
//       echo json_encode(["error" => "Invalid JSON data"]);
//       exit;
//     }

//     // Process update todo status
//     $todoTitle = $data['title'];
//     $userId = $session['userId'];

//     $todoModel = new Todo();

//     if($todoModel->updateStatus($todoTitle, $userId)) {
//       header("Content-Type: application/json");
//       echo json_encode(["status" => true]);
//       exit;
//     } else {
//       header("Content-Type: application/json");
//       echo json_encode(["status" => false]);
//       exit;
//     }
    
// } else {
//   header('Location: http://localhost/todoapp/public/index.php');
//   exit;
// }

$currentUserId = SessionService::getCurrentUserId();

$todoService = new TodoService($currentUserId);

$todoService->updateTodoStatus();
