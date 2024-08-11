<header class="py-6">
  <nav class="flex justify-between px-7">
    <h1 class="font-bold text-2xl">
      <?= $nav_title ?>

    </h1>

    <div class="flex space-x-6">
      <?php
      include $_SERVER['REQUEST_URI'] === '/' ? 'home_buttons.php' : 'add_button.php';
      ?>
    </div>
  </nav>
</header>
<hr />
