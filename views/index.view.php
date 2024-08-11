<?php
$title = "Products List";
$products = [
	[
		'id' => 1,
		'name' => 'Classic DVD',
		'sku' => 'DVD001',
		'price' => 19.99
	],
	[
		'id' => 2,
		'name' => 'Bestseller Book',
		'sku' => 'BOOK001',
		'price' => 29.99
	],
	[
		'id' => 3,
		'name' => 'Comfy Chair',
		'sku' => 'FURN001',
		'price' => 149.99
	],
	[
		'id' => 4,
		'name' => 'Action DVD',
		'sku' => 'DVD002',
		'price' => 24.99
	],
	[
		'id' => 5,
		'name' => 'Science Fiction Book',
		'sku' => 'BOOK002',
		'price' => 34.99
	],
	[
		'id' => 6,
		'name' => 'Dining Table',
		'sku' => 'FURN002',
		'price' => 299.99
	],
	[
		'id' => 7,
		'name' => 'Comedy DVD',
		'sku' => 'DVD003',
		'price' => 14.99
	],
	[
		'id' => 8,
		'name' => 'Mystery Book',
		'sku' => 'BOOK003',
		'price' => 27.99
	],
	[
		'id' => 9,
		'name' => 'Bookshelf',
		'sku' => 'FURN003',
		'price' => 199.99
	],
	[
		'id' => 10,
		'name' => 'Documentary DVD',
		'sku' => 'DVD004',
		'price' => 22.99
	],
	[
		'id' => 11,
		'name' => 'Cookbook',
		'sku' => 'BOOK004',
		'price' => 39.99
	],
	[
		'id' => 12,
		'name' => 'Office Desk',
		'sku' => 'FURN004',
		'price' => 249.99
	]
];

$nav_title = "Product List (" . count($products) . ")";

$products = json_decode(json_encode($products), false);


include "partials/header.php";
include "partials/body.php";
include "partials/nav.php";
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
	<?php endforeach; ?>

</main>

<?php include "partials/footer.php" ?>
