async function sendSortRequest(url, data = {}) {
  const response = await fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json,'
    },
    body: JSON.stringify(data),
  });
  return response.json();
}

function sort(order) {
  const url = 'http://localhost/todoapp/app/Services/sortTodos.php';
  data = { 'sortOrder': order };

  const tableBody = document.querySelector('#todosTableBody');
  sendSortRequest(url, data).then((data) => {
    console.log(data);
    $("#todosTableBody").empty();
    if (data.status == false) {
      document.getElementById('noTodos').innerHTML = data.message;
    } else {
      
      Object.keys(data).forEach((property) => {
        const row = tableBody.insertRow();
        row.id = 'row-' + data[property].title;

        // inster cells into row
        const cell1 = row.insertCell(0);
        const cell2 = row.insertCell(1);
        const cell3 = row.insertCell(2);
        const cell4 = row.insertCell(3);
        const cell5 = row.insertCell(4);
        const cell6 = row.insertCell(5);

        // intialize contents for table row cell
        const checkButton = document.createElement('button');
        const editButton = document.createElement('button');
        const deleteButton = document.createElement('button');
        const titleSpan = document.createElement('span');
        const dateSpan = document.createElement('span');
        const descriptionSpan = document.createElement('span');

        // Content
        checkButton.id = 'check-' + data[property].title;
        editButton.id = 'edit-' + data[property].title;
        deleteButton.id = 'delete-' + data[property].title;
        titleSpan.id = 'title-' + data[property].title;
        descriptionSpan.id = 'description-' + data[property].title;

        // Values
        titleSpan.innerHTML = (data[property].title).trim();
        descriptionSpan.innerHTML = (data[property].description).trim();
        dateSpan.innerHTML = formatDate(data[property].created_at);

        editButton.innerHTML = 'Edit';
        deleteButton.innerHTML = 'Delete';
        editButton.classList.add('btn', 'btn-warning');
        deleteButton.classList.add('btn', 'btn-danger');

        checkButton.type = 'submit';
        if (data[property].status == 0) {
          checkButton.innerHTML = 'Check';

          checkButton.classList.add('btn', 'btn-primary');
          titleSpan.classList.remove('cross-line');
          descriptionSpan.classList.remove('cross-line');

        } else if (data[property].status == 1) {
          checkButton.innerHTML = 'Uncheck';

          checkButton.classList.add('btn', 'btn-success');
          titleSpan.classList.add('cross-line');
          descriptionSpan.classList.add('cross-line');
        }
        cell1.appendChild(titleSpan);
        cell2.appendChild(descriptionSpan);
        cell3.appendChild(dateSpan);
        cell4.appendChild(checkButton);
        cell5.appendChild(editButton);
        cell6.appendChild(deleteButton);
      });
    }
    
  });
}

document.getElementById('sortAsc').onclick = function () {
  sort('asc');
};
document.getElementById('sortDesc').onclick = function () {
  sort('desc');
};

