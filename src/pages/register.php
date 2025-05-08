<?php
require_once __DIR__ . '/../shared/util.php'; ?>

<html lang="en">
<?php include_with_prop(__DIR__ . '/../components/head.php', [
    'title' => 'Poster CMS - Register',
    'dirPrefix' => '../',
]); ?>
<body>
<?php require __DIR__ . '/../components/navigation.php'; ?>

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

      <p>Already have an account? <a href="./login.php">Login</a></p>
    </form>
  </section>
</main>

<?php require __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
