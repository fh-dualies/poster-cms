<?php
if (!isset($id) || !isset($image) || !isset($alt) || !isset($name)) {
  throw new Exception('Missing required properties: image, alt, name');
} ?>

<article>
  <div class="preview">
      <?php include_with_prop(__DIR__ . '/lazy-image.php', [
        'src' => $image,
        'alt' => $alt,
      ]); ?>
  </div>

  <div class="info">
    <h5><?php echo $name; ?></h5>
    <form class="unset" method="POST" action="<?php echo FilePathEnum::get_sys_path('api/post.php'); ?>">
      <input type="hidden" name="id" value="<?php echo $id; ?>" />
      <button type="submit" name="delete_media">Delete</button>
    </form>
  </div>
</article>