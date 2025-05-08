<?php
require_once __DIR__ . '/../shared/util.php'; ?>

<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Poster CMS - Media</title>
  <link rel="icon" href="../static/images/logo/favicon.ico" sizes="any" />
  <link rel="stylesheet" href="../styles/main.css" />
</head>
<body>
<?php require __DIR__ . '/../components/navigation.php'; ?>

<main class="container">
  <header>
    <h1>Media Library</h1>
  </header>

  <section class="upload-area">
    <div>
      <h2>Drag & Drop Files</h2>
      <p>or</p>
      <label class="button">
        <input type="file" accept="image/*" multiple />
        <span>Browse Files</span>
      </label>
      <p>Supported formats: jpg, png, gif, svg</p>
    </div>
  </section>

  <section>
    <h2>All Media Items</h2>

    <div class="media-grid">
      <article>
        <div class="preview">
          <img src="../static/images/placeholder.jpg" alt="Image 1" />
        </div>

        <div class="info">
          <h5>Media name</h5>
          <button>Delete</button>
        </div>
      </article>

      <article>
        <div class="preview">
          <img src="../static/images/placeholder.jpg" alt="Image 1" />
        </div>

        <div class="info">
          <h5>Media name</h5>
          <button>Delete</button>
        </div>
      </article>

      <article>
        <div class="preview">
          <img src="../static/images/placeholder.jpg" alt="Image 1" />
        </div>

        <div class="info">
          <h5>Media name</h5>
          <button>Delete</button>
        </div>
      </article>

      <article>
        <div class="preview">
          <img src="../static/images/placeholder.jpg" alt="Image 1" />
        </div>

        <div class="info">
          <h5>Media name</h5>
          <button>Delete</button>
        </div>
      </article>
    </div>
  </section>
</main>

<?php require __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
