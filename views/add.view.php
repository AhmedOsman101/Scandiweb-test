<?php

use Lib\Helpers;

$error = fn($message) => <<<ERROR
<span class="text-sm text-red-500 error mt-4 -mb-4">
  $message
</span>
ERROR;


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
      x-ref="form"
      class="flex flex-col gap-8 px-5"
      id="product_form"
      action="<?= Helpers::route('product.store') ?>"
      method="post">

      <!-- Sku -->
      <fieldset>
        <label for="sku">
          <span>SKU</span>
          <input type="text" id="sku" class="bg-gray-800 rounded-md px-3 py-1" name="sku"
            placeholder="SKU" />
          <span class="text-sm text-red-500 error mt-4 -mb-4" x-show="errors?.sku" x-text="errors?.sku"></span>
        </label>
      </fieldset>

      <!-- Name -->
      <label for="name">
        <span>Name</span>
        <input type="text" id="name" class="bg-gray-800 rounded-md px-3 py-1" name="name"
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
          <input type="number" min="0" name="price" id="price" placeholder="price"
            class="flex flex-1 sm:text-sm rounded-r-md bg-gray-800" />
        </div>
        <span class="text-sm text-red-500 error mt-4 -mb-4" x-show="errors?.price" x-text="errors?.price"></span>
      </label>

      <!-- Type -->
      <fieldset>
        <label for="productType">
          <span>Type</span>

          <select x-model="Type" id="productType" class="bg-gray-800 rounded-md px-3 py-2" name="type">
            <option value="DVD">DVD</option>
            <option value="BOOK">Book</option>
            <option value="FURNITURE">Furniture</option>
          </select>
        </label>
        <span class="text-sm text-red-500 error mt-4 -mb-4" x-show="errors?.type" x-text="errors?.type"></span>
      </fieldset>

      <!-- DVD Inputs -->
      <template x-if="Type === 'DVD'">
        <fieldset id="DVD" class="space-y-5 flex flex-col">
          <label for="size">
            <span>Size</span>
            <div class="flex">
              <input type="number" min="0" name="size" id="size" placeholder="size"
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
      <template x-if="Type === 'BOOK'">
        <fieldset id="Book">
          <label for="weight">
            <span>Weight</span>
            <div class="flex">
              <input type="number" min="0" name="weight" id="weight" placeholder="weight"
                class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
              <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
                KG
              </span>
            </div>
            <span
              class="text-sm text-red-500 error mt-4 -mb-4"
              x-show="errors?.size">
              Please provide a valid weight for the Book in Kilograms
            </span>
          </label>
        </fieldset>
      </template>

      <!-- FURNITURE Inputs -->
      <template x-if="Type === 'FURNITURE'">
        <fieldset id="Furniture"
          class="space-y-5 flex flex-col">
          <label class="font-semibold" for="Furniture">Dimensions:</label>
          <label for="height">
            <span>Height</span>
            <div class="flex">
              <input type="number" min="0" name="height" id="height" placeholder="height"
                class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
              <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
                CM
              </span>
            </div>
          </label>
          <label for="width">
            <span>Width</span>
            <div class="flex">
              <input type="number" min="0" name="width" id="width" placeholder="width"
                class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
              <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
                CM
              </span>
            </div>
          </label>
          <label for="length">
            <span>Length</span>
            <div class="flex">
              <input type="number" min="0" name="length" id="length" placeholder="length"
                class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
              <span class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
                CM
              </span>
            </div>
            <span
              class="text-sm text-red-500 error mt-4 -mb-4"
              x-show="errors?.length || errors?.height || errors?.width">
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
      Scandiweb Test Assignment &copy; 2024
    </p>
  </footer>

  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('formStore', () => ({
        Type: "DVD",
        errors: {},

        validate(form) {
          const data = Object.fromEntries(new FormData(form));
          const errors = {};

          for (const [key, field] of Object.entries(data)) {
            // Empty fields validation
            if (!field) {
              // default message for other empty fields
              errors[key] = `${key} field is required`;
              continue;
            }

          };

          const isValid = Object.keys(errors).length === 0;

          return {
            isValid,
            errors
          };
        },

        submit(form) {
          const {
            isValid,
            errors
          } = this.validate(form);

          if (isValid) form.submit();
          else this.errors = errors;
        }
      }))
    })
  </script>

</body>

</html>
