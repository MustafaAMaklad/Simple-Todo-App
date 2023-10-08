const validator = new JustValidate('#signUpForm');

validator
  .addField('#name', [
    {
      rule: 'required',
    },
    {
      rule: 'customRegexp',
      value: /[a-z]/gi,
    }
  ])
  .addField(
    '#email', [
      {
        rule: 'required',
      },
      {
        rule: 'email',
      }, 
      {
        validator: () => {
          var response = fetch('http://localhost/me/demo/app/auth/signUp/signUp.php').then((response) => {
            return response.json();
          });
          alert(response);
          return false;
        },
        errorMessage: 'Email is already taken.',
      }
    ]
  )
  .addField(
    '#password', [
      {
        rule: 'required',
      },
      {
        rule: 'password',
      }
    ]
  )
  .addField(
    '#passwordconfirm', [
      {
        validator: (value, fields) => {
          return value === fields['#password'].elem.value;
        },
        errorMessage: 'Passwords Do Not Match',
      },
      
    ]
  )
  .onSuccess((event) => {
      document.getElementById('signUpForm').submit();
    }
  );