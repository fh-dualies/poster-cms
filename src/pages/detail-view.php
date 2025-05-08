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
      <button class="secondary">Print</button>
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
    </footer>
  </div>
</main>

<?php require __DIR__ . '/../components/nav/footer.php'; ?>
</body>
</html>
