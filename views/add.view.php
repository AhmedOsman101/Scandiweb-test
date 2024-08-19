<?php

use Lib\Helpers;

$homeRoute = Helpers::route('product.index');
?>



<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <title>Add Product</title>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" href="/dist/main.css" />

</head>

<body class="bg-gray-950 min-h-dvh text-white" x-data="formStore">
  <!-- Header Area -->
  <header class="py-6">
    <nav class="flex justify-between px-7">
      <h1 class="font-bold text-2xl">
        Add Product
      </h1>

      <!-- Buttons Area -->
      <div class="flex space-x-6">
        <button
          class="button hover:bg-blue-800"
          @click.debounce="submit($refs.form)">
          Save
        </button>
        <a
          href="<?= Helpers::route('product.index') ?>"
          class="button disabled:cursor-not-allowed hover:bg-red-800">
          Cancel
        </a>
      </div>
    </nav>
  </header>

  <!-- Main Content Area -->
  <main class="grid mt-8 px-3 h-fit">
    <form
      x-ref="form"
      class="flex flex-col gap-8 px-5"
      id="product_form"
      action="<?= Helpers::route('product.store') ?>"
      method="post">

      <!-- Sku -->
      <fieldset>
        <label for="sku">
          <span>SKU</span>
          <input
            id="sku"
            name="sku"
            type="text"
            class="bg-gray-800 rounded-md px-3 py-1"
            placeholder="SKU" />
          <span class="text-sm text-red-500 error mt-4 -mb-4" x-show="errors?.sku" x-text="errors?.sku"></span>
        </label>
      </fieldset>

      <!-- Name -->
      <label for="name">
        <span>Name</span>
        <input
          id="name"
          name="name"
          type="text"
          class="bg-gray-800 rounded-md px-3 py-1"
          placeholder="Name" />
        <span class="text-sm text-red-500 error mt-4 -mb-4" x-show="errors?.name" x-text="errors?.name"></span>
      </label>

      <!-- Price -->
      <label for="price">
        <span>Price</span>
        <div class="flex">
          <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-l-md bg-gray-700">
            $
          </span>
          <input
            id="price"
            name="price"
            type="text"
            placeholder="price"
            class="flex flex-1 sm:text-sm rounded-r-md bg-gray-800" />
        </div>
        <span class="text-sm text-red-500 error mt-4 -mb-4" x-show="errors?.price" x-text="errors?.price"></span>
      </label>

      <!-- Type -->
      <fieldset>
        <label for="productType">
          <span>Type</span>

          <select
            id="productType"
            x-model="type"
            name="type"
            class="bg-gray-800 rounded-md px-3 py-2">
            <option
              :value="types.DVD"
              :selected="type === types.DVD">DVD</option>
            <option
              :value="types.BOOK"
              :selected="type === types.BOOK">Book</option>
            <option
              :value="types.FURNITURE"
              :selected="type === types.FURNITURE">Furniture</option>
          </select>
          <span class="text-sm text-red-500 error mt-4 -mb-4" x-show="errors?.type" x-text="errors?.type"></span>
        </label>
      </fieldset>

      <!-- DVD Inputs -->
      <template x-if="type === types.DVD">
        <fieldset id="DVD" class="space-y-5 flex flex-col">
          <label for="size">
            <span>Size</span>
            <div class="flex">
              <input
                id="size"
                name="size"
                type="text"
                placeholder="size"
                class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
              <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
                MB
              </span>
            </div>
            <span
              class="text-sm text-red-500 error mt-4 -mb-4"
              x-show="errors?.size">
              Please provide a valid size for the DVD in Megabytes
            </span>
          </label>
        </fieldset>
      </template>

      <!-- BOOK Inputs -->
      <template x-if="type === types.BOOK">
        <fieldset id="Book">
          <label for="weight">
            <span>Weight</span>
            <div class="flex">
              <input
                id="weight"
                name="weight"
                type="text"
                placeholder="weight"
                class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
              <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
                KG
              </span>
            </div>
            <span
              class="text-sm text-red-500 error mt-4 -mb-4"
              x-show="errors?.weight">
              Please provide a valid weight for the Book in Kilograms
            </span>
          </label>
        </fieldset>
      </template>

      <!-- FURNITURE Inputs -->
      <template x-if="type === types.FURNITURE">
        <fieldset id="Furniture"
          class="space-y-5 flex flex-col">
          <label class="font-semibold" for="Furniture">Dimensions:</label>
          <input class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" type="hidden" name="dimensions" :value="`${width}x${height}x${length}`">
          <label for="height">
            <span>Height</span>
            <div class="flex">
              <input
                id="height"
                type="text"
                x-model="height"
                placeholder="height"
                class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
              <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
                CM
              </span>
            </div>
          </label>
          <label for="width">
            <span>Width</span>
            <div class="flex">
              <input
                id="width"
                type="text"
                x-model="width"
                placeholder="width"
                class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
              <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
                CM
              </span>
            </div>
          </label>
          <label for="length">
            <span>Length</span>
            <div class="flex">
              <input
                id="length"
                type="text"
                x-model="length"
                placeholder="length"
                class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
              <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
                CM
              </span>
            </div>
            <span
              class="text-sm text-red-500 error mt-4 -mb-4"
              x-show="errors?.dimensions">
              Please provide valid dimensions for the furniture in the form of height, width and length in Centimeters
            </span>
          </label>
        </fieldset>
      </template>
    </form>
  </main>

  <!-- Footer Area -->
  <?php include_once "partials/footer.php" ?>

  <script>
    <?=
    <<<Script
        var types = $types;
        function redirectToHome(){
        window.location = "$homeRoute";
        }
      \n
    Script; ?>
  </script>

  <script type="module" src="/dist/main.js"></script>

</body>

</html>
