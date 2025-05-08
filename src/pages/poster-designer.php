<?php
require_once __DIR__ . '/../shared/util.php'; ?>

<html lang="en">
<?php include_with_prop(__DIR__ . '/../components/head.php', [
    'title' => 'Poster CMS - Poster Designer',
    'dirPrefix' => '../',
]); ?>
<body>
<header>
  <div class="container">
    <div class="logo">
      <a href="../index.php">Poster CMS</a>
    </div>
    <nav>
      <ul>
        <li><a href="../index.php">Overview</a></li>
        <li><a href="account.php">Account</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="poster-designer.php">Poster designer</a></li>
        <li><a href="media.php">Media</a></li>
      </ul>
    </nav>
  </div>
</header>

<main class="container">
  <header>
    <h1>Poster Designer</h1>
  </header>

  <form>
    <div>
      <label for="poster-author">Author Name:</label>
      <input
        type="text"
        id="poster-author"
        name="poster-author"
        placeholder="Enter author name"
      />
    </div>

    <div>
      <label for="poster-date">Creation Date:</label>
      <input type="date" id="poster-date" name="poster-date" />
    </div>

    <div>
      <label for="headline">Main Headline:</label>
      <input type="text" id="headline" name="headline" />
    </div>

    <div class="section-editor">
      <div>
        <label for="s1headline">Section 1 Headline:</label>
        <input type="text" id="s1headline" name="s1headline" />
      </div>

      <div>
        <label for="s1text">Section 1 Text:</label>
        <textarea id="s1text" name="s1text"></textarea>
      </div>

      <div>
        <label for="section-1-img">Image:</label>
        <input type="file" id="section-1-img" name="section-1-img" />
      </div>
    </div>

    <div class="section-editor">
      <div>
        <label for="s2headline">Section 2 Headline:</label>
        <input type="text" id="s2headline" name="s2headline" />
      </div>

      <div>
        <label for="s2text">Section 2 Text:</label>
        <textarea id="s2text" name="s2text"></textarea>
      </div>

      <div>
        <label for="section-2-img">Image (Optional):</label>
        <input type="file" id="section-2-img" name="section-2-img" />
      </div>
    </div>

    <div class="section-editor">
      <div>
        <label for="s3headline">Section 3 Headline:</label>
        <input type="text" id="s3headline" name="s3headline" />
      </div>

      <div>
        <label for="s3text">Section 3 Text:</label>
        <textarea id="s3text" name="s3text"></textarea>
      </div>

      <div>
        <label for="section-3-img">Image (Optional):</label>
        <input type="file" id="section-3-img" name="section-3-img" />
      </div>
    </div>

    <div>
      <label for="poster-footer">
        Additional Poster Info (e.g. version):
      </label>
      <input
        type="text"
        id="poster-footer"
        name="poster-footer"
        placeholder="Enter additional meta-data"
      />
    </div>

    <button type="submit">Save Poster</button>
  </form>
</main>

<?php require __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
