<?php
if (!isset($headline) || !isset($meta_data) || !isset($image) || !isset($link) || !isset($creation_date)) {
  throw new Exception('Missing required properties: title, alt, image/thumbnail');
} ?>

<article>
  <a href=<?php echo $link; ?>>
    <div class="thumbnail">
        <?php include_with_prop(__DIR__ . '/lazy-image.php', [
          'src' => $image,
          'alt' => $meta_data,
        ]); ?>
    </div>
  </a>
  <div class="info">
    <h2><?php echo $headline; ?></h2>
    <time><?php echo $creation_date; ?></time>
  </div>
</article>