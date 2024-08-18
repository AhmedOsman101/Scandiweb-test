<?php

use Lib\Helpers;
?>

<main class="grid lg:grid-cols-4 grid-cols-2 gap-7 mt-8 px-6">
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
