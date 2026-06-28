<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Auth Page</title>

<script src="https://accounts.google.com/gsi/client" async defer></script>

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family: Arial, sans-serif;
}

body{
  height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  background:#000;
}

.container{
  width:350px;
  background:#111;
  padding:30px;
  border-radius:10px;
  box-shadow:0 0 20px rgba(255,122,0,0.3);
}

.tabs{
  display:flex;
  margin-bottom:20px;
}

.tabs button{
  flex:1;
  padding:10px;
  border:none;
  cursor:pointer;
  background:#222;
  color:#fff;
  font-weight:bold;
}

.tabs button.active{
  background:#ff7a00;
}

.form{
  display:none;
}

.form.active{
  display:block;
}

input{
  width:100%;
  padding:10px;
  margin:10px 0;
  border:none;
  border-radius:5px;
  background:#222;
  color:#fff;
}

.btn{
  width:100%;
  padding:10px;
  border:none;
  background:#ff7a00;
  color:#fff;
  font-weight:bold;
  cursor:pointer;
  border-radius:5px;
}

.google-section{
  margin-top:15px;
  text-align:center;
}

</style>
</head>

<body>

<div class="container">

  <div class="tabs">
    <button class="active" onclick="showForm('signup')">Sign Up</button>
    <button onclick="showForm('signin')">Sign In</button>
  </div>

  <!-- SIGN UP -->
  <form id="signup" class="form active">
    <input type="text" placeholder="Name" required>
    <input type="email" placeholder="Email" required>
    <input type="tel" placeholder="Contact" required>
    <input type="password" placeholder="Password" required>
    <button class="btn">Sign Up</button>
  </form>

  <!-- SIGN IN -->
  <form id="signin" class="form">
    <input type="email" placeholder="Email" required>
    <input type="password" placeholder="Password" required>
    <button class="btn">Sign In</button>
  </form>

  <!-- ONE Google Button for both -->
  <!--only change client_id for new google clude console and google authentication-->
  <div class="google-section">
    <div id="g_id_onload"
         data-client_id="1068476382856-ee0nb1rgdtnun1u5fjef41n7bfoe2b69.apps.googleusercontent.com"
         data-callback="handleCredentialResponse"
         data-auto_prompt="false">
    </div>

    <div class="g_id_signin"
         data-type="standard"
         data-size="large"
         data-theme="filled_black"
         data-shape="pill"
         data-text="continue_with">
    </div>
  </div>

</div>

<script>
function showForm(type){
  document.querySelectorAll('.form').forEach(f => f.classList.remove('active'));
  document.getElementById(type).classList.add('active');

  document.querySelectorAll('.tabs button').forEach(btn => btn.classList.remove('active'));
  event.target.classList.add('active');
}

// Google Login Callback
function handleCredentialResponse(response) {

  fetch("google-login.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      credential: response.credential
    })
  })
  .then(res => res.json())
  .then(data => {
    if(data.status === "success"){
      alert("Welcome " + data.user.name);
      window.location.href = "games.php";
    } else {
      alert(data.message);
    }
  });
}

// Decode JWT
function parseJwt(token) {
  let base64Url = token.split('.')[1];
  let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
  let jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
  }).join(''));

  return JSON.parse(jsonPayload);
}
</script>

</body>
</html>