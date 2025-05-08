<?php
require_once __DIR__ . '/../shared/util.php'; ?>

<html lang="en">
<?php include_with_prop(__DIR__ . '/../components/head.php', [
    'title' => 'Poster CMS - Account',
    'dirPrefix' => '../',
]); ?>
<body>
<?php require __DIR__ . '/../components/navigation.php'; ?>

<main class="container">
  <header>
    <h1>Account settings</h1>
  </header>

  <form>
    <div>
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" />
    </div>

    <div>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" />
    </div>

    <div>
      <label for="x">X:</label>
      <input type="url" id="x" name="x" />
    </div>

    <div>
      <label for="truthsocial">Truth Social:</label>
      <input type="url" id="truthsocial" name="truthsocial" />
    </div>

    <button type="submit">Update Account</button>
  </form>
</main>

<?php require __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
