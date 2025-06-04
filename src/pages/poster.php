<?php
require_once __DIR__ . '/../api/get.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../shared/file-path-enum.php';

check_auth_status();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  redirect_to_page(FilePathEnum::NOT_FOUND);
  exit();
}

register_data(RouteEnum::GET_POSTER_DETAIL, intval($_GET['id']));

if (
  !isset($_SESSION[RouteEnum::GET_POSTER_DETAIL->get_cache_key()]) ||
  !is_array($_SESSION[RouteEnum::GET_POSTER_DETAIL->get_cache_key()])
) {
  redirect_to_page(FilePathEnum::NOT_FOUND);
  exit();
}

$poster = $_SESSION[RouteEnum::GET_POSTER_DETAIL->get_cache_key()];
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
    <h1><?php echo htmlspecialchars($poster['headline']); ?></h1>
    <div>
      <a class="button" href="create.php">Edit</a>
      <a class="button secondary" onclick="openPoster()">Print</a>
    </div>
  </header>

  <div class="poster-detail">
    <div class="meta-info">
      <p>Created by: <?php echo htmlspecialchars($poster['author']); ?></p>
      <time><?php echo htmlspecialchars($poster['creation_date']); ?></time>
    </div>

      <?php foreach ($poster['sections'] as $section) {
        include_with_prop(__DIR__ . '/../components/poster-section.php', [
          'headline' => htmlspecialchars($section['headline']),
          'text' => htmlspecialchars($section['text']),
          'image' => FilePathEnum::get_sys_path('static/') . $section['media']['path'] ?? null,
          'alt' => htmlspecialchars($section['media']['alt'] ?? ''),
        ]);
      } ?>

    <footer>
      <p>© 2025 FH Münster - Poster CMS</p>
    </footer>
  </div>
</main>

<?php require __DIR__ . '/../components/nav/footer.php'; ?>
</body>

<script>
  function openPoster() {
    const choice = prompt('Open A3 or A4 format? (A3/A4)');

    if (!choice) {
      return;
    }

    const format = choice.trim().toUpperCase();

    if (format === 'A3') {
      window.open('../../posters/a3.html', '_blank');
    } else if (format === 'A4') {
      window.open('../../posters/a4.html', '_blank');
    } else {
      alert('Unknown format. Please enter either A3 or A4.');
    }
  }
</script>

</html>
