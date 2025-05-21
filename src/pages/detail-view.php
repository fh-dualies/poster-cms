<?php
require_once __DIR__ . '/../shared/util.php';

$sections = [
  [
    'title' => 'Section 1',
    'text' => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
          nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam
          erat, sed diam voluptua. At vero eos et accusam et justo duo
          dolores et ea rebum. Stet clita kasd gubergren, no sea takimata
          sanctus est Lorem ipsum dolor sit amet.",
    'image' => '../static/images/placeholder.jpg',
    'alt' => 'Detailed view of Poster 1',
  ],
  [
    'title' => 'Section 2',
    'text' => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
          nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam
          erat, sed diam voluptua. At vero eos et accusam et justo duo
          dolores et ea rebum. Stet clita kasd gubergren, no sea takimata
          sanctus est Lorem ipsum dolor sit amet.",
    'image' => '../static/images/placeholder.jpg',
    'alt' => 'Detailed view of Poster 2',
  ],
  [
    'title' => 'Section 3',
    'text' => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
          nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam
          erat, sed diam voluptua. At vero eos et accusam et justo duo
          dolores et ea rebum. Stet clita kasd gubergren, no sea takimata
          sanctus est Lorem ipsum dolor sit amet.",
    'image' => '../static/images/placeholder.jpg',
    'alt' => 'Detailed view of Poster 3',
  ],
];
?>

<html lang="en">
<?php include_with_prop(__DIR__ . '/../components/head.php', [
  'title' => 'Poster CMS - Detail View',
  'dirPrefix' => '../',
]); ?>
<body>
<?php require __DIR__ . '/../components/nav/navigation.php'; ?>
<main class="container">
  <header>
    <h1>Poster title 1</h1>
    <div>
      <a class="button" href="poster-designer.php">Edit</a>
      <a class="button secondary" onclick="openPoster()">Print</a>
    </div>
  </header>

  <div class="poster-detail">
    <div class="meta-info">
      <p>Created by: test test</p>
      <time datetime="2025-03-31">March 31, 2025</time>
    </div>


      <?php foreach ($sections as $section) {
        include_with_prop(__DIR__ . '/../components/poster-section.php', [
          'title' => $section['title'],
          'text' => $section['text'],
          'image' => $section['image'],
          'alt' => $section['alt'],
        ]);
      } ?>

    <footer>
      <p>© 2025 FH Münster - Poster CMS</p>
    </footer>x
  </div>
</main>

<?php require __DIR__ . '/../components/nav/footer.php'; ?>
</body>

<script>
    function openPoster() {
        const choice = prompt("Open A3 or A4 format? (A3/A4)");

        if (!choice) return;

        const format = choice.trim().toUpperCase();

        if (format === "A3") {
            window.open("http://localhost:63342/Praktikum/posters/a3.html", "_blank");
        } else if (format === "A4") {
            window.open("http://localhost:63342/Praktikum/posters/a4.html", "_blank");
        } else {
            alert("Unknown format. Please enter either A3 or A4.");
        }
    }
</script>

</html>
