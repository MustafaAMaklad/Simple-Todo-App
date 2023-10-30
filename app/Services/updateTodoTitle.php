<?php

declare(strict_types=1);

use App\Services\SessionService;
use App\Services\TodoService;



require_once('../../vendor/autoload.php');

$currentUserId = SessionService::getCurrentUserId();

$todoService = new TodoService($currentUserId);

$newTodoTitle = 
$_POST['editTitleField'];
'workeeasfa324235';
$todoId = 
(int) $_POST['todoId'];
'working';


$todoService->updateTodoTitle($newTodoTitle, $todoId);
