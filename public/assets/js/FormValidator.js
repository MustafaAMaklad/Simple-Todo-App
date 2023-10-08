/*

Create Validate Class

  - An Object of the Validate class is created with a form and fileds properties 

  - The Class should have two validations scopes:
      1. validateOnSubmit(): which will validate the fields when we sumbit the form
      2. validateOnEntery(): which will validate the fields while the input is being written

  - The class should have a validateField(): which will perform the actual validation rulesn,
    and calls setStatus on validation

  - The class should have a setFieldStatus(): which will be used to toggle between valid or invalid
      - if valid: 
        - enable errors which can represented with an icon, red color, and an error message
      - if invalid: 
        - enable success which can represented with an icon, green color, and no message
  
  - The class should have an intialize(): which will intialize the two validation methods

*/

class FormValidator {

  constructor(form, fields) {
    this.form = form;
    this.fields = fields;
  }

  initialize() {
    this.validateOnEntry();
    this.validateOnSubmit();
  }

  validateOnSubmit() {
    let context = this;

    this.form.addEventListener('submit', e => {
      e.preventDefault();
      let correctness = [];

      context.fields.forEach(field => {
        const input = document.querySelector(`#${field}`);
        if (context.validateFields(input)) {
          correctness.push(true);
        }
      });
      
        let authErr = fetch('http://localhost/me/demo/app/auth/signUp/signUp.php', {mode:'no-cors' ,method: 'POST'})
          .then((response) => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then((data) => {
            
            alert(data); // Log the parsed JSON data
            // Handle the data here, e.g., update the UI or perform actions
            return data.available;
          })
          .catch((error) => {
            console.error('There was a problem with the fetch operation:', error);
            // Handle the error, e.g., show an error message to the user
          });

          if (!authErr) {
            document.querySelector('#email').innerHTML = 'Email already taken.';
          } else {

            this.form.removeEventListener('submit', this.validateOnSubmit);
          }

      }
    );
  }

  validateOnEntry() {
    let context = this;

    this.fields.forEach(field => {
      const input = document.querySelector(`#${field}`);
      input.addEventListener('input', () => {
        context.validateFields(input);
      });
    });
  }

  validateFields(field) {
    /** 
     * 
     * if field is empty setstatus(field, msg, error)
     * 
     * if field is name check matches
     * yes -> setstatus(field, null, success)
     * no -> setstatus(field, msg, error)
     * 
     * if field is email check matches
     * yes -> setstatus(field, null, success)
     * no -> setstatus(field, msg, error)
     * 
     * if field is password check matches
     * yes -> setstatus(field, null, success)
     * no -> setstatus(field, msg, error)
     * 
     * if field is confirm password check matches
     * yes -> setstatus(field, null, success)
     * no -> setstatus(field, msg, error)
     * 
    */

    this.validateEmptyField(field);

    if (field.id === 'name') {
      if (this.validateNameField(field)) {
        return true;
      } else {
        return false;
      }
    }

    else if (field.id === 'email') {
      if (this.validateEmailField(field)) {
        return true;
      } else {
        return false;
      }
    }

    else if (field.id === 'password') {
      if (this.validatePasswordField(field)) {
        return true;
      } else {
        return false;
      }
    }

    else if (field.id === 'passwordconfirm') {
      if (this.validateConfirmationPasswordField(field)) {
        return true;
      } else {
        return false;
      }
    }

    // if(this.validateEmptyField(field) && this.validateNameField(field) && this.validateEmailField(field)
    // && this.validatePasswordField(field) && this.validateConfirmationPasswordField(field)) {
    //   return true;
    // } else {
    //   return false;
    // }
  }

  setStatus(field, msg, status) {
    const successIcon = field.parentElement.querySelector('.icon-success');
    const errorIcon = field.parentElement.querySelector('.icon-error');
    const errorMsg = field.parentElement.querySelector('.error-message');

    if (status === 'success') {
      if (errorIcon) { errorIcon.classList.add('hidden'); }
      if (errorMsg) { errorMsg.innerText = ''; }
      successIcon.classList.remove('hidden');
      field.classList.remove('input-error');
    }

    // Todo if(status === 'error')
    if (status === 'error') {
      if (successIcon) { successIcon.classList.add('hidden'); }
      field.parentElement.querySelector('.error-message').innerText = msg;
      errorIcon.classList.remove('hidden');
      field.classList.add('input-error');
    }
  }

  validateEmptyField(field) {
    if (field.value.trim() == '') {
      this.setStatus(field, `${field.previousElementSibling.innerText} cannot be empty`);
      return false;
    } else {
      this.setStatus(field, null, 'success');
      return true;
    }
  }

  validateNameField(field) {

    const nameRegExp = /^[A-Za-z]+$/;

    if (!nameRegExp.test(field.value)) {
      this.setStatus(field, 'Please enter valid name.', 'error');
      return false;
    } else {
      this.setStatus(field, null, 'success');
      return true;
    }
    // Todo: extend the function to check if name contains numbers or spaces and show more specific message
  }
  validateEmailField(field) {
    const emailRegExp = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

    if (!emailRegExp.test(field.value)) {
      this.setStatus(field, 'Please enter valid email address.', 'error');
      return false;
    } else {
      this.setStatus(field, null, 'success');
      return true;
    }
  }
  validatePasswordField(field) {
    const passwordMinLength = 8;
    const passwordMaxLength = 28;
    const passwordRegExp = /^(?=.*[a-z])(?=.*\d).{8,}$/;

    if (field.value.length < passwordMinLength) {
      this.setStatus(field, 'Password should be atleast 8 characters long', 'error');
      return false;
    } else if (field.value.length > passwordMaxLength) {
      this.setStatus(field, 'Password should be atmost 28 characters long', 'error');
      return false;
    } else if (!passwordRegExp.test(field.value)) {
      this.setStatus(field, 'Password should contain atleast one number and one letter', 'error');
      return false;
    } else {
      this.setStatus(field, null, 'success');
      return true;
    }
  }
  validateConfirmationPasswordField(field) {
    const passwordField = this.form.querySelector('#password');
    if (field.value.trim() == "") {
      this.setStatus(field, "Password confirmation required", "error");
      return false;
    } else if (field.value != passwordField.value) {
      this.setStatus(field, "Password does not match", "error");
      return false;
    } else {
      this.setStatus(field, null, "success");
      return true;
    }
  }
}

const form = document.querySelector('#signUpForm')
const fields = ["name", "email", "password", "passwordconfirm"]

const validator = new FormValidator(form, fields)
validator.initialize()