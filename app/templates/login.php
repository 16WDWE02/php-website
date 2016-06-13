<?php $this->layout('master') ?>

<body id="login-page">
  <div class="row align-center" id="login-container">
    <div class="column align-self-middle large-5">
      <h1>Log in to Pinterest</h1>
      <a href="" class="button large expanded" id="facebook-login"><i class="fa fa-facebook-official" aria-hidden="true"></i> Log in with Facebook</a>
      <a href="" class="button large expanded" id="google-login"><i class="fa fa-google" aria-hidden="true"></i> Log in with Google</a>
      <hr>
      <form action="index.php?page=login" method="post">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Create a password">
        <small>Are you a business? <a href="">Get started here</a></small>
        <hr>
        <div class="row">
          <div class="columns large-8">
            <ul class="no-bullet">
              <li><a href="">Forgotten your password?</a></li>
              <li><a href="index.php?page=register">Sign up now</a></li>
            </ul>
          </div>
          <div class="columns large-4">
            <input type="submit" name="login" class="button alert expanded" value="Log in">
          </div>
        </div>
      </form>

    </div>
  </div>

  
