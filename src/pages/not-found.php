<?php
require_once __DIR__ . '/../shared/util.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

var_dump($_SESSION);
?>

<html lang="en">
<?php include_with_prop(__DIR__ . '/../components/head.php', [
  'title' => 'Poster CMS - Not Found',
  'dirPrefix' => '../',
]); ?>
<body>
<?php require __DIR__ . '/../components/nav/navigation.php'; ?>
<main class="not-found-container">
  <section>
    <h1>404 - Page Not Found</h1>
    <p>Sorry, the page you are looking for does not exist.</p>
    <a href="../index.php">Go to Home</a>
  </section>
</main>

<?php require __DIR__ . '/../components/nav/footer.php'; ?>
</body>
</html>