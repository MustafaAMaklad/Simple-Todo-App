function deleteTodo() {
  document.addEventListener('click', function (event) {
    deleteBtnId = event.target.id;
    if ((deleteBtnId).startsWith('delete-')) {
      const todoContent = deleteBtnId.split('-');
      const todoId = todoContent[todoContent.length - 1];

      fetch('http://localhost/todoapp/app/Services/deleteTodo.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          id: todoId
        })
      })
        .then(response =>
          response.json()
        )
        .then(data => {
          console.log(data);
          if (data.status == true) {
            // const tableBody = document.querySelector('#todosTable');
            deleteTableRow('row-' + todoId);
          } else {
            console.log('problem occured');
          }
        });
    }
  })
}

function deleteTableRow(rowid) {
  var row = document.getElementById(rowid);
  row.parentNode.removeChild(row);
}

deleteTodo();