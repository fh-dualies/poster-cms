<?php
  require_once __DIR__."/../shared/util.php";
?>

<html lang="en">
  <?php
    include_with_prop(
        __DIR__."/../components/head.php", array(
            "title" => "Poster CMS - Login",
            "dirPrefix" => "../",
        )
    );
  ?>
  <body>
    <header>
      <div class="container">
        <div class="logo">
          <a href="../index.php">Poster CMS</a>
        </div>
        <nav>
          <ul>
            <li><a href="../index.php">Overview</a></li>
            <li><a href="account.php">Account</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="poster-designer.php">Poster designer</a></li>
            <li><a href="media.php">Media</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <main class="container">
      <section class="auth-container">
        <form>
          <h1>Login</h1>

          <div>
            <label for="login-email">Email:</label>
            <input type="email" id="login-email" name="login-email" />
          </div>

          <div>
            <label for="login-password">Password:</label>
            <input type="password" id="login-password" name="login-password" />
          </div>

          <button type="submit">Log In</button>

          <p>Don't have an account? <a href="./register.php">Register</a></p>
        </form>
      </section>
    </main>

    <?php
    require  __DIR__."/../components/footer.php";
    ?>
  </body>
</html>
