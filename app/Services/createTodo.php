<?php 

declare(strict_types=1);

use App\Services\SessionService;
use App\Services\TodoService;


require_once('../../vendor/autoload.php');

$currentUserId = SessionService::getCurrentUserId();

$todoService = new TodoService($currentUserId);

$todoTitle = $_POST['titleField'];
$todoDescription = $_POST['descriptionField'];


$todoService->createTodo($todoTitle, $todoDescription);
