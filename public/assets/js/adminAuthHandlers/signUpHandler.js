/*

Create Validate Class

  - An Object of the Validate class is created with a form and fileds properties 

  - The Class should have two validations scopes:
      1. validateOnSubmit(): which will validate the fields when we sumbit the form
      2. validateOnEntery(): which will validate the fields while the input is being typed

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
    this.validateOnSubmit();
    this.validateOnEntry();
  }

  validateOnSubmit() {
    let context = this;

    this.form.addEventListener('submit', e => {
      e.preventDefault();
      let correctness = 0;

      context.fields.forEach(field => {
        const input = document.querySelector(`#${field}`);
        if (context.validateFields(input)) {
          correctness++;
        }
      });
      if (correctness == (context.fields).length) {
        const form = document.getElementById('signUpForm');
        const prePayload = new FormData(form);
        const payload = new URLSearchParams(prePayload);
        console.log(...payload);
        this.signUpRequest(payload);

      }
    }
    );
  }

  signUpRequest(payload) {
    fetch('http://localhost/todoapp/app/Auth/Admin/signUp.php'
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
              document.getElementById('email-error').innerHTML = data.error.errorMsg;
            }
          } else if (data.status == true) {
            window.location.replace(data.directToUrl);
          }

        }
      ).catch(
        err => console.log(err)
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
  validateUploadedFile(field) {
    // const uploadedFile = this.form.querySelector('#profileImage');
    const file = field.files[0];
    const allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (allowedMimeTypes.includes(file.type)) {
      this.setStatus(field, null, "success");
    } else {
      this.setStatus(field, "Only images are allowed", "error");
    }
  }

}

const form = document.querySelector('#signUpForm');
const fields = ["name", "email", "password", "passwordconfirm"];

const validator = new FormValidator(form, fields);
validator.initialize();