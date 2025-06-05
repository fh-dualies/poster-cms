<?php
if (!isset($name) || !isset($prefix)) {
  throw new Exception('Missing required properties: name, prefix');
}

$headline = htmlspecialchars($data['headline'] ?? '');
$text = htmlspecialchars($data['text'] ?? '');
$imgAlt = htmlspecialchars($data['media']['alt'] ?? '');
?>

<div class="section-editor">
  <div>
    <label for="<?php echo $prefix; ?>headline"><?php echo $name; ?> Headline:</label>
    <input
      type="text"
      id="<?php echo $prefix; ?>headline"
      name="<?php echo $prefix; ?>headline"
      value="<?php echo $headline; ?>"
    />
  </div>

  <div>
    <label for="<?php echo $prefix; ?>text"><?php echo $name; ?> Text:</label>
    <textarea
      id="<?php echo $prefix; ?>text"
      name="<?php echo $prefix; ?>text"
    ><?php echo $text; ?></textarea>
  </div>

  <div>
    <label for="<?php echo $prefix; ?>img">Image (Optional):</label>
    <input type="file" id="<?php echo $prefix; ?>img" name="<?php echo $prefix; ?>img" />
    <?php if (!empty($data['media']['path'])): ?>
      <p>Current image: <?php echo htmlspecialchars(basename($data['media']['path'])); ?></p>
      <img src="<?php echo FilePathEnum::get_sys_path('static/') . htmlspecialchars($data['media']['path']); ?>"
           alt="<?php echo $imgAlt; ?>"
           style="max-width: 200px; margin-top: 8px;" />
    <?php endif; ?>
  </div>
</div>
