<?php
require_once __DIR__ . '/../shared/util.php'; ?>

<html lang="en">
<?php include_with_prop(__DIR__ . '/../components/head.php', [
  'title' => 'Poster CMS - Register',
  'dirPrefix' => '../',
]); ?>
<body>
<?php require __DIR__ . '/../components/nav/navigation.php'; ?>
<main class="container">
  <section class="auth-container">
    <form method="POST" action="/ss25-www1/api/post.php">
        <?php require __DIR__ . '/../components/alert.php'; ?>
      <h1>Register</h1>

      <div>
        <label for="username">Name:</label>
        <input type="text" id="username" name="username" placeholder="john doe" />
      </div>

      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="example@mydomain.com" />
      </div>

      <div>
        <label for="password">Password:</label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="***********"
        />
      </div>

      <button name="register" type="submit">Register</button>

      <p>Already have an account? <a href="./login.php">Login</a></p>
    </form>
  </section>
</main>

<?php require __DIR__ . '/../components/nav/footer.php'; ?>
</body>
</html>
