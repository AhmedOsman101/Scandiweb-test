<?php

use App\Enums\ProductType;
use Lib\Helpers;

$types = json_encode(Helpers::enumToAssocArray(ProductType::class));
$homeRoute = Helpers::route('product.index');
?>



<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <title>Add Product</title>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" href="/assets/sass/main.css" />

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
        <button class="bg-gray-600 rounded-sm px-3 py-1.5 hover:bg-blue-600 transition-colors duration-300" @click="submit($refs.form)">
          Save
        </button>
        <a href="<?= Helpers::route('product.index') ?>"
          class="bg-gray-600 rounded-sm px-3 py-1.5 hover:bg-red-800 transition-colors duration-300">
          Cancel
        </a>
      </div>
    </nav>
  </header>

  <!-- Main Content Area -->
  <main class="grid mt-8 px-3">
    <form
      novalidate
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
            placeholder="SKU"
            required />
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
          placeholder="Name"
          required />
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
            pattern="[^0-9]"
            min="0"
            placeholder="price"
            class="flex flex-1 sm:text-sm rounded-r-md bg-gray-800"
            required />
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
            class="bg-gray-800 rounded-md px-3 py-2"
            required>
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
        </label>
        <span class="text-sm text-red-500 error mt-4 -mb-4" x-show="errors?.type" x-text="errors?.type"></span>
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
                pattern="[^0-9]"
                min="0"
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
                pattern="[^0-9]"
                min="0"
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
                pattern="[^0-9]"
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
                pattern="[^0-9]"
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
                pattern="[^0-9]"
                x-model="length"
                placeholder="length"
                class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
              <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
                CM
              </span>
            </div>
            <span
              class="text-sm text-red-500 error mt-4 -mb-4"
              x-show="errors?.length || errors?.height || errors?.width || errors?.dimensions">
              Please provide valid dimensions for the furniture in the form of height, width and length in Centimeters
            </span>
          </label>
        </fieldset>
      </template>
    </form>
  </main>

  <!-- Footer Area -->
  <footer class="py-8 grid place-items-center mt-8">
    <p class="text-center font-semibold">
      Scandiweb Test Assignment &copy; <?= date("Y") ?>
    </p>
  </footer>

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

  <script type="module" src="/assets/js/main.js"></script>

</body>

</html>
