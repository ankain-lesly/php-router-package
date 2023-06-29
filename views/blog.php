<h2>My Blog</h2>

<?php

$blog_id = $blog_id ?? false;
if ($blog_id) :
?>
  <p>Getting Blog with ID: <?= $blog_id  ?></p>
<?php endif; ?>