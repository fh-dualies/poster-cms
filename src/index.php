<?php
  require_once __DIR__."/shared/util.php";
?>

<html lang="en">
  <?php
    include_with_prop(
        __DIR__."/components/head.php", array(
            "title" => "Poster CMS - Overview",
        )
    );
  ?>

  <body>
    <header>
      <div class="container">
        <div class="logo">
          <a href="./index.php">Poster CMS</a>
        </div>
        <nav>
          <ul>
            <li><a href="./index.php">Overview</a></li>
            <li><a href="./pages/account.html">Account</a></li>
            <li><a href="./pages/login.html">Login</a></li>
            <li><a href="./pages/poster-designer.html">Poster designer</a></li>
            <li><a href="./pages/media.html">Media</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <main class="container">
      <header>
        <h1>Poster CMS Overview</h1>
        <a href="./pages/poster-designer.html" class="button">
          Create New Poster
        </a>
      </header>

      <section>
        <h2>All posters</h2>

        <div class="poster-grid">
          <article>
            <a href="./pages/detail-view.html">
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
            <a href="./pages/detail-view.html">
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
            <a href="./pages/detail-view.html">
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

    <footer>
      <div class="container">
        <div>
          <p>&copy; 2025 FH Münster - Labor für Softwarearchitektur</p>
          <p>Creative Technologies Lab - Web Development I</p>
        </div>
        <nav>
          <ul>
            <li>
              <a href="">About</a>
            </li>
            <li>
              <a href="">Privacy Policy</a>
            </li>
            <li>
              <a href="">Terms of Use</a>
            </li>
            <li>
              <a href="">Contact</a>
            </li>
          </ul>
        </nav>
      </div>
    </footer>
  </body>
</html>
