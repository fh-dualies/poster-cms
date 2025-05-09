<?php
require_once __DIR__ . '/../shared/util.php';

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
?>

<html lang="en">
<?php include_with_prop(__DIR__ . '/../components/head.php', [
  'title' => 'Poster CMS - Poster Designer',
  'dirPrefix' => '../',
]); ?>
<body>
<?php require __DIR__ . '/../components/nav/navigation.php'; ?>
<main class="container">
  <header>
    <h1>Poster Designer</h1>
  </header>

  <form>
    <div>
      <label for="poster-author">Author Name:</label>
      <input
        type="text"
        id="poster-author"
        name="poster-author"
        placeholder="Enter author name"
      />
    </div>

    <div>
      <label for="poster-date">Creation Date:</label>
      <input type="date" id="poster-date" name="poster-date" />
    </div>

    <div>
      <label for="headline">Main Headline:</label>
      <input type="text" id="headline" name="headline" />
    </div>

      <?php foreach ($formSections as $section) {
        include_with_prop(__DIR__ . '/../components/poster-section-form.php', [
          'prefix' => $section['prefix'],
          'name' => $section['name'],
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
      />
    </div>

    <button type="submit">Save Poster</button>
  </form>
</main>

<?php require __DIR__ . '/../components/nav/footer.php'; ?>
</body>
</html>
