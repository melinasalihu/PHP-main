<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login & Signup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container" style="max-width: 400px; margin-top: 80px;">
  
  <!-- LOGIN FORM -->
  <div id="login-form">
    <h2 class="mb-4 text-center">Login</h2>
    <form>
      <div class="mb-3">
        <label for="loginEmail" class="form-label">Email address</label>
        <input type="email" class="form-control" id="loginEmail" placeholder="Enter email" required />
      </div>
      <div class="mb-3">
        <label for="loginPassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="loginPassword" placeholder="Password" required />
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <p class="mt-3 text-center">
      Nuk ke llogari? <a href="#" id="show-signup">Regjistrohu këtu</a>
    </p>
  </div>
  
  <!-- SIGNUP FORM -->
  <div id="signup-form" style="display: none;">
    <h2 class="mb-4 text-center">Sign Up</h2>
    <form>
      <div class="mb-3">
        <label for="signupName" class="form-label">Name</label>
        <input type="text" class="form-control" id="signupName" placeholder="Enter your name" required />
      </div>
      <div class="mb-3">
        <label for="signupEmail" class="form-label">Email address</label>
        <input type="email" class="form-control" id="signupEmail" placeholder="Enter email" required />
      </div>
      <div class="mb-3">
        <label for="signupPassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="signupPassword" placeholder="Password" required />
      </div>
      <button type="submit" class="btn btn-success w-100">Sign Up</button>
    </form>
    <p class="mt-3 text-center">
      Ke llogari? <a href="#" id="show-login">Hyr këtu</a>
    </p>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Script për të ndërruar midis formave
  document.getElementById('show-signup').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('signup-form').style.display = 'block';
  });
  document.getElementById('show-login').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('signup-form').style.display = 'none';
    document.getElementById('login-form').style.display = 'block';
  });
</script>

</body>
</html>




