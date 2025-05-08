<?php
require_once __DIR__ . '/shared/util.php'; ?>

<html lang="en">
<?php include_with_prop(__DIR__ . '/components/head.php', [
    'title' => 'Poster CMS - Overview',
    'dirPrefix' => './',
]); ?>
<body>
<?php require __DIR__ . '/components/navigation.php'; ?>

<main class="container">
  <header>
    <h1>Poster CMS Overview</h1>
    <a href="./pages/poster-designer.php" class="button">
      Create New Poster
    </a>
  </header>

  <section>
    <h2>All posters</h2>

    <div class="poster-grid">
      <article>
        <a href="./pages/detail-view.php">
          <div class="thumbnail">
            <img
              src="./static/images/placeholder.jpg"
              alt="Poster 1 Thumbnail"
            />
          </div>
        </a>
        <div class="info">
          <h2>Poster 1</h2>
          <time datetime="2025-03-31">March 31, 2025</time>
        </div>
      </article>

      <article>
        <a href="./pages/detail-view.php">
          <div class="thumbnail">
            <img
              src="./static/images/placeholder.jpg"
              alt="Poster 2 Thumbnail"
            />
          </div>
        </a>
        <div class="info">
          <h2>Poster 2</h2>
          <time datetime="2025-03-31">March 31, 2025</time>
        </div>
      </article>

      <article>
        <a href="./pages/detail-view.php">
          <div class="thumbnail">
            <img
              src="./static/images/placeholder.jpg"
              alt="Poster 3 Thumbnail"
            />
          </div>
        </a>
        <div class="info">
          <h2>Poster 3</h2>
          <time datetime="2025-03-31">March 31, 2025</time>
        </div>
      </article>
    </div>
  </section>
</main>

<?php require __DIR__ . '/components/footer.php'; ?>
</body>
</html>
