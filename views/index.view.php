<?php

use Lib\Helpers;

$productsCount = count($products);

$navTitle = "Products List";
$navTitle .= empty($productsCount) ?: " ($productsCount)";
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

  <!-- flashMessages area -->
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

  <!-- Header Area -->
  <header class="py-6">
    <nav class="flex justify-between px-7">
      <h1 class="font-semibold text-lg md:text-2xl md:font-bold">
        <?= $navTitle ?>
      </h1>

      <!-- Buttons Area -->
      <div class="flex space-x-3 md:space-x-6">
        <a
          href="add-product"
          class="button hover:bg-blue-800">
          ADD
        </a>
        <form
          action="<?= Helpers::route("product.destroy") ?>"
          method="post">
          <input type="hidden" name="_ids" :value="JSON.stringify(selected)">
          <input type="hidden" name="_method" value="DELETE">
          <button
            type="submit"
            class="button disabled:cursor-not-allowed hover:bg-red-800"
            id="delete-product-btn">
            MASS DELETE
          </button>
        </form>
      </div>
    </nav>
  </header>

  <!-- Main Content Area -->
  <?php if (empty($productsCount)): ?>
    <?php include_once "partials/noProducts.php" ?>
  <?php else: ?>
    <?php include_once "partials/products.php" ?>
  <?php endif; ?>

  <!-- Footer Area -->
  <?php include_once "partials/footer.php" ?>


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
