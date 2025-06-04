<?php
require_once __DIR__ . '/../api/get.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../shared/route-enum.php';

check_auth_status();

register_data(RouteEnum::GET_ALL_MEDIA);

if (
  !isset($_SESSION[RouteEnum::GET_ALL_MEDIA->get_cache_key()]) ||
  !is_array($_SESSION[RouteEnum::GET_ALL_MEDIA->get_cache_key()])
) {
  redirect_to_page(FilePathEnum::NOT_FOUND);
  exit();
}

$items = [
  [
    'image' => '../static/images/placeholder.jpg',
    'alt' => 'Image 1',
    'name' => 'Media name 1',
  ],
  [
    'image' => '../static/images/placeholder.jpg',
    'alt' => 'Image 2',
    'name' => 'Media name 2',
  ],
  [
    'image' => '../static/images/placeholder.jpg',
    'alt' => 'Image 3',
    'name' => 'Media name 3',
  ],
];
?>

<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Poster CMS - Media</title>
  <link rel="icon" href="../static/images/logo/favicon.ico" sizes="any" />
  <link rel="stylesheet" href="../styles/main.css" />
</head>
<body>
<?php require __DIR__ . '/../components/nav/navigation.php'; ?>

<main class="container">
  <div class="alert-container">
      <?php require __DIR__ . '/../components/alert.php'; ?>
  </div>

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
        <?php foreach ($_SESSION[RouteEnum::GET_ALL_MEDIA->get_cache_key()] as $item) {
          include_with_prop(__DIR__ . '/../components/media-item.php', [
            'id' => $item['id'],
            'name' => htmlspecialchars($item['name']),
            'image' => FilePathEnum::get_sys_path('static/') . $item['path'],
            'alt' => htmlspecialchars($item['alt']),
          ]);
        } ?>
    </div>
  </section>
</main>

<?php require __DIR__ . '/../components/nav/footer.php'; ?>
</body>
</html>
