<?php
session_start();
if (!isset($_SESSION['currentUser'])) {
  header('Location: http://localhost/todoapp/public/index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/css/main.css">
  <!-- <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<body>
  <div class="container justify-content-center align-items-center">
    <h1>Welcome Back </h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#profileModal">
      Profile
    </button>
    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#createTodoModal" id="addTodoButton">
      Add
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
            <img src="<?php echo ucfirst($_SESSION['currentUser']['userProfileImgUrl']); ?>" alt="profile_img"
            style="height: 40px; width: 50px">
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

    <!-- Start Create Todo Modal -->
    <div class="modal fade" id="createTodoModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">New Todo</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form method="post" id="createTodoForm">
              <div class="form-group">
                <label for="titleField">Title:</label>
                <input type="text" class="form-control" placeholder="Enter Title" id="titleField" name="titleField">
                <span class="error-message" id="title-error"></span>
              </div>
              <div class="form-group">
                <label for="descriptionField">Description:</label>
                <input type="text" class="form-control" placeholder="Enter description" id="descriptionField" name="descriptionField">
                <span class="error-message"></span>
              </div>

              <div class="form-group">
                <input type="submit" id="todoSubmit" class="btn btn-success" value="Save">
              </div>
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
    <!-- Start Edit Todo Modal -->
    <div class="modal fade" id="editTodoModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Edit Title</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form method="post" id="editTodoForm">
              <div class="form-group">
                <label for="titleField">Title:</label>
                <input type="text" class="form-control"  id="editTitleField" name="editTitleField" value="">
                <span class="error-message" id="editTitle-error"></span>
              </div>
              <!-- <div class="form-group">
                <label for="descriptionField">Description:</label>
                <input type="text" class="form-control" placeholder="Enter description" id="descriptionField" name="descriptionField">
                <span class="error-message"></span>
              </div> -->

              <div class="form-group">
                <input type="submit" id="todoSubmit" class="btn btn-success" value="Save">
              </div>
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-success" data-dismiss="modal">Save</button> -->
          </div>

        </div>
      </div>
    </div>
    <!-- End Edit Todo Modal -->
    <!-- The Dashboard Table-->
    <h2>Todos</h2>
    <form class="form-inline" id="searchTodoForm" method="post">
    <input class="form-control mr-sm-2" type="text" placeholder="Search" id="todoTitleSearch" name="todoTitleSearch">
    <button class="btn btn-success" type="submit" id="searchTodoBtn">Search</button>
  </form>
    <table class="table table-hover" id="todosTable">
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Date <a href="#" id="sortDesc"><i class="fa-solid fa-arrow-down"></i></a>
          <a href="#" id="sortAsc"><i class="fa-solid fa-arrow-up"></i></a></th>
        </tr>
      </thead>
      <tbody id="todosTableBody">
      </tbody>
    </table>
    <div class="text-center" id="noTodos"></div>

    <h6><a href="" id="logOutLink">Logout</a></h6>
  </div>

  <!-- Import Jquery and Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <!-- Import Javascript -->
  <script src="../assets/js/authHandlers/logOutHandler.js"></script>

  <script  src="../assets/js/todoHandlers/dashboardHandler.js"></script>
  <script  src="../assets/js/todoHandlers/createTodoHandler.js"></script>
  <script  src="../assets/js/todoHandlers/deleteTodoHandler.js"></script>
  <script  src="../assets/js/todoHandlers/editTodoHandler.js"></script> 
  <script  src="../assets/js/todoHandlers/sortTodoHandler.js"></script> 
  <script  src="../assets/js/todoHandlers/searchTodoHandler.js"></script> 
</body>

</html>