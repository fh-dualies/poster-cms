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
  <div class="alert-container">
      <?php require __DIR__ . '/../components/alert.php'; ?>
  </div>

  <header>
    <h1>Account settings</h1>
  </header>

  <form method="POST" action="<?php echo FilePathEnum::get_sys_path('api/post.php'); ?>">
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

    <div class="separate-container">
      <button type="submit" name="update_account">Update Account</button>
      <button id="delete-account-btn" type="submit" name="delete_account" class="danger">Delete Account</button>
    </div>
  </form>
</main>

<?php require __DIR__ . '/../components/nav/footer.php'; ?>
</body>
</html>

<script>
  document
    .getElementById('delete-account-btn')
    .addEventListener('click', function(e) {
      if (!confirm('Are you sure you want to delete your account?')) {
        e.preventDefault();
      }
    });
</script>
