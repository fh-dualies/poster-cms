<?php
require_once __DIR__ . '/../../api/get.php';
require_once __DIR__ . '/../../shared/util.php';
require_once __DIR__ . '/../../shared/file-path-enum.php';

check_auth_status();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  redirect_to_page(FilePathEnum::NOT_FOUND);
  exit();
}

register_data(RouteEnum::GET_POSTER_DETAIL, intval($_GET['id']));

if (
  !isset($_SESSION[RouteEnum::GET_POSTER_DETAIL->get_cache_key()]) ||
  !is_array($_SESSION[RouteEnum::GET_POSTER_DETAIL->get_cache_key()]) ||
  empty($_SESSION[RouteEnum::GET_POSTER_DETAIL->get_cache_key()])
) {
  redirect_to_page(FilePathEnum::NOT_FOUND);
  exit();
}

$poster = $_SESSION[RouteEnum::GET_POSTER_DETAIL->get_cache_key()];
?>

<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>A4 Poster</title>
  <link href="../../styles/poster.css" rel="stylesheet" />
</head>
<body>
<main class="page-container layout-a4">
  <header class="page-header"><?php echo htmlspecialchars($poster['headline']); ?></header>

  <div class="content-area">
      <?php foreach ($poster['sections'] as $index => $section) {
        include_with_prop(__DIR__ . '/elements/horizontal-poster-element.php', [
          'index' => $index,
          'headline' => htmlspecialchars($section['headline']),
          'text' => htmlspecialchars($section['text']),
          'image' => FilePathEnum::get_sys_path('static/') . $section['media']['path'] ?? null,
          'alt' => htmlspecialchars($section['media']['alt'] ?? ''),
        ]);
      } ?>
  </div>

  <footer class="page-footer"><?php echo htmlspecialchars($poster['meta_data']); ?></footer>
</main>

<a href="javascript:window.print()" id="print-btn" class="button">Print</a>

<script src="../../shared/js/draggable.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    new DraggableGrid('.content-area', '.content-item');
  });
</script>

</body>
</html>
