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
  (() => {
    const lazyImages = document.querySelectorAll('img.lazy');

    function loadImage(img) {
      setTimeout(() => {
        img.src = img.dataset.src;
        img.classList.remove('lazy');
      }, 1000);
    }

    if (!('IntersectionObserver' in window)) {
      lazyImages.forEach(loadImage);
      return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          loadImage(entry.target);
          obs.unobserve(entry.target);
        }
      });
    });

    lazyImages.forEach(img => observer.observe(img));
  })();
</script>