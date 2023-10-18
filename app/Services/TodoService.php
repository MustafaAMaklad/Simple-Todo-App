<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Todo;

class TodoService
{
  protected $todoModel;
  public function __construct(protected int $userId)
  {
    $this->todoModel = new Todo();
  }

  public function readTodos()
  {
    $response = $this->todoModel->selectMany($this->userId);
    if (!empty($response)) {
      header("Content-Type: application/json");
      echo json_encode($response);
    } else {
      header("Content-Type: application/json");
      echo json_encode(["status" => false, "message"=> "You have no todos yet"]);
    }
  }

  public function updateTodoStatus()
  {
    $json = file_get_contents('php://input');

    if ($json === false) {
      http_response_code(400); // Bad Request
      echo json_encode(["error" => "Failed to read request data"]);
      exit;
    }
    $data = json_decode($json, true); // Decode the reveived JSON

    // Check if JSON decoding was successful
    if ($data === null) {
      http_response_code(400); // Bad Request
      echo json_encode(["error" => "Invalid JSON data"]);
      exit;
    }

    // Process update todo status
    $todoTitle = $data['title'];
    if ($this->todoModel->updateStatus($todoTitle, $this->userId)) {
      header("Content-Type: application/json");
      echo json_encode(["status" => true]);
      exit;
    } else {
      header("Content-Type: application/json");
      echo json_encode(["status" => false]);
      exit;
    }
  }

  public function createTodo(string $todoTitle, string $todoDescription = '')
  {
    $todoCount = $this->todoModel->getCount($todoTitle);
    if ($todoCount == 0) {
      if ($this->todoModel->create($todoTitle, $this->userId, $todoDescription)) {
        header("Content-Type: application/json");
        echo json_encode(["status" => true]);
        exit;
      } else {
        header("Content-Type: application/json");
        echo json_encode(["status" => false]);
        exit;
      }
    } else {
      header("Content-Type: application/json");
      echo json_encode(["status" => false, "error" => [
        "available" => false,
        "errorMsg" => "Todo with the same title already exists"
      ]]);
      exit;
    }
  }
}
