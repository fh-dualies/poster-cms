<?php

require_once __DIR__ . '/../../shared/file-path-enum.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<header>
  <div class="container">
    <div class="logo">
      <a href="<?php echo FilePathEnum::get_sys_path('index.php'); ?>">Poster CMS</a>
    </div>
    <nav>
        <?php if (isset($_SESSION['user'])): ?>
          <ul>
            <li><a href="<?php echo FilePathEnum::get_sys_path('index.php'); ?>">Overview</a></li>
            <li><a href="<?php echo FilePathEnum::get_sys_path('pages/account.php'); ?>">Account</a></li>
            <li><a href="<?php echo FilePathEnum::get_sys_path('pages/media.php'); ?>">Media</a></li>
          </ul>
        <?php endif; ?>
    </nav>
    <form class="unset <?php if (isset($_SESSION['user'])) {
      echo 'hidden';
    } ?>" method="POST" action="<?php echo FilePathEnum::get_sys_path('api/post.php'); ?>">
      <a href="<?php echo FilePathEnum::get_sys_path('pages/login.php'); ?>" class="button secondary ghost">Login</a>
    </form>
    <form class="unset <?php if (!isset($_SESSION['user'])) {
      echo 'hidden';
    } ?>" method="POST" action="<?php echo FilePathEnum::get_sys_path('api/post.php'); ?>">
      <button type="submit" name="logout" value="logout" class="ghost">Logout</button>
    </form>
  </div>
</header>
