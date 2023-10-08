function submitForm() {
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.open('POST', '../app/auth/signUp/signUp.php');

  xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      console.log(typeof this.responseText);
    }
  }

  var myForm = document.getElementById('signUpForm');
  var formData = new FormData(myForm);

  xmlhttp.send(formData);
}