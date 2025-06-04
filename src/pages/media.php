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
    <form class="unset" method="POST" enctype="multipart/form-data" action="<?php echo FilePathEnum::get_sys_path(
      'api/post.php'
    ); ?>">
      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo Config::get_max_file_size(); ?>" />

      <div>
        <h2>Drag & Drop Files</h2>
        <p>or</p>

        <label class="button ghost">
          <input id="fileInput" name="file" type="file" accept="image/*" />
          <span>Browse Files</span>
        </label>

        <button id="uploadButton" type="submit" name="create_media" disabled>Upload</button>

        <p id="fileName" class="file-name"></p>
        <p>Supported formats: jpg, png, gif, svg</p>
      </div>
    </form>
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

<script>
  const fileInput = document.getElementById('fileInput');
  const fileName = document.getElementById('fileName');
  const uploadBtn = document.getElementById('uploadButton');

  fileInput.addEventListener('change', () => {
    if (fileInput.files.length) {
      fileName.textContent = fileInput.files[0].name;
      uploadBtn.disabled = false;
    } else {
      fileName.textContent = '';
      uploadBtn.disabled = true;
    }
  });
</script>