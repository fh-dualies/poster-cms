<?php

if (!isset($src, $alt)) {
  throw new Exception('Missing required properties: src, alt');
}

$placeholder = FilePathEnum::get_sys_path('/static/images/placeholder.png');

$classes = ['lazy'];
if (isset($class)) {
  $classes[] = $class;
}
$imgClass = implode(' ', $classes);
?>

<img
  class="<?= $imgClass ?>"
  src="<?= $placeholder ?>"
  data-src="<?= $src ?>"
  alt="<?= $alt ?>"
/>

<script>
  (function() {
    const lazyImages = document.querySelectorAll('img.lazy');

    function loadImage(img) {
      img.src = img.dataset.src;
      img.classList.remove('lazy');
    }

    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            loadImage(entry.target);
            obs.unobserve(entry.target);
          }
        });
      });

      lazyImages.forEach(img => observer.observe(img));
    } else {
      lazyImages.forEach(loadImage);
    }
  })();
</script>