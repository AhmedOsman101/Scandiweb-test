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

  <link rel="stylesheet" href="/dist/main.css" />
</head>

<body class="bg-gray-950 text-white" x-data="homeStore">

  <div
    id="toast-default"
    role="alert"
    x-data="flashError"
    x-show="showFlash"
    x-init="showFlashMessage()"
    x-transition.scale.origin.right>
    <div
      class="inline-flex items-center justify-center w-12 h-full rounded-l-lg p-2 bg-red-500">
      <svg
        class="w-6 h-6 text-white fill-current"
        viewBox="0 0 40 40"
        xmlns="http://www.w3.org/2000/svg">
        <path
          d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z" />
      </svg>
    </div>

    <div class="pr-4 ml-2">
      <div class="mx-3">
        <span class="font-semibold text-red-500 dark:text-red-400 mb-2">Error</span>
        <p class="text-sm text-gray-600 dark:text-gray-200" x-text="error">

        </p>
      </div>
    </div>

    <button type="button" class="ml-auto mr-2 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-collapse-toggle="toast-default" aria-label="Close" @click="toggleFlash">
      <span class="sr-only">Close</span>
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
      </svg>
    </button>
  </div>

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

  <script>
    <?=
    <<<Script
        var error = $error;\n
    Script;
    ?>
  </script>
  <script type="module" src="/dist/main.js"></script>
</body>

</html>
