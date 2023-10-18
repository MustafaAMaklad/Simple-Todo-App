
function validateEmpty(field) {
  if (field.value.trim() == '') {

    return false;
  } else {
    return true;
  }

}
const email = document.getElementById('email');
const password = document.getElementById('password');
const form = document.getElementById('logInForm');
const fields = [email, password];

form.addEventListener('submit', e => {
  e.preventDefault();
  let correctness = 0;

  if (email.value.trim() == '') {
    document.getElementById('email-error').innerHTML = 'Please enter your email.';
  } else if (email.value.trim() != '') {
    correctness++;
  }
  if (password.value.trim() == '') {
    document.getElementById('password-error').innerHTML = 'Please enter your password.';
  } else if (password.value.trim() != '') {
    correctness++;
  }


  if (correctness == 2) {
    const prePayload = new FormData(form);
    const payload = new URLSearchParams(prePayload);
    console.log(...payload);

    fetch('http://localhost/todoapp/app/Auth/login.php'
      , {
        method: 'POST',
        body: prePayload,
      }).then(
        res => res.json()
      ).then(
        data => {
          console.log(data)
          if (data.status == false) {
            if (data.error.correct == false) {
              document.getElementById('email-error').innerHTML = data.error.errorMsg;
            }
          } else if (data.status == true) {
            console.log(data.session);
            window.location.replace(data.directToUrl);
          }
        }
      ).catch(
        err => console.log(err)
      );
  }
})

form.addEventListener('input', e => {
  if (email.value.trim() != '') {
    document.getElementById('email-error').innerHTML = '';
  }
  if (password.value.trim() != '') {
    document.getElementById('password-error').innerHTML = '';
  }
})
