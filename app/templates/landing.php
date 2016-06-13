<?php

  $this->layout('master', [
    'title'=>'Welcome to Pinterest',
    'desc'=>'Sign up and get inspired with designs'
  ]);

?>

<body id="intro">
  <div class="row align-center text-center" id="hello">
    <div class="column align-self-middle large-8">
      <i class="fa fa-pinterest" aria-hidden="true" id="hello-logo"></i>
      <h1>Use Pinterest to get inspired!</h1>
      <p>Join Pinterest to discover and save creative ideas.</p>
      <a href="index.php?page=login" class="button secondary" id="hello-login">Login</a>
      <div class="row align-center">
        <div class="column large-6">
          <a href="" class="button large expanded" id="facebook-login"><i class="fa fa-facebook-official" aria-hidden="true"></i> Continue with Facebook</a>
          <hr>
          <form action="index.php?page=landing" method="post">
            <input type="text" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Create a password">
            <input type="submit" class="button alert expanded" value="Sign Up">
          </form>
          <small>Creating an account means you're OK with Pinterest's <a href="">Terms of Service</a> and <a href="">Privacy Policy</a></small>
        </div>
      </div>
    </div>
  </div>