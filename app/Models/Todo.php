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
  public function updateStatus(string $title, int $userId): bool
  {
    $query = 'UPDATE todos
    SET status = ?
    WHERE title = ? AND user_id = ?';

    $check = 1;
    $unceck = 0;

    $stmt = $this->db->prepare($query);
    $todoStatus = $this->select($title, $userId, 'status');
    if ($todoStatus) {
      if ($todoStatus['status'] == 0) {
        $stmt->bind_param('isi', $check, $title, $userId);
        $stmt->execute();
        $stmt->close();
      } else {
        $stmt->bind_param('isi', $unceck, $title, $userId);
        $stmt->execute();
        $stmt->close();
      }
      return true;
    } else {
      return false;
    }
  }

  public function select(string $title, int $userId, string $parameter = '*'): ?array
  {
    $query = "SELECT $parameter FROM todos
    WHERE title = ? AND user_id = ?";
    $stmt = $this->db->prepare($query);

    if ($stmt) {
      $stmt->bind_param('si', $title, $userId);

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
    WHERE user_id = ?';
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

  public function getCount(string $title) : int{
    $query = 'SELECT COUNT(title) as count FROM todos
    WHERE title = ?';
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('s', $title);

    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row['count'];
  }

  /**
   * Todo
   * Delete
   * Update
   */
}
