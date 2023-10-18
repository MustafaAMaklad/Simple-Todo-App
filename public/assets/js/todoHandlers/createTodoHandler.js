
function validateTodo(todoForm, titleField) {
  
  titleField.addEventListener('input', () => {
    if (titleField.value.trim() == '') {
      setStatus(titleField, 'Title is required.', 'error');
    } else {
      setStatus(titleField, null, 'success');
    }
  });
  todoForm.addEventListener('submit', e => {
    e.preventDefault();
    let correctness = 0;
    if (titleField.value.trim() == '') {
      setStatus(titleField, 'Title is required.', 'error');
    } else {
      setStatus(titleField, null, 'success');
      correctness++;
    }
    if (correctness == 1) {
      console.log('checked correctness');
      const form = document.getElementById('createTodoForm');
      console.log('created form');
      const prePayload = new FormData(form);
      console.log('created prepayload');
      const payload = new URLSearchParams(prePayload);
      console.log('created payload');
      console.log(...payload);
      createTodoRequest(payload);
    }
  });

}

function setStatus(field, msg, status) {
  const errorMsg = field.parentElement.querySelector('.error-message');

  if (status === 'success') {
    if (errorMsg) { errorMsg.innerText = ''; }
  }

  if (status === 'error') {
    field.parentElement.querySelector('.error-message').innerText = msg;
  }
}

// Sends request to create todo
function createTodoRequest(payload) {
  fetch('http://localhost/todoapp/app/Services/createTodo.php'
      , {
        method: 'POST',
        body: payload,
      }).then(
        res => res.json()
      ).then(
        data => {
          console.log(data)
          if (data.status == false) {

            if (data.error.available == false) {
              document.getElementById('title-error').innerHTML = data.error.errorMsg;
            }
          } 
          else if (data.status == true) {
            location.reload();
          }
        }
      ).catch(
        err => console.log(err)
      );
}



const titleField = document.getElementById('titleField');

const todoForm = document.getElementById('createTodoForm');
validateTodo(todoForm, titleField);

