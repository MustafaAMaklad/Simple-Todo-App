<?php

declare(strict_types=1);

namespace App\Services;

class SessionService
{

  public static function startSession(array $session)
  {
    session_start();
    $_SESSION['currentUser'] = $session;
  }

  public function checkSession()
  {
    session_start();

    if (!isset($_SESSION['currentUser'])) {
      header('Location: http://localhost/todoapp/public/index.php');
      exit;
    }
  }
  public static function getCurrentUserId()
  {
    session_start();

    if (!isset($_SESSION['currentUser'])) {

      header('Location: http://localhost/todoapp/public/index.php');
      exit;
    } else {
      return $_SESSION['currentUser']['userId'];
    }
  }
}
