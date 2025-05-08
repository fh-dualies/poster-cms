<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Poster CMS - Register</title>
    <link rel="icon" href="../static/images/logo/favicon.ico" sizes="any" />
    <link rel="stylesheet" href="../styles/main.css" />
  </head>
  <body>
    <header>
      <div class="container">
        <div class="logo">
          <a href="../index.php">Poster CMS</a>
        </div>
        <nav>
          <ul>
            <li><a href="../index.php">Overview</a></li>
            <li><a href="account.html">Account</a></li>
            <li><a href="login.html">Login</a></li>
            <li><a href="poster-designer.html">Poster designer</a></li>
            <li><a href="media.html">Media</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <main class="container">
      <section class="auth-container">
        <form>
          <h1>Register</h1>

          <div>
            <label for="register-name">Full Name:</label>
            <input type="text" id="register-name" name="register-name" />
          </div>

          <div>
            <label for="register-email">Email:</label>
            <input type="email" id="register-email" name="register-email" />
          </div>

          <div>
            <label for="register-password">Password:</label>
            <input
              type="password"
              id="register-password"
              name="register-password"
            />
          </div>

          <button type="submit">Log In</button>

          <p>Already have an account? <a href="./login.html">Login</a></p>
        </form>
      </section>
    </main>

    <?php
    require  __DIR__."/../components/footer.php";
    ?>
  </body>
</html>
