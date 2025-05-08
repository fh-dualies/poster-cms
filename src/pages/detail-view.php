<?php
  require_once __DIR__."/../shared/util.php";
?>

<html lang="en">
  <?php
    include_with_prop(
        __DIR__."/../components/head.php", array(
            "title" => "Poster CMS - Detail View",
            "dirPrefix" => "../",
        )
    );
  ?>
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
        <h1>Poster title 1</h1>
        <div>
          <a class="button" href="poster-designer.php">Edit</a>
          <button class="secondary">Print</button>
        </div>
      </header>

      <div class="poster-detail">
        <div class="meta-info">
          <p>Created by: test test</p>
          <time datetime="2025-03-31">March 31, 2025</time>
        </div>

        <section>
          <h3>Section 1</h3>
          <div class="content">
            <p class="content">
              Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
              nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam
              erat, sed diam voluptua. At vero eos et accusam et justo duo
              dolores et ea rebum. Stet clita kasd gubergren, no sea takimata
              sanctus est Lorem ipsum dolor sit amet.
            </p>
            <img
              src="../static/images/placeholder.jpg"
              alt="Detailed view of Poster 1"
            />
          </div>
        </section>

        <section>
          <h3>Section 2</h3>
          <div class="content">
            <p class="content">
              Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
              nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam
              erat, sed diam voluptua. At vero eos et accusam et justo duo
              dolores et ea rebum. Stet clita kasd gubergren, no sea takimata
              sanctus est Lorem ipsum dolor sit amet.
            </p>
            <img
              src="../static/images/placeholder.jpg"
              alt="Detailed view of Poster 1"
            />
          </div>
        </section>

        <section>
          <h3>Section 3</h3>
          <div class="content">
            <p class="content">
              Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
              nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam
              erat, sed diam voluptua. At vero eos et accusam et justo duo
              dolores et ea rebum. Stet clita kasd gubergren, no sea takimata
              sanctus est Lorem ipsum dolor sit amet.
            </p>
            <img
              src="../static/images/placeholder.jpg"
              alt="Detailed view of Poster 1"
            />
          </div>
        </section>

        <footer>
          <p>© 2025 FH Münster - Poster CMS</p>
        </footer>
      </div>
    </main>

    <?php
    require  __DIR__."/../components/footer.php";
    ?>
  </body>
</html>
