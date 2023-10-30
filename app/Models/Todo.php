<?php


declare(strict_types=1);

namespace App\Models;

class Todo extends Model
{
  public function create(string $title, int $userId, string $description): bool
  {
    $query = 'INSERT INTO todos (title, user_id, description) VALUES (?, ?, ?)';
    $stmt = $this->db->prepare($query);
    if ($stmt) {
      $stmt->bind_param("sis", $title, $userId, $description);
      if ($stmt->execute()) {
        $stmt->close();
        return true;
      } else {
        $stmt->close();
        return false;
      }
    }
    return false;
  }
  public function select(int $todoId, string $parameter = '*'): ?array
  {
    $query = "SELECT $parameter FROM todos
    WHERE id = ?";
    $stmt = $this->db->prepare($query);

    if ($stmt) {
      $stmt->bind_param('i', $todoId);

      if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
          $assoc = $result->fetch_assoc();
          $stmt->close();

          return $assoc;
        } else {
          $stmt->close();

          return null;
        }
      }
    }
  }
  public function selectMany(int $userId): array
  {
    $query = 'SELECT * FROM todos
    WHERE user_id = ?
    ORDER BY created_at DESC';
    $todos = [];

    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      while ($todo = $result->fetch_assoc()) {
        $todos[] = $todo;
      }
    }
    return $todos;
  }
  public function getCount(string $title, int $userId): int
  {
    $query = 'SELECT COUNT(title) as count FROM todos
    WHERE title = ? AND user_id = ?';
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('si', $title, $userId);

    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row['count'];
  }
  public function updateStatus(int $todoId): bool
  {
    $query = 'UPDATE todos
    SET status = ?
    WHERE id = ?';

    $check = 1;
    $unceck = 0;

    $stmt = $this->db->prepare($query);
    $todoStatus = $this->select($todoId, 'status');
    if ($todoStatus) {
      if ($todoStatus['status'] == 0) {
        $stmt->bind_param('ii', $check, $todoId);
        $stmt->execute();
        $stmt->close();
      } else {
        $stmt->bind_param('ii', $unceck, $todoId);
        $stmt->execute();
        $stmt->close();
      }
      return true;
    } else {
      return false;
    }
  }



  /**
   * Todo
   * Update
   */

  public function updateTitle(string $newTitle, int $todoId): bool
  {
    $query = 'UPDATE todos
    SET title = ?
    WHERE id = ?';

    $stmt = $this->db->prepare($query);
    $stmt->bind_param('si', $newTitle, $todoId);

    if ($stmt->execute()) {
      $stmt->close();
      return true;
    } else {
      $stmt->close();
      return false;
    }
  }
  public function updateDescription(string $newDescription, int $todoId): bool
  {
    $query = 'UPDATE todos
    SET description = ?
    WHERE id = ?';

    $stmt = $this->db->prepare($query);
    $stmt->bind_param('si', $newDescription, $todoId);
    if ($stmt->execute()) {
      $stmt->close();
      return true;
    } else {
      $stmt->close();
      return false;
    }
  }
  public function sort($sortOrder, int $userId): array
  {
    $todos = [];

    if ($sortOrder == 'asc') {
      $todos = $this->sortAsc($userId);
    } else {
      $todos = $this->selectMany($userId);
    }
    return $todos;
  }

  public function sortAsc(int $userId): array
  {
    $query = 'SELECT * FROM todos
      WHERE user_id = ?
      ORDER BY created_at ASC';

    $todos = [];

    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      while ($todo = $result->fetch_assoc()) {
        $todos[] = $todo;
      }
    }
    return $todos;
  }

  public function search(string $title, int $userId): array
  {
    $query = 'SELECT * FROM todos
    WHERE user_id = ? AND title LIKE ?';
    $searchTitle = '%' . $title . '%';
    $todos = [];

    $stmt = $this->db->prepare($query);
    $stmt->bind_param('is', $userId, $searchTitle);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      while ($todo = $result->fetch_assoc()) {
        $todos[] = $todo;
      }
    }
    return $todos;
  }
  public function delete(int $todoId): bool
  {
    $query = 'DELETE FROM todos
    WHERE id = ?';

    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $todoId);
    if ($stmt->execute()) {
      $stmt->close();
      return true;
    } else {
      $stmt->close();
      return false;
    }
  }
}
