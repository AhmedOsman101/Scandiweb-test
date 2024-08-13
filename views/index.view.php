<?php $nav_title = "Products List (" . count($products) . ")" ?>

<!DOCTYPE html>
<html
  lang="en"
  class="dark">

<head>
  <title>Products List</title>

  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1" />


  <script
    defer
    src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

  <link
    rel="stylesheet"
    href="/assets/sass/main.css" />
</head>

<body class="bg-gray-950 text-white">
  <header class="py-6">
    <nav class="flex justify-between px-7">
      <h1 class="font-bold text-2xl">
        <?= $nav_title ?>
      </h1>

      <div class="flex space-x-6">
        <a
          href="add-product"
          class="bg-gray-600 rounded-sm px-3 py-1.5 hover:bg-blue-600 transition-colors duration-300">
          ADD
        </a>
        <button
          class="bg-gray-600 rounded-sm px-3 py-1.5 hover:bg-red-800 transition-colors duration-300"
          id="delete-product-btn">
          MASS DELETE
        </button>
      </div>
    </nav>
  </header>



  <main class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-7 mt-8 px-6">
    <?php foreach ($products as $product): ?>
      <div
        class="border p-4 flex flex-col gap-3 bg-gray-800 items-center">
        <input
          type="checkbox"
          name="check"
          class="delete-checkbox self-start ml-4 rounded" />

        <h2>
          <span>Name:</span>
          <?= htmlspecialchars($product->name) ?>
        </h2>

        <p>
          <span>SKU:</span> <?= htmlspecialchars($product->sku) ?>
        </p>

        <p>Price: $<?= number_format($product->price, 2) ?></p>
      </div>

      </div>
    <?php endforeach; ?>

  </main>
  <footer class="py-8 grid place-items-center mt-8">
    <p class="text-center font-semibold">
      Scandiweb Test Assignment &copy; 2024
    </p>
  </footer>
</body>

</html>
