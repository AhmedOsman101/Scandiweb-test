<?php

$title = "Products List";
$nav_title = "Product List (" . count($products) . ")";

include "partials/header.php";
include "partials/body.php";
?>


<main class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-5 mt-8">
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

<?php include "partials/footer.php" ?>
