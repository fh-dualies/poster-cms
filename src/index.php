<?php
require_once __DIR__ . '/shared/util.php';

$sections = [
  [
    'title' => 'Poster 1',
    'date' => '2025-03-31',
    'datetime' => 'March 31, 2025',
    'image' => './static/images/placeholder.jpg',
    'link' => './pages/detail-view.php',
    'alt' => 'Poster 1 Thumbnail',
  ],
  [
    'title' => 'Poster 2',
    'date' => '2025-03-31',
    'datetime' => 'March 31, 2025',
    'image' => './static/images/placeholder.jpg',
    'link' => './pages/detail-view.php',
    'alt' => 'Poster 2 Thumbnail',
  ],
  [
    'title' => 'Poster 3',
    'date' => '2025-03-31',
    'datetime' => 'March 31, 2025',
    'image' => './static/images/placeholder.jpg',
    'link' => './pages/detail-view.php',
    'alt' => 'Poster 3 Thumbnail',
  ],
];
?>

<html lang="en">
<?php include_with_prop(__DIR__ . '/components/head.php', [
  'title' => 'Poster CMS - Overview',
  'dirPrefix' => './',
]); ?>
<body>
<?php require __DIR__ . '/components/nav/navigation.php'; ?>

<main class="container">
    <header>
        <h1>Overview</h1>
        <a href="./pages/poster-designer.php" class="button">
            Create New Poster
        </a>
    </header>

    <section>
        <h2>All posters</h2>

        <div class="poster-grid">
            <?php foreach ($sections as $section) {
              include_with_prop(__DIR__ . '/components/poster-item.php', $section);
            } ?>
        </div>
    </section>
</main>

<?php require __DIR__ . '/components/nav/footer.php'; ?>
</body>
</html>
