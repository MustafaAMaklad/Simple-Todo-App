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



  /**
   * Todo
   * Update
   */

  public function updateTitle(string $newTitle, string $oldTitle, int $userId): bool
  {
    $query = 'UPDATE todos
    SET title = ?
    WHERE title = ? AND user_id = ?';

    $stmt = $this->db->prepare($query);
    $stmt->bind_param('ssi', $newTitle, $oldTitle, $userId);

    if ($stmt->execute()) {
      $stmt->close();
      return true;
    } else {
      $stmt->close();
      return false;
    }
  }
  public function updateDescription(string $newDescription, string $oldDescription, int $userId): bool
  {
    $query = 'UPDATE todos
    SET description = ?
    WHERE title = ? AND user_id = ?';

    $stmt = $this->db->prepare($query);
    $stmt->bind_param('ssi', $newDescription, $oldDescription, $userId);
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

  public function sortDesc(int $userId): array
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
  public function delete(string $title, int $userId): bool
  {
    $query = 'DELETE FROM todos
    WHERE title = ? AND user_id = ?';

    $stmt = $this->db->prepare($query);
    $stmt->bind_param('si', $title, $userId);
    if ($stmt->execute()) {
      $stmt->close();
      return true;
    } else {
      $stmt->close();
      return false;
    }
  }
}
