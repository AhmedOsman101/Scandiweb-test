<?php

use Lib\Helpers;
?>



<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <title>Add Product</title>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" href="/assets/sass/main.css" />

  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
</head>

<body class="bg-gray-950 min-h-dvh text-white">
  <!-- Header Area -->
  <header class="py-6">
    <nav class="flex justify-between px-7">
      <h1 class="font-bold text-2xl">
        Add Product
      </h1>

      <!-- Buttons Area -->
      <div class="flex space-x-6">
        <button class="bg-gray-600 rounded-sm px-3 py-1.5 hover:bg-blue-600 transition-colors duration-300">
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
    <form x-data="{
        Type: 'DVD',
        SKU: '',
        Name: '',
        Price: 0,
        Size: null,
        Weight: null,
        Width: null,
        Height: null,
        Length: null,
        }" class="flex flex-col gap-8 px-5" id="product_form" action="<?= Helpers::route('product.store') ?>"
      method="post">
      <!-- Sku -->
      <label for="sku" class="">
        <span>SKU</span>
        <input x-model="SKU" type="text" id="sku" class="bg-gray-800 rounded-md px-3 py-1" name="sku"
          placeholder="SKU" />
      </label>

      <!-- Name -->
      <label for="name" class="">
        <span>Name</span>
        <input x-model="Name" type="text" id="name" class="bg-gray-800 rounded-md px-3 py-1" name="name"
          placeholder="Name" />
      </label>

      <!-- Price -->
      <label for="price">
        <span>Price</span>
        <div class="flex">
          <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-l-md bg-gray-700">
            $
          </span>
          <input x-model="Price" type="number" min="0" name="price" id="price" placeholder="price"
            class="flex flex-1 sm:text-sm rounded-r-md bg-gray-800" />
        </div>
      </label>

      <!-- Type -->
      <fieldset>
        <label for="productType">
          <span>Type</span>

          <select x-model="Type" type="number" id="productType" class="bg-gray-800 rounded-md px-3 py-2" name="type">
            <option value="DVD">DVD</option>
            <option value="Book">Book</option>
            <option value="Furniture">Furniture</option>
          </select>
        </label>
      </fieldset>

      <!-- DVD Inputs -->
      <fieldset x-show="Type === 'DVD'" id="DVD" class="space-y-5 flex flex-col">
        <label for="size">
          <span>Size</span>

          <div class="flex">
            <input x-model="Size" type="number" min="0" name="size" id="size" placeholder="size"
              class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
            <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
              MB
            </span>
          </div>
        </label>

        <li>
          <span class="text-sm text-gray-500">
            Please provide a valid size for the DVD in Megabytes.
          </span>
        </li>
      </fieldset>

      <!-- BOOK Inputs -->
      <fieldset x-show="Type === 'Book'" id="Book" class="space-y-5 flex flex-col">
        <label for="weight">
          <span>Weight</span>

          <div class="flex">
            <input x-model="Weight" type="number" min="0" name="weight" id="weight" placeholder="weight"
              class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
            <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
              KG
            </span>
          </div>
        </label>

        <li>
          <span class="text-sm text-gray-500">
            Please provide a valid weight for the Book in Kilograms.
          </span>
        </li>
      </fieldset>

      <!-- FURNITURE Inputs -->
      <fieldset x-show="Type === 'Furniture'" id="Furniture"
        class="space-y-5 flex flex-col">
        <label class="font-semibold" for="Furniture">Dimensions:</label>

        <label for="height">
          <span>Height</span>

          <div class="flex">
            <input x-model="Height" type="number" min="0" name="height" id="height" placeholder="height"
              class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
            <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
              CM
            </span>
          </div>
        </label>

        <label for="width">
          <span>Width</span>

          <div class="flex">
            <input x-model="Length" type="number" min="0" name="width" id="width" placeholder="width"
              class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
            <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
              CM
            </span>
          </div>
        </label>
        <label for="length">
          <span>Length</span>

          <div class="flex">
            <input x-model="" type="number" min="0" name="length" id="length" placeholder="length"
              class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
            <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
              CM
            </span>
          </div>
        </label>

        <li>
          <span class="text-sm text-gray-500">
            Please provide valid dimensions for the furniture in the form of height, width and length in Centimeters.
          </span>
        </li>
      </fieldset>
    </form>
  </main>

  <!-- Footer Area -->
  <footer class="py-8 grid place-items-center mt-8">
    <p class="text-center font-semibold">
      Scandiweb Test Assignment &copy; 2024
    </p>
  </footer>
</body>

</html>
