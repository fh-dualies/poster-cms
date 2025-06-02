<?php
require_once __DIR__ . '/api/get.php';
require_once __DIR__ . '/shared/util.php';
require_once __DIR__ . '/shared/route-enum.php';

check_auth_status();

register_data(\RouteEnum::GET_ALL_POSTERS);
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
            <?php foreach ($_SESSION[\RouteEnum::GET_ALL_POSTERS->get_cache_key()] as $section) {
              include_with_prop(__DIR__ . '/components/poster-item.php', [
                'headline' => htmlspecialchars($section['headline']),
                'creation_date' => htmlspecialchars($section['creation_date']),
                'image' => './static/images/placeholder.jpg',
                'link' => './pages/detail-view.php',
                'meta_data' => htmlspecialchars($section['meta_data']),
              ]);
            } ?>
        </div>
    </section>
</main>

<?php require __DIR__ . '/components/nav/footer.php'; ?>
</body>
</html>
