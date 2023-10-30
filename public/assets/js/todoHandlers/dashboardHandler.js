// Fetch data when user loggs in
async function fetchTodos() {
  try {
    const response = await fetch('http://localhost/todoapp/app/Services/readTodo.php', {
      method: 'GET',
    });

    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const data = await response.json();

    console.log(data);
    return data;
  } catch (error) {
    console.error('Error:', error);
  }
}

// Display todos in a table
function displayTodos() {
  const tableBody = document.querySelector('#todosTableBody');

  fetchTodos().then((data) => {
    if (data.status == false) {
      document.getElementById('noTodos').innerHTML = data.message;
    } else {
      Object.keys(data).forEach((property) => {
        const row = tableBody.insertRow();
        row.id = 'row-' + data[property].id;

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
        checkButton.id = 'check-' + data[property].title + '-' + data[property].id;
        editButton.id = 'edit-' + data[property].title + '-' + data[property].id;
        deleteButton.id = 'delete-' + data[property].title + '-' + data[property].id;
        titleSpan.id = 'title-' + data[property].title + '-' + data[property].id;
        descriptionSpan.id = 'description-' + data[property].title + '-' + data[property].id;

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
// to formate todo date
function formatDate(inputDateString) {
  const inputDate = new Date(inputDateString);

  const year = inputDate.getFullYear();
  const month = (inputDate.getMonth() + 1).toString().padStart(2, '0');
  const day = inputDate.getDate().toString().padStart(2, '0');

  let hours = inputDate.getHours();
  const amPm = hours >= 12 ? 'PM' : 'AM';
  hours = (hours % 12 || 12).toString().padStart(2, '0');

  const minutes = inputDate.getMinutes().toString().padStart(2, '0');

  return `${year}-${month}-${day} ${hours}:${minutes} ${amPm}`;
}

function updateTodoStatus() {
  displayTodos();

  document.addEventListener('click', function (event) {
    btnId = event.target.id;
    titleId = btnId.replace('check', 'title');
    descriptionId = btnId.replace('check', 'description');
    if ((btnId).startsWith('check-')) {
      todoId = btnId.split('-')[2];

      fetch('http://localhost/todoapp/app/Services/updateTodoStatus.php', {
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
          const button = document.getElementById(btnId);
          const title = document.getElementById(titleId);
          const description = document.getElementById(descriptionId);
          toggleStatus(button, title, description);
        });
    }
  })
}
// Toggle between check and unckeck status
function toggleStatus(button, title, description) {
  if (button.innerHTML == 'Check') {
    button.innerHTML = 'Uncheck';
    button.classList.replace('btn-primary', 'btn-success');
    title.classList.add('cross-line');
    description.classList.add('cross-line');
  } else if (button.innerHTML == 'Uncheck') {
    button.innerHTML = 'Check';
    button.classList.replace('btn-success', 'btn-primary');
    title.classList.remove('cross-line');
    description.classList.remove('cross-line');
  }
}


updateTodoStatus();



