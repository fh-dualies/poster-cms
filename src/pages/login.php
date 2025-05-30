<?php
require_once __DIR__ . '/../shared/util.php'; ?>

<html lang="en">
<?php include_with_prop(__DIR__ . '/../components/head.php', [
  'title' => 'Poster CMS - Login',
  'dirPrefix' => '../',
]); ?>
<body>
<?php require __DIR__ . '/../components/nav/navigation.php'; ?>
<main class="container">
  <section class="auth-container">
    <form method="POST" action="/ss25-www1/api/post.php">
    <?php require __DIR__ . '/../components/alert.php'; ?>
      <h1>Login</h1>

      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="example@mydomain.com" />
      </div>

      <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="***********" />
      </div>

      <button name="login" type="submit">Log In</button>

      <p>Don't have an account? <a href="./register.php">Register</a></p>
    </form>
  </section>
</main>

<?php require __DIR__ . '/../components/nav/footer.php'; ?>
</body>
</html>
