function toggleMoal(modalId) {
  $('#' + modalId).modal('toggle');
}

function openEditModal(callback) {
  document.addEventListener('click', function (event) {
    editBtnId = event.target.id;
    if ((editBtnId).startsWith('edit-')) {
      // display the todo title inside input field
      const todoTitle = editBtnId.replace('edit-', '');
      document.getElementById('editTitleField').value = todoTitle;

      callback(todoTitle);
      // open modal
      toggleMoal('editTodoModal');
    }
  })
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

// Sends request to edit todo
function sendEditTodoRequest(payload) {
  fetch('http://localhost/todoapp/app/Services/updateTodoTitle.php'
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
            document.getElementById('editTitle-error').innerHTML = data.error.errorMsg;
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

function submitEditRequest(todoForm, titleField, oldTitle) {

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
      const form = document.getElementById('editTodoForm');
      const prePayload = new FormData(form);
      prePayload.append('oldTitleField', oldTitle);
      const payload = new URLSearchParams(prePayload);
      console.log(...payload);
      sendEditTodoRequest(payload);
    }
  });

}


//###############################




openEditModal(function (todoTitle) {
  const editTitleField = document.getElementById('editTitleField');

  const editTodoForm = document.getElementById('editTodoForm');

  submitEditRequest(editTodoForm, editTitleField, todoTitle);


});

// submitEditRequest(editTodoForm, editTitleField);


