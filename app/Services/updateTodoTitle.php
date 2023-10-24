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
$oldTodoTitle = 
$_POST['oldTitleField'];
'working';


$todoService->updateTodoTitle($newTodoTitle, $oldTodoTitle);
