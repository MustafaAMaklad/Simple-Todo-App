const logOutLink = document.getElementById('logOutLink');

logOutLink.addEventListener('click', e => {
  fetch('http://localhost/todoapp/app/Auth/logout.php', {method: 'POST'})
    .then(
      res => res.json()
    ).then(
      data => {
        console.log(data)
        if (data.loggedOut == true) {
          console.log(data.directToUrl)
          window.location.replace(data.directToUrl);
        }
      }
    ).catch(
      err => console.log(err)
    );
})

function logOut() {
  
}
