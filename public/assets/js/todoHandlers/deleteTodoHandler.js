function deleteTodo() {
  document.addEventListener('click', function (event) {
    deleteBtnId = event.target.id;
    if ((deleteBtnId).startsWith('delete-')) {
      todoTitle = deleteBtnId.replace('delete-', '');

      fetch('http://localhost/todoapp/app/Services/deleteTodo.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          title: todoTitle
        })
      })
        .then(response =>
          response.json()
        )
        .then(data => {
          console.log(data);
          if (data.status == true) {
            // const tableBody = document.querySelector('#todosTable');
            deleteTableRow('row-' + todoTitle);
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