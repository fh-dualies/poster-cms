<?php
require_once __DIR__ . '/../../shared/file-path-enum.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<header>
  <div class="container">
    <div class="logo">
      <a href="/ss25-www1/src/index.php">Poster CMS</a>
    </div>
    <nav>
      <ul>
        <li><a href="/ss25-www1/src/index.php">Overview</a></li>
        <li><a href="/ss25-www1/src/pages/account.php">Account</a></li>
        <li><a href="/ss25-www1/src/pages/login.php">Login</a></li>
        <li><a href="/ss25-www1/src/pages/poster-designer.php">Poster designer</a></li>
        <li><a href="/ss25-www1/src/pages/media.php">Media</a></li>
      </ul>
    </nav>
    <form class="unset <?php if (isset($_SESSION['user'])) {
      echo 'hidden';
    } ?>" method="POST" action="/ss25-www1/api/post.php">
      <button type="submit" name="redirect" value="<?php echo FilePathEnum::LOGIN->get_path(); ?>" class="ghost">Login</button>
    </form>
    <form class="unset <?php if (!isset($_SESSION['user'])) {
      echo 'hidden';
    } ?>" method="POST" action="/ss25-www1/api/post.php">
      <button type="submit" name="logout" value="logout" class="ghost">Logout</button>
    </form>
  </div>
</header>
