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
      echo json_encode(["status" => false, "message" => "You have no todos yet"]);
    }
  }

  public function updateTodoStatus()
  {
    $json = $this->fetchJson();
    if ($json === false) {
      http_response_code(400); // Bad Request
      echo json_encode(["error" => "Failed to read request data"]);
      exit;
    }
    $data = $this->decodeJson($json); // Decode the reveived JSON

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
    $todoCount = $this->todoModel->getCount($todoTitle, $this->userId);
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
      echo json_encode(
        [
          "status" => false,
          "error" =>
          [
            "available" => false,
            "errorMsg" => "Todo with the same title already exists"
          ]
        ]
      );
      exit;
    }
  }
  public function deleteTodo()
  {
    $json = $this->fetchJson();
    if ($json === false) {
      http_response_code(400); // Bad Request
      echo json_encode(["error" => "Failed to read request data"]);
      exit;
    }
    $data = $this->decodeJson($json); // Decode the reveived JSON

    // Check if JSON decoding was successful
    if ($data === null) {
      http_response_code(400); // Bad Request
      echo json_encode(["error" => "Invalid JSON data"]);
      exit;
    }

    // Process update todo status
    $todoTitle = $data['title'];
    if ($this->todoModel->delete($todoTitle, $this->userId)) {
      header("Content-Type: application/json");
      echo json_encode(["status" => true]);
      exit;
    } else {
      header("Content-Type: application/json");
      echo json_encode(["status" => false]);
      exit;
    }
  }

  public function updateTodoTitle(string $newTitle, string $oldTitle)
  {
    $todoTitleCount = $this->todoModel->getCount($newTitle, $this->userId);
    if ($todoTitleCount == 0) {
      if ($this->todoModel->updateTitle($newTitle, $oldTitle, $this->userId)) {
        header("Content-Type: application/json");
        echo json_encode(["status" => true]);
        exit;
      } else {
        header("Content-Type: application/json");
        echo json_encode(
          [
            "status" => false,
            "error" => "Couldn't edit title"
          ]
        );
        exit;
      }
    } else {
      header("Content-Type: application/json");
      echo json_encode(
        [
          "status" => false,
          "error" =>
          [
            "available" => false,
            "errorMsg" => "Todo with the same title already exists"
          ]
        ]
      );
      exit;
    }
  }

  public function sortTodos()
  {

    $json = $this->fetchJson();
    if ($json === false) {
      http_response_code(400); // Bad Request
      echo json_encode(["error" => "Failed to read request data"]);
      exit;
    }
    $data = $this->decodeJson($json); // Decode the reveived JSON

    // Check if JSON decoding was successful
    if ($data === null) {
      http_response_code(400); // Bad Request
      echo json_encode(["error" => "Invalid JSON data"]);
      exit;
    }

    $sortOrder = $data['sortOrder'];

    $response = $this->todoModel->sort($sortOrder, $this->userId);
    if (!empty($response)) {
      header("Content-Type: application/json");
      echo json_encode($response);
    } else {
      header("Content-Type: application/json");
      echo json_encode(["status" => false, "message" => "You have no todos yet"]);
    }
  }

  public function searchTodos($todoTitle)
  {
    $response = $this->todoModel->search($todoTitle, $this->userId);
    if (!empty($response)) {
      header("Content-Type: application/json");
      echo json_encode($response);
    } else {
      header("Content-Type: application/json");
      echo json_encode(["status" => false, "message" => "No matches"]);
    }
  }
  protected function fetchJson(): bool|string
  {
    $json = file_get_contents('php://input');
    return $json;
  }
  protected function decodeJson(string $json): ?array
  {
    // Decode the reveived JSON as array
    $data = json_decode($json, true);

    // Check if JSON decoding was successful
    return $data;
  }
}
