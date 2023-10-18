async function fetchTodos() {
  try {
    const response = await fetch('http://localhost/todoapp/app/Services/readTodosAdmin.php', {
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

function displayTodos() {
  fetchTodos().then((data) => {
    const tableBody = document.querySelector('#usersTable');


    Object.keys(data).forEach((property) => {
      const row = tableBody.insertRow();
      const cell1 = row.insertCell(0);
      const cell2 = row.insertCell(1);
      const cell3 = row.insertCell(2);
      


      const userNameSpan = document.createElement('span');
      const userEmailSpan = document.createElement('span');
      const userTodoTitleSpan = document.createElement('span');



      userNameSpan.innerHTML = (data[property].name).trim();
      userEmailSpan.innerHTML = (data[property].email).trim();
      if(data[property].title != null){
        userTodoTitleSpan.innerHTML = (data[property].title).trim();
      } else {
        userTodoTitleSpan.innerHTML = 'None';
        userTodoTitleSpan.style.color = 'red';
      }


     
      cell1.appendChild(userNameSpan);
      cell2.appendChild(userEmailSpan);
      cell3.appendChild(userTodoTitleSpan);
    });
  });
}

displayTodos();