<?php
$headerTitle = trim(get_the_title());
?>
<header class="entry-header h-96 flex items-center justify-center relative bg-gradient-to-b from-primary to-slate-700">
  <div class="absolute inset-0 flex items-center justify-center">
    <h2 class=" text-6xl font-medium z-10 text-white uppercase"><?= $headerTitle; ?></h2>
  </div>
</header>