<?php
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../api/get.php';

check_auth_status();

$formSections = [
  [
    'prefix' => 's1',
    'name' => 'Section 1',
  ],
  [
    'prefix' => 's2',
    'name' => 'Section 2',
  ],
  [
    'prefix' => 's3',
    'name' => 'Section 3',
  ],
];

$poster_id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$poster = null;

if ($poster_id !== null) {
  register_data(RouteEnum::GET_POSTER_DETAIL, $poster_id);
  $poster = $_SESSION[RouteEnum::GET_POSTER_DETAIL->get_cache_key()] ?? null;

  if (!$poster || !is_array($poster)) {
    redirect_to_page(FilePathEnum::NOT_FOUND);
    exit();
  }
}
?>

<html lang="en">
<?php include_with_prop(__DIR__ . '/../components/head.php', [
  'title' => 'Poster CMS - Poster Designer',
  'dirPrefix' => '../',
]); ?>
<body>
<?php require __DIR__ . '/../components/nav/navigation.php'; ?>
<main class="container">
  <div class="alert-container">
      <?php require __DIR__ . '/../components/alert.php'; ?>
  </div>

  <header>
    <h1>Poster Designer</h1>
  </header>

  <form method="POST" action="<?php echo FilePathEnum::get_sys_path('api/post.php'); ?>">
      <?php if (isset($poster_id)): ?>
          <input type="hidden" name="poster_id" value="<?php echo htmlspecialchars($poster_id); ?>">
      <?php endif; ?>
      <div>
        <label for="poster-author">Author Name:</label>
        <input
          type="text"
          id="poster-author"
          name="poster-author"
          placeholder="Enter author name"
          value="<?php echo htmlspecialchars($poster['author'] ?? ''); ?>"
        />
    </div>

    <div>
      <label for="poster-date">Creation Date:</label>
      <input
        type="date"
        id="poster-date"
        name="poster-date"
        value="<?php echo htmlspecialchars($poster['creation_date'] ?? ''); ?>"
      />
    </div>

    <div>
      <label for="headline">Main Headline:</label>
      <input
        type="text"
        id="headline"
        name="headline"
        value="<?php echo htmlspecialchars($poster['headline'] ?? ''); ?>"
      />
    </div>

      <?php foreach ($formSections as $index => $section) {
        $sectionData = $poster['sections'][$index] ?? null;

        include_with_prop(__DIR__ . '/../components/poster-section-form.php', [
          'prefix' => htmlspecialchars($section['prefix']),
          'name' => htmlspecialchars($section['name']),
          'data' => $sectionData,
        ]);
      } ?>

    <div>
      <label for="poster-footer">
        Additional Poster Info (e.g., version):
      </label>
      <input
        type="text"
        id="poster-footer"
        name="poster-footer"
        placeholder="Enter additional meta-data"
        value="<?php echo htmlspecialchars($poster['meta_data'] ?? ''); ?>"
      />
    </div>
    <button type="submit" name="create_poster">Save Poster</button>
    <button type="submit" name="delete_poster" class="danger">Delete Poster</button>
  </form>
</main>

<?php require __DIR__ . '/../components/nav/footer.php'; ?>
</body>
</html>
