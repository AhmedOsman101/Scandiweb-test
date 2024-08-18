<?php

use Lib\Helpers;
?>

<main class="grid lg:grid-cols-3 grid-cols-2 gap-7 mt-8 px-6">
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
        <?= Helpers::strLimit(Helpers::clean($product['sku']), 20) ?>
      </p>

      <!-- bigger screens -->
      <p class="hidden lg:block">
        <?= Helpers::strLimit(Helpers::clean($product['name']), 20) ?>
      </p>

      <p class="hidden lg:block">
        $<?= Helpers::clean(number_format($product['price'], 2)) ?>
      </p>

      <!-- smaller screens -->
      <p class="block lg:hidden">
        <?= Helpers::strLimit(Helpers::clean($product['name']), 20) ?>
      </p>

      <p class="block lg:hidden">
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

  <?php endforeach; ?>
</main>
