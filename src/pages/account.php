<?php
require_once __DIR__ . '/../shared/util.php';

check_auth_status();
?>

<html lang="en">
<?php include_with_prop(__DIR__ . '/../components/head.php', [
  'title' => 'Poster CMS - Account',
  'dirPrefix' => '../',
]); ?>
<body>
<?php require __DIR__ . '/../components/nav/navigation.php'; ?>
<main class="container">
  <header>
    <h1>Account settings</h1>
  </header>

  <form method="POST" action="/ss25-www1/api/post.php">
    <?php require __DIR__ . '/../components/alert.php'; ?>

    <div>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" value="<?php echo htmlspecialchars(
        $_SESSION['user']['username']
      ); ?>" />
    </div>

    <div>
      <label for="email">Email:</label>
      <input disabled type="email" id="email" name="email" value="<?php echo htmlspecialchars(
        $_SESSION['user']['email']
      ); ?>" />
    </div>

    <div>
      <label for="x_username">X:</label>
      <input type="text" id="x_username" name="x_username" value="<?php echo htmlspecialchars(
        $_SESSION['user']['x'] ?? ''
      ); ?>" />
    </div>

    <div>
      <label for="truthsocial_username">Truth Social:</label>
      <input type="text" id="truthsocial_username" name="truthsocial_username" value="<?php echo htmlspecialchars(
        $_SESSION['user']['truth_social'] ?? ''
      ); ?>" />
    </div>

    <button type="submit" name="update_account">Update Account</button>
  </form>
</main>

<?php require __DIR__ . '/../components/nav/footer.php'; ?>
</body>
</html>
