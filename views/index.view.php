<?php

use Lib\Helpers;

$navTitle = "Products List (" . count($products) . ")";

?>

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

  <link rel="stylesheet" href="/assets/sass/main.css" />
</head>

<body class="bg-gray-950 text-white" x-data="selectStore">
  <header class="py-6">
    <nav class="flex justify-between px-7">
      <h1 class="font-bold text-2xl">
        <?= $navTitle ?>
      </h1>

      <div class="flex space-x-6">
        <a
          href="add-product"
          class="bg-gray-600 rounded-sm px-3 py-1.5 hover:bg-blue-600 transition-colors duration-300">
          ADD
        </a>
        <form
          action="<?= Helpers::route("product.destroy") ?>"
          method="post">
          <input type="hidden" name="_ids" :value="JSON.stringify(selected)">
          <input type="hidden" name="_method" value="DELETE">
          <button
            type="submit"
            class="bg-gray-600 rounded-sm px-3 py-1.5 hover:bg-red-800 disabled:cursor-not-allowed transition-colors duration-300"
            :disabled="selected.length === 0"
            id="delete-product-btn">
            MASS DELETE
          </button>
        </form>
      </div>
    </nav>
  </header>

  <main class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-7 mt-8 px-6">
    <?php foreach ($products as $product): ?>
      <?php
      $config = $productConfigs[$product['type']];
      ?>
      <label
        class="card border p-4 flex flex-col gap-3 bg-gray-800 items-center cursor-pointer relative">

        <input
          type="checkbox"
          name="check"
          @click="toggleSelect(<?= $product['id'] ?>)"
          class="delete-checkbox self-start ml-4 mt-4 rounded cursor-pointer absolute left-0 top-0" />

        <p>
          <?= Helpers::clean($product['sku']) ?>
        </p>

        <p>
          <?= Helpers::clean($product['name']) ?>
        </p>

        <p>
          <?= Helpers::clean(number_format($product['price'], 2)) ?> $
        </p>

        <p>
          <span class="capitalize">
            <!-- gets the label of the field -->
            <?= $config['label'] ?>:
          </span>

          <span>
            <?= Helpers::clean($product[$config['field']]) ?>
          </span>

          <span class="uppercase">
            <?= $config['suffix'] ?>
          </span>
        </p>
      </label>

      </div>
    <?php endforeach; ?>

  </main>
  <footer class="py-8 grid place-items-center mt-8">
    <p class="text-center font-semibold">
      Scandiweb Test Assignment &copy; <?= date("Y") ?>
    </p>
  </footer>

  <script type="module" src="/assets/js/main.js"></script>
</body>

</html>
