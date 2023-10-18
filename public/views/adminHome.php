<?php
session_start();
if (!isset($_SESSION['currentUser'])) {
  header('Location: http://localhost/todoapp/public/adminIndex.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Home</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/css/main.css">

<body>
  <div class="container justify-content-center align-items-center">
    <h1>Welcome Back Admin </h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#profileModal">
      Profile
    </button>
    <!-- Start Profile Modal -->
    <div class="modal fade" id="profileModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Profile Details</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <h6>Name: <?php echo ucfirst($_SESSION['currentUser']['userName']); ?></h6>
            <h6>Email: <?php echo ucfirst($_SESSION['currentUser']['userEmail']); ?></h6>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
    <!-- End Profile Modal -->

    <!-- The Dashboard Table-->
    <h2>Todos</h2>
    <table class="table table-hover" id="usersTable">
      <thead>
        <tr>
          <th>User Name</th>
          <th>User Email</th>
          <th>User Todo Title</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>

    <h6><a href="" id="logOutLink">Logout</a></h6>
  </div>

  <!-- Import Jquery and Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <!-- Import Javascript -->
  <script src="../assets/js/adminAuthHandlers/logOutHandler.js"></script>
  <script  src="../assets/js/todoHandlers/adminDashboardHandler.js"></script>
  <!-- <script  src="../assets/js/todoHandlers/createTodoHandler.js"></script> -->
</body>

</html>