<?php
require_once __DIR__ . '/api/get.php';
require_once __DIR__ . '/shared/util.php';
require_once __DIR__ . '/shared/route-enum.php';

check_auth_status();

register_data(RouteEnum::GET_ALL_POSTERS);

if (
  !isset($_SESSION[RouteEnum::GET_ALL_POSTERS->get_cache_key()]) ||
  !is_array($_SESSION[RouteEnum::GET_ALL_POSTERS->get_cache_key()])
) {
  redirect_to_page(FilePathEnum::NOT_FOUND);
  exit();
}
?>

<html lang="en">
<?php include_with_prop(__DIR__ . '/components/head.php', [
  'title' => 'Poster CMS - Overview',
  'dirPrefix' => './',
]); ?>
<body>
<?php require __DIR__ . '/components/nav/navigation.php'; ?>

<main class="container">
  <div class="alert-container">
      <?php require __DIR__ . '/components/alert.php'; ?>
  </div>

  <header>
    <h1>Overview</h1>
    <a href="./pages/create.php" class="button">
      Create New Poster
    </a>
  </header>

  <section>
    <div class="section-header">
      <h2>All posters</h2>
      <div class="poster-sort">
        <button id="sort-newest" class="button secondary active">Newest First</button>
        <button id="sort-oldest" class="button secondary">Oldest First</button>
      </div>
    </div>

      <?php if (empty($_SESSION[RouteEnum::GET_ALL_POSTERS->get_cache_key()])) {
        require __DIR__ . '/components/empty-state.php';
      } ?>

      <div class="poster-grid" id="posterGrid">
          <?php foreach ($_SESSION[RouteEnum::GET_ALL_POSTERS->get_cache_key()] as $section) {
            $creationDate = htmlspecialchars($section['creation_date']); ?>
              <div class="poster-item" draggable="true" data-date="<?php echo $creationDate; ?>">
                  <?php include_with_prop(__DIR__ . '/components/poster-item.php', [
                    'headline' => htmlspecialchars($section['headline']),
                    'creation_date' => $creationDate,
                    'image' => './static/images/placeholder.jpg', // TODO: replace
                    'link' => './pages/poster.php?id=' . htmlspecialchars($section['id']),
                    'meta_data' => htmlspecialchars($section['meta_data']),
                  ]); ?>
              </div>
          <?php
          } ?>
      </div>
  </section>
</main>

<?php require __DIR__ . '/components/nav/footer.php'; ?>

<script>
    const grid = document.getElementById('posterGrid');
    const btnNewest = document.getElementById('sort-newest');
    const btnOldest = document.getElementById('sort-oldest');

    function sortGrid(isOldestFirst) {
        const items = Array.from(grid.children);

        items.sort((a, b) => {
            const dateA = new Date(a.dataset.date);
            const dateB = new Date(b.dataset.date);
            return isOldestFirst ? dateA - dateB : dateB - dateA;
        });

        items.forEach(item => grid.appendChild(item));
    }

    btnNewest.addEventListener('click', () => {
        sortGrid(false);
        btnNewest.classList.add('active');
        btnOldest.classList.remove('active');
    });

    btnOldest.addEventListener('click', () => {
        sortGrid(true);
        btnOldest.classList.add('active');
        btnNewest.classList.remove('active');
    });

    sortGrid(false);
</script>
<script>
    let draggedEl = null;

    document.querySelectorAll('.poster-item').forEach(item => {
        item.addEventListener('dragstart', (e) => {
            draggedEl = item;
            item.style.opacity = '0.5';
        });

        item.addEventListener('dragend', () => {
            draggedEl = null;
            document.querySelectorAll('.poster-item').forEach(el => el.style.opacity = '1');
        });

        item.addEventListener('dragover', (e) => {
            e.preventDefault();
        });

        item.addEventListener('drop', (e) => {
            e.preventDefault();
            if (draggedEl === item) return;

            const container = document.getElementById('posterGrid');
            const draggedIndex = [...container.children].indexOf(draggedEl);
            const targetIndex = [...container.children].indexOf(item);

            if (draggedIndex < targetIndex) {
                container.insertBefore(draggedEl, item.nextSibling);
            } else {
                container.insertBefore(draggedEl, item);
            }
        });
    });
</script>

</body>
</html>
